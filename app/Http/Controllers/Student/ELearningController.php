<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SchoolClass;
use App\Models\ClassMaterial;

class ELearningController extends Controller
{
    /**
     * Display E-Learning Hub.
     */
    public function index()
    {
        $student = Auth::user();
        
        // Get enrolled classes with materials and weeks
        $enrolledClasses = $student->enrolledClasses()
            ->where('status', 'active')
            ->with(['course', 'teacher', 'weeks.materials', 'weeks.assignments' => function($q) {
                $q->where('is_published', true);
            }, 'materials' => function($q) {
                $q->whereNull('week_id'); // unassigned materials
            }])
            ->get();

        // Calculate progress for each class (based on materials viewed - placeholder)
        $classProgress = [];
        foreach ($enrolledClasses as $class) {
            $totalMaterials = $class->materials->count();
            foreach ($class->weeks as $week) {
                $totalMaterials += $week->materials->count();
            }
            $classProgress[$class->id] = [
                'total' => $totalMaterials,
                'completed' => 0, // TODO: Implement material tracking
                'percentage' => 0,
            ];
        }

        return view('student.elearning', compact(
            'enrolledClasses',
            'classProgress'
        ));
    }

    /**
     * Show material details.
     */
    public function show(ClassMaterial $material)
    {
        $student = Auth::user();

        // Check if student is enrolled in the class
        if (!$student->isEnrolledIn($material->class_id)) {
            return back()->with('error', 'You are not enrolled in this class.');
        }

        $material->load(['schoolClass.course', 'teacher']);

        // Get related materials from the same class
        $relatedMaterials = ClassMaterial::where('class_id', $material->class_id)
            ->where('id', '!=', $material->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('student.material-detail', compact('material', 'relatedMaterials'));
    }

    /**
     * Download material file.
     */
    public function download(ClassMaterial $material)
    {
        $student = Auth::user();

        // Check if student is enrolled in the class
        if (!$student->isEnrolledIn($material->class_id)) {
            return back()->with('error', 'You are not enrolled in this class.');
        }

        // Check if file exists
        $filePath = storage_path('app/public/' . $material->file_path);
        
        if (!file_exists($filePath)) {
            return back()->with('error', 'File not found.');
        }

        // TODO: Log material download activity

        return response()->download($filePath, basename($material->file_path));
    }
}
