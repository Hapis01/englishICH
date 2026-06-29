<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SchoolClass;
use App\Models\StudentGrade;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Display academic analytics.
     */
    public function index(Request $request)
    {
        $teacher = Auth::user();
        
        // Get filter parameters
        $classId = $request->get('class_id');
        $month = $request->get('month', Carbon::now()->format('Y-m'));

        // Get teacher's classes
        $classes = SchoolClass::where('teacher_id', $teacher->id)
            ->where('status', 'active')
            ->with('course')
            ->get();

        // Filter grades by class and month
        $gradesQuery = StudentGrade::where('teacher_id', $teacher->id)
            ->with(['student', 'schoolClass']);

        if ($classId) {
            $gradesQuery->where('class_id', $classId);
        }

        if ($month) {
            $startOfMonth = Carbon::parse($month)->startOfMonth();
            $endOfMonth = Carbon::parse($month)->endOfMonth();
            $gradesQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
        }

        $grades = $gradesQuery->get();

        // Class performance overview
        $classPerformance = [];
        foreach ($classes as $class) {
            $classGrades = $grades->where('class_id', $class->id);
            if ($classGrades->count() > 0) {
                $classPerformance[] = [
                    'class_name' => $class->name,
                    'average' => round($classGrades->avg('average'), 2),
                    'students' => $classGrades->count(),
                ];
            }
        }

        // Overall statistics
        $totalStudents = $grades->unique('student_id')->count();
        $averageGrade = $grades->count() > 0 ? round($grades->avg('average'), 2) : 0;
        $publishedGrades = $grades->where('published', true)->count();

        // Skill performance (Listening, Speaking, Reading, Writing, Grammar)
        $skillPerformance = [
            'listening' => round($grades->avg('listening'), 2),
            'speaking' => round($grades->avg('speaking'), 2),
            'reading' => round($grades->avg('reading'), 2),
            'writing' => round($grades->avg('writing'), 2),
            'grammar' => round($grades->avg('grammar'), 2),
        ];

        // Grade distribution
        $gradeDistribution = [
            'A' => $grades->filter(fn($g) => $g->average >= 90)->count(),
            'B' => $grades->filter(fn($g) => $g->average >= 80 && $g->average < 90)->count(),
            'C' => $grades->filter(fn($g) => $g->average >= 70 && $g->average < 80)->count(),
            'D' => $grades->filter(fn($g) => $g->average >= 60 && $g->average < 70)->count(),
            'F' => $grades->filter(fn($g) => $g->average < 60)->count(),
        ];

        // Top performers
        $topPerformers = $grades->sortByDesc('average')->take(5);

        // Monthly trend (last 6 months)
        $monthlyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = Carbon::now()->subMonths($i);
            $monthGrades = StudentGrade::where('teacher_id', $teacher->id)
                ->whereYear('created_at', $monthDate->year)
                ->whereMonth('created_at', $monthDate->month)
                ->get();
            
            $monthlyTrend[] = [
                'month' => $monthDate->format('M Y'),
                'average' => $monthGrades->count() > 0 ? round($monthGrades->avg('average'), 2) : 0,
                'count' => $monthGrades->count(),
            ];
        }

        return view('teacher.analytics', compact(
            'classes',
            'classPerformance',
            'totalStudents',
            'averageGrade',
            'publishedGrades',
            'skillPerformance',
            'gradeDistribution',
            'topPerformers',
            'monthlyTrend',
            'classId',
            'month'
        ));
    }
}
