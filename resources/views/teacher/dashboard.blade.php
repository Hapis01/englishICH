@extends('layouts.teacher')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, ' . explode(' ', trim($teacher->name))[0])

@section('content')
<div class="space-y-6">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-[#0B4637] to-[#10B981] rounded-xl shadow-lg p-6 text-white relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between">
            <div class="text-center md:text-left mb-4 md:mb-0">
                <h2 class="text-xl md:text-2xl font-bold">Welcome back, {{ $teacher->name }}! 👋</h2>
                <p class="text-emerald-100 mt-2 text-sm md:text-base">Here's your academic management overview for today.</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('teacher.students.index') }}" class="bg-white/20 hover:bg-white/30 backdrop-blur text-white px-4 py-2 rounded-lg font-medium transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Manage Students
                </a>
                <a href="{{ route('teacher.assessments.create') }}" class="bg-white text-emerald-800 hover:bg-emerald-50 px-4 py-2 rounded-lg font-bold transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    New Assessment
                </a>
            </div>
        </div>
        <div class="absolute -right-10 -bottom-10 opacity-10">
            <svg class="w-64 h-64 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('teacher.meetings.index') }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm border border-gray-200 hover:bg-emerald-50 hover:border-emerald-200 transition">
            <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center mb-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
            </div>
            <span class="text-sm font-medium text-gray-700">Online Meetings</span>
        </a>
        <a href="{{ route('teacher.attendance.index') }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm border border-gray-200 hover:bg-blue-50 hover:border-blue-200 transition">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mb-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <span class="text-sm font-medium text-gray-700">Attendance</span>
        </a>
        <a href="{{ route('teacher.assessments.index') }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm border border-gray-200 hover:bg-purple-50 hover:border-purple-200 transition">
            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mb-2">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <span class="text-sm font-medium text-gray-700">Assessments</span>
        </a>
        <a href="{{ route('teacher.classes') }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm border border-gray-200 hover:bg-orange-50 hover:border-orange-200 transition">
            <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mb-2">
                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <span class="text-sm font-medium text-gray-700">My Classes</span>
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
        <!-- Total Students -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500 font-medium">Total Active Students</p>
                    <p class="text-2xl md:text-3xl font-bold text-gray-800 mt-2">{{ $totalStudents }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <a href="{{ route('teacher.students.index') }}" class="text-xs font-semibold text-blue-600 mt-4 inline-block hover:underline">View student list →</a>
        </div>

        <!-- Average GPA -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500 font-medium">Average GPA</p>
                    <p class="text-2xl md:text-3xl font-bold mt-2 {{ $averageGpa >= 80 ? 'text-green-600' : ($averageGpa >= 50 ? 'text-yellow-600' : 'text-red-600') }}">{{ number_format($averageGpa, 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
            </div>
            <span class="text-xs text-gray-500 mt-4 inline-block">Across all classes</span>
        </div>

        <!-- Attendance Rate -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500 font-medium">Avg Attendance Rate</p>
                    <p class="text-2xl md:text-3xl font-bold mt-2 {{ $avgAttendanceRate >= 80 ? 'text-green-600' : ($avgAttendanceRate >= 50 ? 'text-yellow-600' : 'text-red-600') }}">{{ $avgAttendanceRate }}%</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <span class="text-xs text-gray-500 mt-4 inline-block">For the current month</span>
        </div>

        <!-- Pending Assignments -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500 font-medium">Submissions to Grade</p>
                    <p class="text-2xl md:text-3xl font-bold text-gray-800 mt-2">{{ $pendingAssignmentsCount }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <a href="{{ route('teacher.assessments.index') }}" class="text-xs font-semibold text-yellow-600 mt-4 inline-block hover:underline">Start grading →</a>
        </div>

        <!-- Draft Assessments -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500 font-medium">Draft Assessments</p>
                    <p class="text-2xl md:text-3xl font-bold text-gray-800 mt-2">{{ $pendingAssessments }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
            </div>
            <span class="text-xs text-gray-500 mt-4 inline-block">Need to be published</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Today's Schedule -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Today's Schedule</h3>
            </div>
            <div class="p-6">
                @if($todaySchedule->count() > 0)
                    <div class="space-y-4">
                        @foreach($todaySchedule as $class)
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="w-10 h-10 bg-[#10B981] rounded-lg flex items-center justify-center text-white font-bold flex-shrink-0 shadow-sm">
                                {{ substr($class->course->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-gray-800">{{ $class->name }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ $class->course->name }} &bull; {{ ucfirst($class->learning_method) }}</p>
                                
                                <div class="flex items-center space-x-4 mt-2">
                                    <span class="text-xs text-gray-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $class->schedule }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-gray-500 mt-2 text-sm">No classes scheduled for today.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Upcoming Meetings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Upcoming Meetings</h3>
                <a href="{{ route('teacher.meetings.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">View All</a>
            </div>
            <div class="p-6">
                @if($upcomingMeetings->count() > 0)
                    <div class="space-y-4">
                        @foreach($upcomingMeetings as $meeting)
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-gray-800">{{ $meeting->title }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ $meeting->schoolClass->name }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $meeting->session_date ? $meeting->session_date->format('M d, Y') : '-' }} at {{ date('H:i', strtotime($meeting->start_time)) }}</p>
                            </div>
                            @if($meeting->meeting_link)
                            <a href="{{ $meeting->meeting_link }}" target="_blank" class="text-xs bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600 transition shadow-sm">Join</a>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-indigo-100 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        <p class="text-gray-500 text-sm mt-2">No upcoming meetings</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Activity Feed (Recent Submissions) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Recent Submissions</h3>
                <a href="{{ route('teacher.assessments.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">Grade All</a>
            </div>
            <div class="p-6">
                @if($recentSubmissions->count() > 0)
                    <div class="space-y-4 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-300 before:to-transparent">
                        @foreach($recentSubmissions as $submission)
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                            <!-- Icon -->
                            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-blue-100 text-blue-600 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <!-- Card -->
                            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-lg border border-slate-200 shadow-sm bg-white">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="font-bold text-slate-900 text-sm">{{ $submission->student->name }}</h4>
                                    <time class="text-xs font-medium text-indigo-500">{{ $submission->submitted_at->diffForHumans() }}</time>
                                </div>
                                <p class="text-xs text-slate-500">{{ $submission->assessment->title }}</p>
                                <a href="{{ route('teacher.assessments.submissions', $submission->assessment) }}" class="mt-2 inline-flex text-xs font-semibold text-blue-600 hover:underline">
                                    {{ $submission->score === null ? 'Needs Grading →' : 'View Grade →' }}
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-slate-200 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <p class="text-gray-500 text-sm mt-2">No recent student activity.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
