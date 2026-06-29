<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\SchoolClass;
use App\Models\ClassMaterial;
use App\Models\Week;

class ClassMaterialController extends Controller
{
    /**
     * Display classes with weeks and materials.
     */
    public function index()
    {
        $teacher = Auth::user();
        
        $classes = SchoolClass::where('teacher_id', $teacher->id)
            ->where('status', 'active')
            ->with(['course', 'materials.week', 'students', 'weeks' => function ($q) {
                $q->orderBy('week_number');
            }])
            ->get();

        return view('teacher.classes', compact('classes'));
    }

    /**
     * Store a new material.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required|exists:classes,id',
            'week_id' => 'nullable|exists:weeks,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,zip,jpg,jpeg,png|max:10240',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Verify teacher owns this class
        $class = SchoolClass::where('id', $request->class_id)
            ->where('teacher_id', Auth::id())
            ->firstOrFail();

        try {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('materials', $fileName, 'public');

            ClassMaterial::create([
                'class_id' => $request->class_id,
                'week_id' => $request->week_id,
                'teacher_id' => Auth::id(),
                'title' => $request->title,
                'description' => $request->description,
                'file_path' => $filePath,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
            ]);

            return back()->with('success', 'Material uploaded successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to upload material: ' . $e->getMessage());
        }
    }

    /**
     * Update material.
     */
    public function update(Request $request, ClassMaterial $material)
    {
        // Check if teacher owns this material
        if ($material->teacher_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'week_id' => 'nullable|exists:weeks,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $material->update([
                'title' => $request->title,
                'description' => $request->description,
                'week_id' => $request->week_id,
            ]);

            return back()->with('success', 'Material updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update material: ' . $e->getMessage());
        }
    }

    /**
     * Delete material.
     */
    public function destroy(ClassMaterial $material)
    {
        // Check if teacher owns this material
        if ($material->teacher_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        try {
            // Delete file from storage
            if (Storage::disk('public')->exists($material->file_path)) {
                Storage::disk('public')->delete($material->file_path);
            }

            $material->delete();

            return back()->with('success', 'Material deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete material: ' . $e->getMessage());
        }
    }
}
