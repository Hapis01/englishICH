<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SchoolClass;

use App\Models\StudentGrade;
use Illuminate\Support\Facades\Auth;

class StudentManagementController extends Controller
{
    public function index(Request $request)
    {
        $teacher = Auth::user();
        $classIds = $teacher->taughtClasses()->pluck('id');

        $query = User::where('role', 'student')
            ->whereHas('enrolledClasses', function($q) use ($classIds) {
                $q->whereIn('classes.id', $classIds);
            });

        // Optional filtering by class
        if ($request->has('class_id') && $request->class_id != '') {
            $query->whereHas('enrolledClasses', function($q) use ($request) {
                $q->where('classes.id', $request->class_id);
            });
        }

        // Optional searching by name or email
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $students = $query->with([
            'enrolledClasses' => function($q) use ($classIds) {
                $q->whereIn('classes.id', $classIds);
            },
            'attendances' => function($q) use ($classIds) {
                $q->whereHas('session', function($sq) use ($classIds) {
                    $sq->whereIn('class_id', $classIds);
                });
            },
            'assessmentScores' => function($q) use ($classIds) {
                $q->whereHas('assessment', function($sq) use ($classIds) {
                    $sq->whereIn('class_id', $classIds);
                });
            }
        ])->paginate(15);

        // Calculate dynamic stats for each student on the fly
        foreach ($students as $student) {
            $presentCount = $student->attendances->where('status', 'Present')->count();
            $totalAttendances = $student->attendances->count();
            $student->attendance_rate = $totalAttendances > 0 ? round(($presentCount / $totalAttendances) * 100) : 0;

            $scoredCount = $student->assessmentScores->whereNotNull('score')->count();
            $totalScores = $student->assessmentScores->count();
            $totalScoreSum = $student->assessmentScores->sum('score');
            
            $student->completion_rate = $totalScores > 0 ? round(($scoredCount / $totalScores) * 100) : 0;
            $student->average_score = $scoredCount > 0 ? round($totalScoreSum / $scoredCount, 1) : 0;
            
            // Get first enrollment date for the teacher's classes
            $student->enrollment_date = $student->enrolledClasses->min('pivot.payment_date') ?? $student->created_at;
        }

        $classes = $teacher->taughtClasses()->get();

        return view('teacher.students.index', compact('students', 'classes'));
    }

    public function show(User $user)
    {
        $teacher = Auth::user();
        $classIds = $teacher->taughtClasses()->pluck('id');

        // Security check: Teacher can only view enrolled students
        if (!$user->enrolledClasses()->whereIn('classes.id', $classIds)->exists()) {
            return back()->with('error', 'You are not authorized to view this student.');
        }

        $student = $user->load([
            'enrolledClasses' => function($q) use ($classIds) {
                $q->whereIn('classes.id', $classIds);
            },
            'attendances' => function($q) use ($classIds) {
                $q->whereHas('session', function($sq) use ($classIds) {
                    $sq->whereIn('class_id', $classIds);
                });
            },
            'assessmentScores' => function($q) use ($classIds) {
                $q->whereHas('assessment', function($sq) use ($classIds) {
                    $sq->whereIn('class_id', $classIds);
                });
            }
        ]);

        $grades = StudentGrade::where('teacher_id', $teacher->id)
            ->where('student_id', $student->id)
            ->get();
            
        $notesArray = [];
        foreach ($grades as $grade) {
            if ($grade->teacher_notes) {
                foreach ($grade->teacher_notes as $note) {
                    $notesArray[] = (object)[
                        'content' => $note['content'],
                        'created_at' => \Carbon\Carbon::parse($note['date'])
                    ];
                }
            }
        }
        usort($notesArray, function($a, $b) {
            return $b->created_at <=> $a->created_at;
        });
        $notes = collect($notesArray);

        return view('teacher.students.show', compact('student', 'notes'));
    }

    public function storeNote(Request $request, User $user)
    {
        $teacher = Auth::user();
        $classIds = $teacher->taughtClasses()->pluck('id');

        // Security check
        if (!$user->enrolledClasses()->whereIn('classes.id', $classIds)->exists()) {
            return back()->with('error', 'You are not authorized to note this student.');
        }

        $request->validate([
            'content' => 'required|string',
        ]);

        $classId = $user->enrolledClasses()->whereIn('classes.id', $classIds)->first()->id;

        $grade = StudentGrade::firstOrCreate(
            ['student_id' => $user->id, 'class_id' => $classId],
            ['teacher_id' => $teacher->id]
        );

        $existingNotes = $grade->teacher_notes ?? [];
        $existingNotes[] = [
            'content' => $request->content,
            'date' => now()->toDateTimeString()
        ];
        
        $grade->update(['teacher_notes' => $existingNotes]);

        return back()->with('success', 'Private note added successfully.');
    }

    public function calculateGrades(Request $request, User $user)
    {
        $teacher = Auth::user();
        $classId = $request->input('class_id');

        // Security check
        if (!$user->enrolledClasses()->where('classes.id', $classId)->exists()) {
            return back()->with('error', 'You are not authorized to grade this student for this class.');
        }

        // Attendance
        $attendances = $user->attendances()
            ->whereHas('session', function($q) use ($classId) {
                $q->where('class_id', $classId);
            })->get();
        
        $totalSessions = $attendances->count();
        $presentSessions = $attendances->where('status', 'Present')->count();
        $attendanceScore = $totalSessions > 0 ? round(($presentSessions / $totalSessions) * 100, 2) : 0;

        // Skill Scores (Reading, Listening, Writing, Speaking)
        $assessmentScores = $user->assessmentScores()
            ->whereHas('assessment', function($q) use ($classId) {
                $q->where('class_id', $classId);
            })
            ->where('is_published', true)
            ->with('assessment')
            ->get();

        $skills = ['Reading', 'Listening', 'Writing', 'Speaking Test', 'Speaking', 'Grammar'];
        $skillScores = [];

        foreach ($skills as $skill) {
            $scores = $assessmentScores->filter(function($score) use ($skill) {
                return $score->assessment->type === $skill;
            });
            
            if ($scores->count() > 0) {
                $totalPercentage = $scores->sum(function($score) {
                    return $score->maximum_score > 0 ? ($score->score / $score->maximum_score) * 100 : 0;
                });
                $skillScores[$skill] = round($totalPercentage / $scores->count(), 2);
            } else {
                $skillScores[$skill] = null;
            }
        }

        $speakingFinal = $skillScores['Speaking'] ?? $skillScores['Speaking Test'] ?? null;

        StudentGrade::updateOrCreate(
            [
                'student_id' => $user->id,
                'class_id' => $classId,
            ],
            [
                'teacher_id' => $teacher->id,
                'reading' => $skillScores['Reading'],
                'listening' => $skillScores['Listening'],
                'writing' => $skillScores['Writing'],
                'speaking' => $speakingFinal,
                'grammar' => $skillScores['Grammar'],
                'attendance' => $attendanceScore,
                'published' => false,
                'grade_date' => now(),
            ]
        );

        return back()->with('success', 'Grades calculated and generated successfully!');
    }
}
