@extends('layouts.teacher')

@section('title', 'Edit Assessment')
@section('page-title', 'Edit Assessment')

@section('content')
<div class="mb-6">
    <a href="{{ route('teacher.assessments.index') }}" class="text-emerald-600 hover:text-emerald-700 flex items-center space-x-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Back to Assessments</span>
    </a>
</div>

<div class="max-w-3xl bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <form action="{{ route('teacher.assessments.update', $assessment) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label class="block text-sm font-medium text-gray-700">Assessment Title</label>
            <input type="text" name="title" value="{{ old('title', $assessment->title) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Class</label>
                <input type="text" value="{{ $assessment->schoolClass->name }}" disabled class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm">
                <input type="hidden" name="class_id" value="{{ $assessment->class_id }}">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Type</label>
                <select name="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="">Select Type</option>
                    @foreach(['Assignment', 'Quiz', 'Mid Test', 'Final Test', 'Speaking Test', 'Custom Assessment'] as $type)
                        <option value="{{ $type }}" {{ old('type', $assessment->type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('description', $assessment->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Instructions for Students</label>
            <textarea name="instructions" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('instructions', $assessment->instructions) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Start Date (Optional)</label>
                <input type="date" name="start_date" value="{{ old('start_date', $assessment->start_date ? $assessment->start_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Start Time</label>
                <input type="time" name="start_time" value="{{ old('start_time', $assessment->start_time ? date('H:i', strtotime($assessment->start_time)) : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Due Date (Optional)</label>
                <input type="date" name="due_date" value="{{ old('due_date', $assessment->due_date ? $assessment->due_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Due Time</label>
                <input type="time" name="due_time" value="{{ old('due_time', $assessment->due_time ? date('H:i', strtotime($assessment->due_time)) : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
            </div>
        </div>

        <div class="flex items-center bg-gray-50 p-4 rounded-lg border border-gray-200">
            <input type="checkbox" name="is_open" id="is_open" value="1" {{ old('is_open', $assessment->is_open) ? 'checked' : '' }} class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
            <label for="is_open" class="ml-2 block text-sm text-gray-900 font-medium">
                Force Open Now
                <span class="block text-xs text-gray-500 font-normal mt-0.5">Check this to open the assessment immediately, overriding the start schedule.</span>
            </label>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Attachment (Optional)</label>
            @if($assessment->attachment)
                <div class="mb-2 text-sm text-gray-600">
                    Current attachment: <a href="{{ asset('storage/' . $assessment->attachment) }}" target="_blank" class="text-blue-600 hover:underline">View File</a>
                </div>
            @endif
            <input type="file" name="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
            <p class="text-xs text-gray-500 mt-1">Upload a new file to replace the existing one, or leave empty to keep it.</p>
        </div>

        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
            <a href="{{ route('teacher.assessments.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700">Update Assessment</button>
        </div>
    </form>
</div>
@endsection
