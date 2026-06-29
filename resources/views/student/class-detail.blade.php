@extends('layouts.student')

@section('title', 'Class Detail')
@section('page-title', $class->name)

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('student.classes') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Active Classes
        </a>
    </div>

    <!-- Class Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg p-8 text-white">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">{{ $class->name }}</h1>
                <p class="text-blue-100 text-lg mb-4">{{ $class->course->name }}</p>
                <div class="flex items-center space-x-6">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>{{ $class->teacher->name }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>{{ $class->students_count }} Students</span>
                    </div>
                </div>
            </div>
            @if($schedule && $schedule['mode'] === 'online' && $schedule['meeting_link'])
                @php
                    $isMeetingActive = false;
                    $meetingStatus = 'upcoming';
                    $today = \Carbon\Carbon::now()->format('l');
                    $isToday = stripos($schedule['day'], $today) !== false;

                    if ($isToday) {
                        if (preg_match('/(\d{1,2}:\d{2})\s*-\s*(\d{1,2}:\d{2})/', $schedule['time'], $timeMatches)) {
                            $startTime = \Carbon\Carbon::createFromFormat('H:i', trim($timeMatches[1]), 'Asia/Jakarta');
                            $endTime = \Carbon\Carbon::createFromFormat('H:i', trim($timeMatches[2]), 'Asia/Jakarta');
                            $now = \Carbon\Carbon::now('Asia/Jakarta');
                            
                            if ($now->between($startTime, $endTime)) {
                                $isMeetingActive = true;
                                $meetingStatus = 'active';
                            } elseif ($now->greaterThan($endTime)) {
                                $meetingStatus = 'expired';
                            } else {
                                $meetingStatus = 'upcoming';
                            }
                        } else {
                            $isMeetingActive = true; // Fallback
                            $meetingStatus = 'active';
                        }
                    }
                @endphp

                @if($isToday && $meetingStatus === 'active')
                    <a href="{{ $schedule['meeting_link'] }}" target="_blank"
                       class="px-6 py-3 bg-white text-blue-600 hover:bg-blue-50 font-semibold rounded-lg transition">
                        Join Google Meet
                    </a>
                @elseif($isToday && $meetingStatus === 'upcoming')
                    <button disabled class="px-6 py-3 bg-yellow-400 text-white font-semibold rounded-lg cursor-not-allowed opacity-90">
                        Upcoming Meeting
                    </button>
                @elseif($isToday && $meetingStatus === 'expired')
                    <button disabled class="px-6 py-3 bg-gray-400 text-white font-semibold rounded-lg cursor-not-allowed opacity-90">
                        Meeting Expired
                    </button>
                @else
                    <button disabled class="px-6 py-3 bg-gray-400 text-white font-semibold rounded-lg cursor-not-allowed opacity-90" title="Meeting is only available on {{ $schedule['day'] }}">
                        Not Today
                    </button>
                @endif
            @endif
        </div>
    </div>

    <!-- Schedule Info -->
    @if($schedule)
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Schedule</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="flex items-center space-x-3">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Day</p>
                        <p class="font-semibold text-gray-900">{{ $schedule['day'] }}</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Time</p>
                        <p class="font-semibold text-gray-900">{{ $schedule['time'] }}</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Mode</p>
                        <p class="font-semibold text-gray-900">{{ ucfirst($schedule['mode']) }}</p>
                    </div>
                </div>

                @if($schedule['mode'] === 'offline')
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-orange-100 rounded-lg">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Location</p>
                            <p class="font-semibold text-gray-900">{{ $schedule['room'] ?? 'TBA' }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Learning Materials -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Learning Materials</h2>
        @if($materials->isEmpty())
            <div class="text-center py-8">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-600">No materials uploaded yet</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($materials as $material)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition">
                        <div class="flex items-center space-x-3">
                            @php
                                $ext = strtolower(pathinfo($material->file_path, PATHINFO_EXTENSION));
                                $color = match($ext) {
                                    'pdf' => 'text-red-600',
                                    'doc', 'docx' => 'text-blue-600',
                                    'ppt', 'pptx' => 'text-orange-600',
                                    default => 'text-gray-600'
                                };
                            @endphp
                            <svg class="w-8 h-8 {{ $color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            <div>
                                <p class="font-medium text-gray-900">{{ $material->title }}</p>
                                <p class="text-sm text-gray-600">{{ $material->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('student.elearning.material', $material) }}" 
                               class="px-4 py-2 text-blue-600 hover:bg-blue-100 font-medium rounded-lg transition">
                                View
                            </a>
                            <a href="{{ route('student.elearning.download', $material) }}" 
                               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                                Download
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Your Grades -->
    @if($grades->isNotEmpty())
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Your Grades</h2>
            <div class="space-y-4">
                @foreach($grades as $grade)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm text-gray-600">{{ $grade->grade_date ? $grade->grade_date->format('M d, Y') : 'N/A' }}</p>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                @if($grade->average >= 80) bg-green-100 text-green-800
                                @elseif($grade->average >= 60) bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                Average: {{ number_format($grade->average, 1) }}
                            </span>
                        </div>
                        <div class="grid grid-cols-6 gap-4">
                            <div class="text-center">
                                <p class="text-sm text-gray-600 mb-1">Listening</p>
                                <p class="text-xl font-bold text-gray-900">{{ $grade->listening ?? '-' }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-600 mb-1">Speaking</p>
                                <p class="text-xl font-bold text-gray-900">{{ $grade->speaking ?? '-' }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-600 mb-1">Reading</p>
                                <p class="text-xl font-bold text-gray-900">{{ $grade->reading ?? '-' }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-600 mb-1">Writing</p>
                                <p class="text-xl font-bold text-gray-900">{{ $grade->writing ?? '-' }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-600 mb-1">Grammar</p>
                                <p class="text-xl font-bold text-gray-900">{{ $grade->grammar ?? '-' }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-600 mb-1">Attendance</p>
                                <p class="text-xl font-bold text-gray-900">{{ $grade->attendance ?? '-' }}</p>
                            </div>
                        </div>
                        @if($grade->notes)
                            <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-700">{{ $grade->notes }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
