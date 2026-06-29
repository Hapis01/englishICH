@extends('layouts.student')

@section('title', 'Active Classes')
@section('page-title', 'Active Classes')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">My Active Classes</h2>
        <p class="text-gray-600">View your enrolled classes and schedules</p>
    </div>

    @if($activeClasses->isEmpty())
        <div class="bg-white rounded-xl shadow p-12 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Active Classes</h3>
            <p class="text-gray-600">You don't have any active classes at the moment.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($activeClasses as $class)
                <div class="bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition">
                    <!-- Class Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6 text-white">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-xl font-bold mb-2">{{ $class->name }}</h3>
                                <p class="text-blue-100">{{ $class->course->name }}</p>
                            </div>
                            @if($class->is_today)
                                <span class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">Today</span>
                            @endif
                        </div>
                        
                        <div class="flex items-center space-x-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>{{ $class->teacher->name }}</span>
                        </div>
                    </div>

                    <!-- Class Details -->
                    <div class="p-6 space-y-4">
                        <!-- Schedule -->
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Schedule</p>
                                <p class="text-sm text-gray-600">{{ $class->schedule }}</p>
                            </div>
                        </div>

                        <!-- Next Session -->
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Next Session</p>
                                <p class="text-sm text-gray-600">{{ $class->next_session }}</p>
                            </div>
                        </div>

                        <!-- Mode (Online/Offline) -->
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($class->is_online)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    @endif
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Mode</p>
                                <p class="text-sm text-gray-600">
                                    @if($class->is_online)
                                        Online Class
                                    @else
                                        Offline Class
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Duration -->
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Duration</p>
                                <p class="text-sm text-gray-600">{{ $class->start_date->format('M d, Y') }} - {{ $class->end_date->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="pt-4 border-t space-y-2">
                            @if($class->is_online && $class->is_today)
                                @php
                                    $isMeetingActive = false;
                                    $meetingStatus = 'upcoming';
                                    
                                    if (preg_match('/(\d{1,2}:\d{2})\s*-\s*(\d{1,2}:\d{2})/', $class->schedule, $timeMatches)) {
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
                                @endphp

                                @if($meetingStatus === 'active')
                                <a href="{{ route('student.classes.join', $class) }}" 
                                   class="block w-full text-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                        Join Google Meet
                                    </span>
                                </a>
                                @elseif($meetingStatus === 'upcoming')
                                <button disabled class="block w-full text-center px-4 py-2 bg-yellow-500 text-white font-medium rounded-lg cursor-not-allowed opacity-75">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Upcoming Meeting
                                    </span>
                                </button>
                                @elseif($meetingStatus === 'expired')
                                <button disabled class="block w-full text-center px-4 py-2 bg-gray-400 text-white font-medium rounded-lg cursor-not-allowed opacity-75">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Meeting Expired
                                    </span>
                                </button>
                                @endif
                            @endif
                            
                            <a href="{{ route('student.classes.show', $class) }}" 
                               class="block w-full text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
