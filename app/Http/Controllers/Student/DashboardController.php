<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SchoolClass;
use App\Models\StudentGrade;
use App\Models\ClassMaterial;

use App\Models\Payment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the student dashboard overview.
     */
    public function index()
    {
        $student = Auth::user();
        
        // Get enrolled classes
        $enrolledClasses = $student->enrolledClasses()
            ->where('status', 'active')
            ->with(['course', 'teacher'])
            ->get();

        // Total enrolled classes
        $totalClasses = $enrolledClasses->count();

        // GPA / Average Score
        $gpa = round($student->gpa, 2);

        // Certificate count
        $certificateCount = $student->certificate_count;

        // Upcoming session (next class based on schedule)
        $today = Carbon::now()->format('l'); // Get day name
        $upcomingSession = $enrolledClasses->filter(function ($class) use ($today) {
            return stripos($class->schedule, $today) !== false;
        })->first();

        // Current course (most recent enrollment)
        $currentCourse = $enrolledClasses->sortByDesc('pivot.payment_date')->first();

        // Recent activities (materials, grades, messages)
        $recentActivities = $this->getRecentActivities($student, $enrolledClasses);

        // Learning progress summary
        $learningProgress = $this->getLearningProgress($student, $enrolledClasses);

        // Unread messages count
        $unreadMessages = \App\Models\Message::where('receiver_id', $student->id)
            ->where('is_read', false)
            ->count();

        // Pending Assessments (Assignments/Quizzes)
        $allPendingAssessments = \App\Models\Assessment::whereIn('class_id', $enrolledClasses->pluck('id'))
            ->where('is_published', true)
            ->whereDoesntHave('scores', function ($query) use ($student) {
                $query->where('student_id', $student->id);
            })
            ->orderBy('due_date', 'asc')
            ->get();
            
        $pendingAssignments = $allPendingAssessments->filter(function($assessment) {
            return $assessment->is_active || $assessment->is_upcoming;
        })->take(5);

        // Active Attendance Sessions
        $nowTime = now()->format('H:i:s');
        $activeAttendances = \App\Models\AttendanceSession::whereIn('class_id', $enrolledClasses->pluck('id'))
            ->whereDate('session_date', now()->toDateString())
            ->where(function ($query) use ($nowTime) {
                $query->where('is_open', true)
                      ->orWhere(function ($q) use ($nowTime) {
                          $q->whereNotNull('start_time')
                            ->whereNotNull('end_time')
                            ->where('end_time', '>=', $nowTime);
                      });
            })
            ->whereDoesntHave('attendances', function ($query) use ($student) {
                $query->where('student_id', $student->id);
            })
            ->get();

        // Upcoming Online Meetings
        $upcomingMeetings = \App\Models\AttendanceSession::whereIn('class_id', $enrolledClasses->pluck('id'))
            ->where('is_published', true)
            ->where('platform', '!=', 'Offline')
            ->where('meeting_status', 'scheduled')
            ->whereDate('session_date', '>=', now()->toDateString())
            ->orderBy('session_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->take(5)
            ->get()
            ->filter(function($meeting) {
                if (!$meeting->start_time) return true;
                $meetingDateTime = \Carbon\Carbon::parse($meeting->session_date->format('Y-m-d') . ' ' . $meeting->start_time);
                $now = \Carbon\Carbon::now();
                return !$now->greaterThan($meetingDateTime->copy()->addHours(2));
            });

        return view('student.dashboard', compact(
            'student',
            'enrolledClasses',
            'totalClasses',
            'gpa',
            'certificateCount',
            'upcomingSession',
            'currentCourse',
            'recentActivities',
            'learningProgress',
            'unreadMessages',
            'pendingAssignments',
            'activeAttendances',
            'upcomingMeetings'
        ));
    }

    /**
     * Get recent activities for the student.
     */
    private function getRecentActivities($student, $enrolledClasses)
    {
        $activities = collect();
        $classIds = $enrolledClasses->pluck('id');

        // Recent materials
        $recentMaterials = ClassMaterial::whereIn('class_id', $classIds)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($material) {
                return [
                    'type' => 'material',
                    'title' => 'New material uploaded',
                    'description' => $material->title,
                    'class' => $material->schoolClass->name,
                    'date' => $material->created_at,
                    'icon' => 'document',
                ];
            });

        // Recent grades
        $recentGrades = $student->publishedGrades()
            ->whereIn('class_id', $classIds)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($grade) {
                return [
                    'type' => 'grade',
                    'title' => 'Grade published',
                    'description' => "Average: {$grade->average}",
                    'class' => $grade->schoolClass->name,
                    'date' => $grade->updated_at,
                    'icon' => 'star',
                ];
            });

        // Merge and sort by date - convert to regular collection
        $activities = collect($recentMaterials->toArray())
            ->merge($recentGrades->toArray())
            ->sortByDesc('date')
            ->take(10)
            ->values();

        return $activities;
    }

    /**
     * Get learning progress summary.
     */
    private function getLearningProgress($student, $enrolledClasses)
    {
        $classIds = $enrolledClasses->pluck('id');

        // Get all published grades
        $grades = $student->publishedGrades()
            ->whereIn('class_id', $classIds)
            ->get();

        if ($grades->isEmpty()) {
            return [
                'listening' => 0,
                'speaking' => 0,
                'reading' => 0,
                'writing' => 0,
                'grammar' => 0,
                'attendance' => 0,
            ];
        }

        return [
            'listening' => round($grades->avg('listening') ?? 0, 2),
            'speaking' => round($grades->avg('speaking') ?? 0, 2),
            'reading' => round($grades->avg('reading') ?? 0, 2),
            'writing' => round($grades->avg('writing') ?? 0, 2),
            'grammar' => round($grades->avg('grammar') ?? 0, 2),
            'attendance' => round($grades->avg('attendance') ?? 0, 2),
        ];
    }

    /**
     * Display student payments/invoices.
     */
    public function payments(Request $request)
    {
        $student = Auth::user();
        
        // Dynamically check and update overdue installments
        \App\Models\PaymentInstallment::checkAndUpdateOverdue($student);

        $payments = Payment::where('user_id', $student->id)
            ->with(['verifier', 'installments'])
            ->latest()
            ->paginate(10);

        return view('student.payments', compact('payments'));
    }

    /**
     * Show class selection page with pricing.
     */
    public function selectClass()
    {
        $student = Auth::user();
        
        $courses = \App\Models\Course::where('status', 'active')->orderBy('price')->get();
        
        // Get all active classes with course and teacher information
        $classes = SchoolClass::where('status', 'active')
            ->with(['course', 'teacher'])
            ->get()
            ->groupBy('course.level');

        $registrationEndDate = Carbon::parse('2026-07-24 23:59:59');
        $isRegistrationClosed = Carbon::now()->greaterThan($registrationEndDate);

        return view('student.select-class', compact('courses', 'classes', 'student', 'isRegistrationClosed'));
    }

    /**
     * Confirm class selection and redirect to payment options.
     */
    public function confirmClassSelection(Request $request)
    {
        $registrationEndDate = Carbon::parse('2026-07-24 23:59:59');
        if (Carbon::now()->greaterThan($registrationEndDate)) {
            return redirect()->route('student.select.class')->with('error', 'Maaf pendaftaran telah ditutup');
        }

        $request->validate([
            'class_id' => 'required|exists:classes,id',
        ]);

        return redirect()->route('student.payment.options', ['classId' => $request->class_id]);
    }

    /**
     * Show payment options (full payment or installments).
     */
    public function paymentOptions($classId)
    {
        $student = Auth::user();
        $class = SchoolClass::with(['course', 'teacher'])->findOrFail($classId);

        // Calculate installment options (always 4 installments)
        $fullPrice = $class->course->price;
        $installmentCount = 4;
        $installmentAmount = floor($fullPrice / $installmentCount);

        return view('student.payment-options', compact('class', 'student', 'fullPrice', 'installmentAmount', 'installmentCount'));
    }

    public function processPayment(Request $request, $classId)
    {
        $request->validate([
            'payment_type' => 'required|in:full,installment',
        ]);

        $student = Auth::user();
        $class = SchoolClass::with('course')->findOrFail($classId);
        $paymentType = $request->payment_type;

        if ($paymentType === 'full') {
            // Full payment
            Payment::create([
                'user_id' => $student->id,
                'class_id' => $class->id,
                'amount' => $class->course->price,
                'payment_status' => 'pending',
                'verification_status' => 'none',
                'payment_date' => now(),
                'title' => 'Pembayaran Penuh - ' . $class->course->name,
                'description' => 'Pembayaran penuh untuk kelas ' . $class->name,
                'payment_type' => 'full',
                'installment_total' => $class->course->price,
                'installment_paid' => 0,
                'installment_remaining' => $class->course->price,
                'next_due_date' => now()->addDays(7),
                'payment_notes' => 'Pembayaran Penuh',
                'due_date' => now()->addDays(7),
            ]);

            $student->update(['student_status' => 'AWAITING_PAYMENT']);

            return redirect()->route('student.payments')
                ->with('success', 'Kelas berhasil dipilih! Silakan lakukan pembayaran dalam 7 hari.');
        } else {
            // Installment payment
            $fullPrice = $class->course->price;
            $installmentCount = 4;
            $baseInstallmentAmount = floor($fullPrice / $installmentCount);
            $lastInstallmentAmount = $fullPrice - ($baseInstallmentAmount * ($installmentCount - 1));

            $payment = Payment::create([
                'user_id' => $student->id,
                'class_id' => $class->id,
                'amount' => $fullPrice,
                'payment_status' => 'pending',
                'verification_status' => 'none',
                'payment_date' => now(),
                'title' => 'Pembayaran Cicilan - ' . $class->course->name,
                'description' => 'Pembayaran cicilan ' . $installmentCount . 'x untuk kelas ' . $class->name,
                'payment_type' => 'installment',
                'installment_total' => $fullPrice,
                'installment_paid' => 0,
                'installment_remaining' => $fullPrice,
                'next_due_date' => now()->addDays(7),
                'payment_notes' => 'Pembayaran Cicilan',
                'due_date' => null,
            ]);

            // Create installments — first due in 7 days, then monthly from first due date
            $firstDueDate = now()->addDays(7);
            for ($i = 1; $i <= $installmentCount; $i++) {
                $amount = ($i === $installmentCount) ? $lastInstallmentAmount : $baseInstallmentAmount;
                \App\Models\PaymentInstallment::create([
                    'payment_id' => $payment->id,
                    'installment_number' => $i,
                    'amount' => $amount,
                    'due_date' => $firstDueDate->copy()->addMonths($i - 1),
                    'status' => 'pending',
                ]);
            }

            $student->update(['student_status' => 'AWAITING_PAYMENT']);

            return redirect()->route('student.payments')
                ->with('success', 'Kelas berhasil dipilih! Silakan lakukan pembayaran cicilan pertama dalam 7 hari.');
        }
    }

    /**
     * Cancel rejected payment and allow student to select class again
     */
    public function selectClassAgain(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:payments,id',
        ]);

        $student = Auth::user();
        $payment = Payment::findOrFail($request->payment_id);

        // Security check: Ensure payment belongs to current student
        if ($payment->user_id !== $student->id) {
            return redirect()->route('student.payments')
                ->with('error', 'Unauthorized action.');
        }

        // Only allow canceling rejected payments
        if ($payment->verification_status !== 'rejected') {
            return redirect()->route('student.payments')
                ->with('error', 'Hanya pembayaran yang ditolak yang dapat dibatalkan.');
        }

        // Delete the rejected payment
        $payment->delete();

        return redirect()->route('student.select.class')
            ->with('success', 'Pembayaran dibatalkan. Silakan pilih kelas baru.');
    }
}
