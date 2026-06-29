@extends('layouts.student')

@section('title', 'Dashboard')
@section('page-title', 'Overview')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl shadow-lg p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold mb-2">Welcome back, {{ $student->name }}! 👋</h1>
                <p class="text-blue-100">Ready to continue your learning journey?</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-24 h-24 opacity-20" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Active Attendances Alert -->
    @if($activeAttendances->count() > 0)
        <div class="space-y-3">
            @foreach($activeAttendances as $session)
                <div class="{{ $session->is_active ? 'bg-orange-50 border-orange-500' : 'bg-yellow-50 border-yellow-500' }} border-l-4 p-4 rounded-r-xl shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-0.5">
                            <svg class="h-6 w-6 {{ $session->is_active ? 'text-orange-500' : 'text-yellow-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-bold {{ $session->is_active ? 'text-orange-800' : 'text-yellow-800' }}">
                                {{ $session->is_active ? 'Attendance Required' : 'Upcoming Session' }}: {{ $session->title }}
                            </h3>
                            <div class="mt-1 text-sm {{ $session->is_active ? 'text-orange-700' : 'text-yellow-700' }}">
                                <p>{{ $session->schoolClass->name }} - {{ $session->teacher->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        @if($session->is_active)
                            <form action="{{ route('student.attendance.mark', $session) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition">
                                    Mark Present
                                </button>
                            </form>
                        @else
                            <button type="button" disabled class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-gray-500 bg-gray-200 cursor-not-allowed transition">
                                Starts at {{ $session->start_time ? date('H:i', strtotime($session->start_time)) : 'Manually by Teacher' }}
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Upcoming Online Meetings Alert -->
    @if(isset($upcomingMeetings) && $upcomingMeetings->count() > 0)
        <div class="space-y-3 mt-4">
            @foreach($upcomingMeetings as $meeting)
                @php
                    $meetingDateTime = null;
                    if ($meeting->session_date && $meeting->start_time) {
                        $meetingDateTime = \Carbon\Carbon::parse($meeting->session_date->format('Y-m-d') . ' ' . $meeting->start_time, 'Asia/Jakarta');
                    }
                    $now = \Carbon\Carbon::now('Asia/Jakarta');
                    $isActive = $meetingDateTime ? $now->between($meetingDateTime, $meetingDateTime->copy()->addHours(2)) : false;
                @endphp
                <div class="{{ $isActive ? 'bg-blue-50 border-blue-500' : 'bg-indigo-50 border-indigo-500' }} border-l-4 p-4 rounded-r-xl shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-0.5">
                            <svg class="h-6 w-6 {{ $isActive ? 'text-blue-500' : 'text-indigo-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-bold {{ $isActive ? 'text-blue-800' : 'text-indigo-800' }}">
                                {{ $isActive ? 'Active Online Meeting' : 'Upcoming Online Meeting' }}: {{ $meeting->title }}
                            </h3>
                            <div class="mt-1 text-sm {{ $isActive ? 'text-blue-700' : 'text-indigo-700' }}">
                                <p>{{ $meeting->schoolClass->name }} - {{ $meeting->session_date ? $meeting->session_date->format('M d, Y') : '-' }} at {{ date('H:i', strtotime($meeting->start_time)) }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        @if($isActive)
                            <a href="{{ $meeting->meeting_link }}" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                Join {{ $meeting->platform ?? 'Meeting' }}
                            </a>
                        @else
                            <button type="button" disabled class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-gray-500 bg-gray-200 cursor-not-allowed transition">
                                Starts at {{ date('H:i', strtotime($meeting->start_time)) }} WIB
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Classes -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Enrolled Classes</p>
                    <p class="text-2xl md:text-3xl font-bold text-gray-900">{{ $totalClasses }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- GPA -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Average Score</p>
                    <p class="text-2xl md:text-3xl font-bold text-gray-900">{{ number_format($gpa, 1) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Certificates -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Certificates</p>
                    <p class="text-2xl md:text-3xl font-bold text-gray-900">{{ $certificateCount }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Messages -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Unread Messages</p>
                    <p class="text-2xl md:text-3xl font-bold text-gray-900">{{ $unreadMessages }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Upcoming Session -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Upcoming Session</h3>
            
            @if($upcomingSession)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 mb-1">{{ $upcomingSession->name }}</h4>
                            <p class="text-sm text-gray-600 mb-2">{{ $upcomingSession->course->name }}</p>
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ $upcomingSession->teacher->name }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $upcomingSession->schedule }}
                                </span>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Today</span>
                    </div>
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No upcoming sessions today</p>
            @endif
        </div>

        <!-- Pending Assignments -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Pending Assignments</h3>
                <a href="{{ route('student.assessments.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">View All</a>
            </div>
            
            @if($pendingAssignments->count() > 0)
                <div class="space-y-3">
                    @foreach($pendingAssignments as $assignment)
                        <a href="{{ route('student.assessments.show', $assignment) }}" class="block border border-gray-200 rounded-lg p-3 hover:border-blue-300 transition">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h4 class="font-semibold text-gray-900 text-sm">{{ $assignment->title }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">{{ $assignment->schoolClass->name }}</p>
                                </div>
                                @if($assignment->is_upcoming)
                                    <span class="text-xs font-semibold px-2 py-1 rounded bg-yellow-100 text-yellow-800">
                                        Opens {{ $assignment->start_date ? $assignment->start_date->format('M d') : 'Soon' }}
                                    </span>
                                @else
                                    <span class="text-xs font-semibold px-2 py-1 rounded {{ $assignment->is_overdue ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-orange-700' }}">
                                        Due {{ $assignment->due_date->format('M d') }}
                                    </span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-gray-500 text-sm">All caught up!</p>
                </div>
            @endif
        </div>

        <!-- Current Course -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Current Course</h3>
            
            @if($currentCourse)
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-1">{{ $currentCourse->course->name }}</h4>
                    <p class="text-sm text-gray-600 mb-3">{{ $currentCourse->name }}</p>
                    <a href="{{ route('student.classes') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        View Details →
                    </a>
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No active course</p>
            @endif
        </div>
    </div>

    <!-- Learning Progress & Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Learning Progress -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Learning Progress</h3>
            
            <div class="space-y-4">
                @foreach(['listening' => 'Listening', 'speaking' => 'Speaking', 'reading' => 'Reading', 'writing' => 'Writing', 'grammar' => 'Grammar'] as $key => $label)
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $learningProgress[$key] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $learningProgress[$key] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activities</h3>
            
            <div class="space-y-4">
                @forelse($recentActivities as $activity)
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0">
                            @if($activity['type'] === 'material')
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">{{ $activity['title'] }}</p>
                            <p class="text-sm text-gray-600 truncate">{{ $activity['description'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $activity['class'] }} • {{ $activity['date']->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">No recent activities</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
