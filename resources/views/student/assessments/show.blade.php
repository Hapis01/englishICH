@extends('layouts.student')

@section('title', $assessment->title)
@section('page-title', 'Assessment Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('student.assessments.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center space-x-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Back to Assessments</span>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Assessment Details -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-2xl font-bold text-gray-900">{{ $assessment->title }}</h2>
                <div class="text-right">
                    @if($assessment->due_date)
                    <span class="block text-sm font-semibold text-gray-500">Due Date</span>
                    <span class="block font-bold {{ $assessment->is_overdue && (!$submission || !$submission->file_path) ? 'text-red-600' : 'text-gray-900' }}">
                        {{ $assessment->due_date->format('l, M d, Y') }}<br>
                        {{ $assessment->due_time ? date('H:i', strtotime($assessment->due_time)) : '23:59' }}
                    </span>
                    @else
                    <span class="block text-sm font-semibold text-gray-400 italic">No Time Limit</span>
                    @endif
                </div>
            </div>

            <div class="flex items-center space-x-4 mb-6 text-sm text-gray-500">
                <span>{{ $assessment->schoolClass->name }}</span>
                <span>•</span>
                <span>{{ $assessment->teacher->name }}</span>
            </div>

            @if($assessment->description)
            <div class="prose max-w-none mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-2">Description</h4>
                <p class="text-gray-600 whitespace-pre-line">{{ $assessment->description }}</p>
            </div>
            @endif

            @if($assessment->instructions)
            <div class="prose max-w-none mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-2">Instructions</h4>
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded text-blue-900 whitespace-pre-line">
                    {{ $assessment->instructions }}
                </div>
            </div>
            @endif

            @if($assessment->attachment)
            <div>
                <h4 class="text-lg font-semibold text-gray-800 mb-2">Attachment</h4>
                <a href="{{ asset('storage/' . $assessment->attachment) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                    </svg>
                    Download File
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Submission Section -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Your Work</h3>

            @if($submission && $submission->file_path)
                <!-- Already Submitted -->
                <div class="space-y-4">
                    <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center text-green-800 mb-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-semibold">Submitted</span>
                        </div>
                        <p class="text-sm text-green-700">on {{ $submission->submitted_at->format('M d, Y H:i') }}</p>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-700 mb-1">Your File:</span>
                        <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="text-blue-600 hover:underline text-sm font-medium break-all">
                            View Submission
                        </a>
                    </div>

                    @if($submission->notes)
                    <div>
                        <span class="block text-sm font-medium text-gray-700 mb-1">Your Notes:</span>
                        <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded border border-gray-100">{{ $submission->notes }}</p>
                    </div>
                    @endif

                    @if($submission->score !== null && $submission->is_published)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h4 class="font-bold text-gray-900 mb-3">Grade & Feedback</h4>
                            <div class="flex items-center mb-3">
                                <span class="text-3xl font-bold text-blue-600">{{ floatval($submission->score) }}</span>
                                <span class="text-gray-500 ml-1">/ {{ floatval($submission->maximum_score ?? 100) }}</span>
                            </div>
                        </div>
                    @else
                        <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                Not graded yet
                            </span>
                        </div>
                    @endif
                </div>
            @else
                <!-- Submit Form -->
                @if(!$assessment->is_active)
                    <div class="p-4 bg-red-50 border border-red-200 rounded-lg text-red-800 text-center">
                        <p class="font-semibold mb-1">Submissions Closed</p>
                        <p class="text-sm">You can no longer submit work for this Assessment because the time limit has passed, it hasn't started yet, or it was manually closed.</p>
                    </div>
                @else
                    <form action="{{ route('student.assessments.submit', $assessment) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload File</label>
                            <input type="file" name="file" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-500 mt-1">PDF, DOC/X, Images or ZIP (Max 10MB)</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                            <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400" placeholder="Add any comments for your teacher..."></textarea>
                        </div>

                        <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Turn In Assessment
                        </button>
                    </form>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
