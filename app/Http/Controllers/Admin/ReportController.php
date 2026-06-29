<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\User;
use App\Models\StudentGrade;
use App\Models\AttendanceSession;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ReportController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::with('course')->get();
        return view('admin.reports.index', compact('classes'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'report_type' => 'required|string',
        ]);

        $type = $request->report_type;

        // SYSTEM-WIDE REPORTS
        if ($type === 'population_demographics') {
            return $this->generatePopulationDemographics();
        }
        elseif ($type === 'financial_income') {
            return $this->generateFinancialIncome($request);
        }
        elseif ($type === 'teacher_attendance') {
            return $this->generateTeacherAttendance($request);
        }

        // CLASS-SPECIFIC REPORTS
        $request->validate([
            'class_id' => 'required|exists:classes,id',
        ]);
        $class = SchoolClass::with(['course', 'teacher', 'students'])->findOrFail($request->class_id);

        if ($type === 'student_summary') {
            $pdf = Pdf::loadView('admin.reports.pdf.student_summary', compact('class'));
            return $pdf->stream("Student_Summary_{$class->name}.pdf");
        } 
        elseif ($type === 'report_card') {
            $request->validate(['student_id' => 'required|exists:users,id']);
            $student = User::findOrFail($request->student_id);
            $grade = StudentGrade::where('class_id', $class->id)->where('student_id', $student->id)->first();
            
            $listening = $grade->listening ?? 0;
            $speaking = $grade->speaking ?? 0;
            $reading = $grade->reading ?? 0;
            $writing = $grade->writing ?? 0;
            $grammar = $grade->grammar ?? 0;
            $attendance = $grade->attendance ?? 0;

            $radarChartUrl = "https://quickchart.io/chart?w=400&h=400&c=" . urlencode(json_encode([
                'type' => 'radar',
                'data' => [
                    'labels' => ['Listening', 'Speaking', 'Reading', 'Writing', 'Grammar', 'Attendance'],
                    'datasets' => [
                        [
                            'label' => 'Student Score',
                            'data' => [$listening, $speaking, $reading, $writing, $grammar, $attendance],
                            'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                            'borderColor' => '#10b981',
                            'pointBackgroundColor' => '#10b981'
                        ]
                    ]
                ],
                'options' => [
                    'scale' => ['ticks' => ['min' => 0, 'max' => 100]]
                ]
            ]));

            $radarChartBase64 = base64_encode(Http::withoutVerifying()->get($radarChartUrl)->body());
            $pdf = Pdf::loadView('admin.reports.pdf.report_card', compact('class', 'student', 'grade', 'radarChartBase64'));
            return $pdf->stream("Report_Card_{$student->name}.pdf");
        } 
        elseif ($type === 'attendance_record') {
            return $this->generateAttendanceRecord($class);
        }

        return back()->with('error', 'Invalid report type selected.');
    }

    private function generateTeacherAttendance(Request $request)
    {
        $query = \App\Models\AttendanceSession::whereNotNull('teacher_time_in')->with(['teacher', 'schoolClass.course']);

        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $filterInfo = [];
        if ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $query->whereDate('session_date', \Carbon\Carbon::today());
                    $filterInfo['period'] = 'Today';
                    break;
                case 'this_week':
                    $query->whereBetween('session_date', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()]);
                    $filterInfo['period'] = 'This Week';
                    break;
                case 'this_month':
                    $query->whereMonth('session_date', \Carbon\Carbon::now()->month)
                          ->whereYear('session_date', \Carbon\Carbon::now()->year);
                    $filterInfo['period'] = 'This Month';
                    break;
            }
        }

        $attendances = $query->orderBy('session_date', 'asc')->get();
        foreach ($attendances as $att) {
            $att->date = $att->session_date;
            $att->time_in = $att->teacher_time_in;
            $att->time_out = $att->teacher_time_out;
            $att->status = $att->teacher_attendance_status;
        }

        if ($request->format === 'excel') {
            $filename = 'teacher_attendance_' . now()->format('Y-m-d') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $callback = function () use ($attendances) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['No', 'Teacher', 'Class', 'Date', 'Time In', 'Time Out', 'Status', 'Notes']);

                foreach ($attendances as $index => $att) {
                    fputcsv($file, [
                        $index + 1,
                        $att->teacher->name,
                        $att->schoolClass->name,
                        $att->date->format('Y-m-d'),
                        $att->time_in ?? '-',
                        $att->time_out ?? '-',
                        $att->status,
                        $att->notes ?? '-',
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        // PDF Generation
        $totalPresent = $attendances->where('status', 'Present')->count();
        $totalLate = $attendances->where('status', 'Late')->count();
        $totalAbsent = $attendances->where('status', 'Absent')->count();
        $totalRecords = $attendances->count();

        $attendanceRate = $totalRecords > 0 ? round((($totalPresent + $totalLate) / $totalRecords) * 100, 1) : 0;

        if ($request->filled('teacher_id')) {
            $filterInfo['teacher'] = User::find($request->teacher_id)->name ?? 'All';
        }
        if ($request->filled('class_id')) {
            $filterInfo['class'] = SchoolClass::find($request->class_id)->name ?? 'All';
        }

        $pdf = Pdf::loadView('admin.teacher-attendance.pdf', compact(
            'attendances',
            'totalPresent',
            'totalLate',
            'totalAbsent',
            'attendanceRate',
            'filterInfo'
        ));

        return $pdf->stream('Teacher_Attendance_Report.pdf');
    }



    private function generatePopulationDemographics()
    {
        $students = User::where('role', 'student')->get();
        $teachers = User::where('role', 'teacher')->get();

        $totalStudents = $students->count();
        $activeStudents = $students->where('status', 'active')->count();
        $inactiveStudents = $totalStudents - $activeStudents;

        $totalTeachers = $teachers->count();
        $activeTeachers = $teachers->where('status', 'active')->count();
        $inactiveTeachers = $totalTeachers - $activeTeachers;

        $onlineStudents = 0;
        $offlineStudents = 0;

        foreach ($students as $student) {
            $hasOnline = false;
            foreach ($student->enrolledClasses as $class) {
                if ($class->learning_method === 'online') $hasOnline = true;
            }
            if ($hasOnline) $onlineStudents++;
            else $offlineStudents++;
        }

        // Group by course levels for pie chart
        $levels = DB::table('payments')
            ->where('payment_status', 'paid')
            ->join('classes', 'payments.class_id', '=', 'classes.id')
            ->join('courses', 'classes.course_id', '=', 'courses.id')
            ->select('courses.name as level', DB::raw('count(*) as total'))
            ->groupBy('courses.name')
            ->get();

        $pieLabels = [];
        $pieData = [];
        $levelStats = [];
        $colors = ['#3b82f6', '#0f172a', '#60a5fa', '#eab308', '#10b981'];

        foreach ($levels as $index => $level) {
            $pieLabels[] = urlencode($level->level);
            $pieData[] = $level->total;
            $levelStats[] = [
                'name' => $level->level,
                'total' => $level->total,
                'color' => $colors[$index % count($colors)]
            ];
        }

        $trendChartUrl = "https://quickchart.io/chart?w=600&h=250&c=" . urlencode(json_encode([
            'type' => 'bar',
            'data' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'datasets' => [
                    ['label' => 'Students', 'data' => [120, 135, 148, 162, 175, $totalStudents], 'backgroundColor' => '#3b82f6'],
                    ['label' => 'Teachers', 'data' => [20, 22, 25, 27, 28, $totalTeachers], 'backgroundColor' => '#10b981']
                ]
            ]
        ]));

        $pieChartUrl = "https://quickchart.io/chart?w=300&h=300&c=" . urlencode(json_encode([
            'type' => 'pie',
            'data' => [
                'labels' => array_map('urldecode', $pieLabels),
                'datasets' => [
                    ['data' => $pieData, 'backgroundColor' => $colors]
                ]
            ],
            'options' => ['legend' => ['display' => false]]
        ]));

        $trendChartBase64 = base64_encode(Http::withoutVerifying()->get($trendChartUrl)->body());
        $pieChartBase64 = base64_encode(Http::withoutVerifying()->get($pieChartUrl)->body());
        $data = compact('totalStudents', 'activeStudents', 'inactiveStudents', 'onlineStudents', 'offlineStudents', 'totalTeachers', 'activeTeachers', 'inactiveTeachers', 'trendChartBase64', 'pieChartBase64', 'levelStats');

        $pdf = Pdf::loadView('admin.reports.pdf.population_demographics', $data);
        return $pdf->stream("Population_Demographics_Report.pdf");
    }

    private function generateFinancialIncome(Request $request)
    {
        $query = \App\Models\Payment::with('user', 'schoolClass')
            ->where('payment_status', 'paid')
            ->orderBy('payment_date', 'asc');

        $periodLabel = 'All Time';
        if ($request->filled('period')) {
            switch ($request->period) {
                case 'this_month':
                    $query->whereMonth('payment_date', \Carbon\Carbon::now()->month)
                          ->whereYear('payment_date', \Carbon\Carbon::now()->year);
                    $periodLabel = \Carbon\Carbon::now()->format('F Y');
                    break;
                case 'last_month':
                    $query->whereMonth('payment_date', \Carbon\Carbon::now()->subMonth()->month)
                          ->whereYear('payment_date', \Carbon\Carbon::now()->subMonth()->year);
                    $periodLabel = \Carbon\Carbon::now()->subMonth()->format('F Y');
                    break;
                case 'this_year':
                    $query->whereYear('payment_date', \Carbon\Carbon::now()->year);
                    $periodLabel = 'Year ' . \Carbon\Carbon::now()->year;
                    break;
                case 'last_year':
                    $query->whereYear('payment_date', \Carbon\Carbon::now()->subYear()->year);
                    $periodLabel = 'Year ' . \Carbon\Carbon::now()->subYear()->year;
                    break;
            }
        }

        $payments = $query->get();
        $fullPayments = $payments->where('payment_type', 'full');
        $installments = $payments->where('payment_type', 'installment');

        $totalIncome = $fullPayments->sum('amount') + $installments->sum('installment_paid');

        $totalFull = $fullPayments->sum('amount');
        $totalInstallment = $installments->sum('installment_paid');

        // Group by month and year
        $monthlyIncome = [];
        $classIncomeMap = [];

        foreach ($payments as $payment) {
            $monthYear = $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('F Y') : 'Unknown';
            if (!isset($monthlyIncome[$monthYear])) {
                $monthlyIncome[$monthYear] = ['full' => 0, 'installment' => 0, 'total' => 0, 'payments' => []];
            }
            if ($payment->payment_type === 'full') {
                $monthlyIncome[$monthYear]['full'] += $payment->amount;
                $monthlyIncome[$monthYear]['total'] += $payment->amount;
                $paymentAmount = $payment->amount;
            } else {
                $monthlyIncome[$monthYear]['installment'] += $payment->installment_paid;
                $monthlyIncome[$monthYear]['total'] += $payment->installment_paid;
                $paymentAmount = $payment->installment_paid;
            }
            $monthlyIncome[$monthYear]['payments'][] = $payment;

            // Class Grouping
            $className = $payment->schoolClass ? $payment->schoolClass->name : 'Unassigned';
            if (!isset($classIncomeMap[$className])) {
                $classIncomeMap[$className] = [
                    'name' => $className,
                    'total_income' => 0,
                    'total_payments' => 0,
                    'unique_students' => []
                ];
            }
            $classIncomeMap[$className]['total_income'] += $paymentAmount;
            $classIncomeMap[$className]['total_payments']++;
            if ($payment->user) {
                $classIncomeMap[$className]['unique_students'][$payment->user->id] = true;
            }
        }

        $classIncome = collect(array_values($classIncomeMap))->map(function($item) {
            $item['student_count'] = count($item['unique_students']);
            return (object) $item;
        })->sortByDesc('total_income')->values();

        // Chart Data
        $labels = [];
        $fullData = [];
        $installData = [];
        foreach ($monthlyIncome as $month => $data) {
            $labels[] = $month;
            $fullData[] = $data['full'];
            $installData[] = $data['installment'];
        }

        $barChartBase64 = null;
        if (count($labels) > 0) {
            $barChartUrl = "https://quickchart.io/chart?w=600&h=250&c=" . urlencode(json_encode([
                'type' => 'bar',
                'data' => [
                    'labels' => $labels,
                    'datasets' => [
                        ['label' => 'Full Payments', 'data' => $fullData, 'backgroundColor' => '#10b981'],
                        ['label' => 'Installments', 'data' => $installData, 'backgroundColor' => '#3b82f6']
                    ]
                ],
                'options' => [
                    'scales' => [
                        'xAxes' => [['stacked' => true]],
                        'yAxes' => [['stacked' => true]]
                    ]
                ]
            ]));
            try {
                $barChartBase64 = base64_encode(Http::withoutVerifying()->get($barChartUrl)->body());
            } catch (\Exception $e) {}
        }

        $pdf = Pdf::loadView('admin.reports.pdf.financial_income', compact(
            'payments', 'totalIncome', 'totalFull', 'totalInstallment', 'monthlyIncome', 'classIncome', 'barChartBase64', 'periodLabel'
        ));
        return $pdf->stream("Financial_Income_Report.pdf");
    }

    private function generateAttendanceRecord($class)
    {
        $sessions = AttendanceSession::where('class_id', $class->id)
            ->with(['attendances.student'])
            ->orderBy('session_date', 'asc')
            ->get();

        $totalMeetings = $sessions->count();
        $totalStudents = $class->students->count();
        
        $totalPossible = $totalMeetings * $totalStudents;
        $totalPresent = 0;

        $studentRecords = [];

        foreach ($class->students as $student) {
            $presentCount = 0;
            $absentCount = 0;

            foreach ($sessions as $session) {
                $att = $session->attendances->where('student_id', $student->id)->first();
                if ($att) {
                    if ($att->status === 'present') {
                        $presentCount++;
                        $totalPresent++;
                    } else {
                        $absentCount++;
                    }
                }
            }

            $rate = $totalMeetings > 0 ? round(($presentCount / $totalMeetings) * 100, 1) : 0;
            
            if ($rate >= 95) $status = 'Perfect';
            elseif ($rate >= 90) $status = 'Excellent';
            elseif ($rate >= 80) $status = 'Very Good';
            else $status = 'Good';

            $studentRecords[] = [
                'name' => $student->name,
                'id' => 'STD' . str_pad($student->id, 3, '0', STR_PAD_LEFT),
                'meetings' => $totalMeetings,
                'present' => $presentCount,
                'absent' => $absentCount,
                'rate' => $rate,
                'status' => $status
            ];
        }

        $overallRate = $totalPossible > 0 ? round(($totalPresent / $totalPossible) * 100, 1) : 0;

        $pieChartUrl = "https://quickchart.io/chart?w=300&h=300&c=" . urlencode(json_encode([
            'type' => 'pie',
            'data' => [
                'labels' => ['Present', 'Absent'],
                'datasets' => [
                    ['data' => [$totalPresent, $totalPossible - $totalPresent], 'backgroundColor' => ['#10b981', '#ef4444']]
                ]
            ]
        ]));

        $pieChartBase64 = base64_encode(Http::withoutVerifying()->get($pieChartUrl)->body());

        $data = [
            'class' => $class,
            'totalStudents' => $totalStudents,
            'totalMeetings' => $totalMeetings,
            'totalPresent' => $totalPresent,
            'overallRate' => $overallRate,
            'studentRecords' => $studentRecords,
            'pieChartBase64' => $pieChartBase64
        ];

        $pdf = Pdf::loadView('admin.reports.pdf.attendance_record', $data);
        return $pdf->stream("Attendance_Record_{$class->name}.pdf");
    }
}
