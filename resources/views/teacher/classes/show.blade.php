@extends('layouts.teacher')

@section('title', 'Class Overview - ' . $schoolClass->name)
@section('page-title', 'Class Overview')
@section('page-subtitle', $schoolClass->name . ' • ' . $schoolClass->course->name)

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('teacher.classes') }}" class="text-emerald-600 hover:text-emerald-700 flex items-center space-x-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Back to my classes</span>
    </a>
    <button onclick="openAnnounceModal()" class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition flex items-center shadow-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
        Announce to Class
    </button>
</div>

<!-- Class Info Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
    <div class="bg-gradient-to-r from-emerald-600 to-teal-500 px-6 py-8 text-white relative">
        <div class="relative z-10">
            <div class="flex items-center space-x-3 mb-2">
                <span class="px-2.5 py-1 bg-white/20 rounded-lg text-xs font-semibold backdrop-blur-sm uppercase tracking-wide">
                    {{ ucfirst($schoolClass->learning_method) }}
                </span>
                <span class="px-2.5 py-1 bg-white/20 rounded-lg text-xs font-semibold backdrop-blur-sm uppercase tracking-wide">
                    {{ ucfirst($schoolClass->status) }}
                </span>
            </div>
            <h1 class="text-3xl font-bold">{{ $schoolClass->name }}</h1>
            <p class="text-emerald-50 text-lg mt-1">{{ $schoolClass->course->name }}</p>
            
            <div class="flex items-center mt-4 space-x-6">
                <div class="flex items-center text-sm font-medium">
                    <svg class="w-5 h-5 mr-1.5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $schoolClass->schedule }}
                </div>
                <div class="flex items-center text-sm font-medium">
                    <svg class="w-5 h-5 mr-1.5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    {{ $studentsCount }} Students
                </div>
            </div>
        </div>
        <div class="absolute right-0 top-0 h-full w-1/3 opacity-10">
            <svg viewBox="0 0 100 100" class="h-full w-full" preserveAspectRatio="none">
                <polygon fill="currentColor" points="0,100 100,0 100,100"/>
            </svg>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Quick Stats -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <p class="text-sm font-medium text-gray-500">Attendance Rate</p>
                <p class="text-2xl font-bold mt-1 {{ $attendanceRate >= 80 ? 'text-green-600' : ($attendanceRate >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ $attendanceRate }}%
                </p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <p class="text-sm font-medium text-gray-500">Materials</p>
                <p class="text-2xl font-bold mt-1 text-blue-600">{{ $materialsCount }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <p class="text-sm font-medium text-gray-500">Assessments</p>
                <p class="text-2xl font-bold mt-1 text-purple-600">{{ $assessmentsCount }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <p class="text-sm font-medium text-gray-500">Students</p>
                <p class="text-2xl font-bold mt-1 text-gray-900">{{ $studentsCount }}</p>
            </div>
        </div>

        <!-- Recent Assessments -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Class Assessments</h3>
                <a href="{{ route('teacher.assessments.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Manage All</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($schoolClass->assessments->sortByDesc('created_at')->take(5) as $assessment)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $assessment->title }}</h4>
                            <div class="flex items-center space-x-3 mt-1 text-xs text-gray-500">
                                <span>{{ $assessment->type }}</span>
                                <span>•</span>
                                <span>Due: {{ $assessment->due_date ? $assessment->due_date->format('M d') : 'No limit' }}</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $assessment->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $assessment->is_published ? 'Published' : 'Draft' }}
                            </span>
                            <a href="{{ route('teacher.assessments.submissions', $assessment) }}" class="text-sm bg-blue-50 text-blue-600 px-3 py-1 rounded-md hover:bg-blue-100 font-medium transition">
                                Grade
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">No assessments created for this class yet.</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Materials -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Recent Materials</h3>
                <a href="{{ route('teacher.classes') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Manage All</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($schoolClass->materials->sortByDesc('created_at')->take(5) as $material)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $material->title }}</h4>
                                <p class="text-xs text-gray-500 mt-1">Week {{ $material->week_number }}</p>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="text-sm text-gray-600 hover:text-gray-900">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        </a>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">No materials uploaded for this class yet.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="space-y-6">
        
        <!-- Attendance Analytics / At-Risk Students -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-red-100 bg-red-50">
                <h3 class="text-lg font-semibold text-red-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    At-Risk Students
                </h3>
                <p class="text-xs text-red-700 mt-1">Frequently absent or late</p>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($atRiskStudents as $student)
                    <div class="p-4 hover:bg-gray-50 transition">
                        <div class="flex items-center justify-between mb-2">
                            <a href="{{ route('teacher.students.show', $student) }}" class="font-medium text-gray-900 hover:text-blue-600">{{ $student->name }}</a>
                        </div>
                        <div class="flex space-x-2">
                            @if($student->absent_count > 0)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-800 uppercase">
                                    {{ $student->absent_count }} Absent
                                </span>
                            @endif
                            @if($student->late_count > 0)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-yellow-100 text-yellow-800 uppercase">
                                    {{ $student->late_count }} Late
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500 text-sm">
                        Great! No students are currently at risk for attendance.
                    </div>
                @endforelse
            </div>
            <div class="px-6 py-3 border-t border-gray-100 bg-gray-50 text-center">
                <a href="{{ route('teacher.students.index', ['class_id' => $schoolClass->id]) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                    View all students in class
                </a>
            </div>
        </div>

        <!-- Class Meetings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Upcoming Meetings</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @php
                    $upcoming = $schoolClass->onlineMeetings->where('meeting_status', 'scheduled')->where('session_date', '>=', now()->format('Y-m-d'));
                @endphp
                @forelse($upcoming as $meeting)
                    <div class="p-4">
                        <h4 class="font-medium text-gray-900 text-sm">{{ $meeting->title }}</h4>
                        <div class="text-xs text-gray-500 mt-1 flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ \Carbon\Carbon::parse($meeting->session_date)->format('M d, Y') }} at {{ $meeting->start_time }}
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500 text-sm">
                        No upcoming online meetings scheduled.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

<!-- Announce Modal -->
<div id="announceModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">Announce to Class</h3>
            <button onclick="closeAnnounceModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('teacher.classes.announce', $schoolClass) }}" method="POST">
            @csrf
            <div class="p-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                <textarea name="message" rows="4" required placeholder="Type your announcement here..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                <p class="text-xs text-gray-500 mt-2">This will send a notification to all {{ $studentsCount }} students in this class.</p>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end space-x-3">
                <button type="button" onclick="closeAnnounceModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition">Send Announcement</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openAnnounceModal() {
        document.getElementById('announceModal').classList.remove('hidden');
    }
    
    function closeAnnounceModal() {
        document.getElementById('announceModal').classList.add('hidden');
    }

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAnnounceModal();
        }
    });
</script>
@endpush
