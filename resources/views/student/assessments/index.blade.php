@extends('layouts.student')

@section('title', 'My Assessments')
@section('page-title', 'Assessments')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">My Assessments</h2>
        <p class="text-gray-600">View and submit Assessments for your active classes</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($assessments as $assessment)
            @php
                $submission = $assessment->scores->first();
                $isLate = $assessment->is_overdue;
            @endphp
            <div class="bg-white rounded-xl shadow overflow-hidden hover:shadow-md transition border border-gray-100 flex flex-col">
                <div class="p-6 flex-1">
                    <div class="flex justify-between items-start mb-4">
                        @if($assessment->is_upcoming)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Upcoming
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $submission && $submission->file_path ? 'bg-green-100 text-green-800' : ($isLate ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ $submission && $submission->file_path ? 'Submitted' : ($isLate ? 'Missing' : 'Pending') }}
                            </span>
                        @endif
                        @if($submission && $submission->score !== null && $submission->is_published)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                Graded: {{ floatval($submission->score) }} / {{ floatval($submission->maximum_score ?? 100) }}
                            </span>
                        @endif
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $assessment->title }}</h3>
                    <p class="text-sm text-gray-600 mb-4">{{ $assessment->schoolClass->name }}</p>

                    <div class="space-y-2 text-sm text-gray-500">
                        @if($assessment->is_upcoming)
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Opens: {{ $assessment->start_date ? $assessment->start_date->format('M d, Y') : 'Soon' }} {{ $assessment->start_time ? 'at ' . date('H:i', strtotime($assessment->start_time)) : '' }}
                        </div>
                        @elseif($assessment->due_date)
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Due: {{ $assessment->due_date->format('M d, Y') }} {{ $assessment->due_time ? 'at ' . date('H:i', strtotime($assessment->due_time)) : '' }}
                        </div>
                        @else
                        <div class="flex items-center italic text-gray-400">
                            No Time Limit
                        </div>
                        @endif
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ $assessment->teacher->name }}
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 mt-auto">
                    @if($assessment->is_upcoming)
                        <button disabled class="block w-full text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-500 bg-gray-200 cursor-not-allowed">
                            Coming Soon
                        </button>
                    @elseif($isLate && (!$submission || !$submission->file_path))
                        <button disabled class="block w-full text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-500 bg-gray-200 cursor-not-allowed">
                            Closed
                        </button>
                    @else
                        <a href="{{ route('student.assessments.show', $assessment) }}" class="block w-full text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            View Details
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-xl shadow p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Assessments</h3>
                <p class="text-gray-600">You don't have any Assessments yet.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
