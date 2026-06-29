@extends('layouts.teacher')

@section('title', 'Student Profile: ' . $student->name)
@section('page-title', 'Student Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('teacher.students.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center space-x-2 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Back to Student List</span>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Profile & Notes -->
    <div class="space-y-6">
        <!-- Profile Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="text-center">
                <div class="relative inline-block">
                    @if($student->profile_photo)
                        <img class="h-32 w-32 rounded-full object-cover border-4 border-white shadow-lg mx-auto" src="{{ asset(\Illuminate\Support\Str::startsWith($student->profile_photo, 'profile/') ? $student->profile_photo : 'profile/' . $student->profile_photo) }}" alt="">
                    @else
                        <div class="h-32 w-32 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-4xl border-4 border-white shadow-lg mx-auto">
                            {{ strtoupper(substr($student->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="absolute bottom-0 right-0 h-6 w-6 rounded-full border-2 border-white {{ $student->status == 'active' ? 'bg-green-500' : 'bg-red-500' }}"></div>
                </div>
                
                <h2 class="mt-4 text-2xl font-bold text-gray-900">{{ $student->name }}</h2>
                <p class="text-gray-500 text-sm mb-4">Student ID: {{ $student->id }}</p>
                
                <div class="flex justify-center space-x-2">
                    @if($student->whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $student->whatsapp) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        WhatsApp
                    </a>
                    @endif
                </div>
            </div>
            
            <hr class="my-6 border-gray-100">
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Enrolled Classes</span>
                    <span class="text-sm font-medium text-gray-900">{{ $student->enrolledClasses->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Status</span>
                    <span class="text-sm font-medium capitalize text-gray-900">{{ str_replace('_', ' ', $student->student_status) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Joined</span>
                    <span class="text-sm font-medium text-gray-900">{{ $student->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Teacher Notes -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Private Notes
            </h3>
            <p class="text-xs text-gray-500 mb-4">Visible only to you and administrators.</p>

            <form action="{{ route('teacher.students.notes.store', $student) }}" method="POST" class="mb-6">
                @csrf
                <div class="mb-3">
                    <label for="content" class="sr-only">Add Note</label>
                    <textarea name="content" id="content" rows="3" class="shadow-sm block w-full focus:ring-blue-500 focus:border-blue-500 sm:text-sm border border-gray-300 rounded-lg p-3" placeholder="Add an observation, reminder, or follow-up note..."></textarea>
                </div>
                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-colors">
                    Save Note
                </button>
            </form>

            <div class="space-y-4 max-h-80 overflow-y-auto pr-2">
                @forelse($notes as $note)
                    <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-100">
                        <p class="text-sm text-gray-800 whitespace-pre-line">{{ $note->content }}</p>
                        <p class="text-xs text-gray-500 mt-2">{{ $note->created_at->format('M d, Y g:i A') }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">No private notes yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Right Column: Performance, Attendance, Assignments -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Performance Overview Cards -->
        @php
            $presentCount = $student->attendances->where('status', 'Present')->count();
            $totalAttendances = $student->attendances->count();
            $attendanceRate = $totalAttendances > 0 ? round(($presentCount / $totalAttendances) * 100) : 0;

            $scoredCount = $student->assessmentScores->whereNotNull('score')->count();
            $totalScores = $student->assessmentScores->count();
            $totalScoreSum = $student->assessmentScores->sum('score');
            
            $completionRate = $totalScores > 0 ? round(($scoredCount / $totalScores) * 100) : 0;
            $averageScore = $scoredCount > 0 ? round($totalScoreSum / $scoredCount, 1) : 0;
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center">
                <div class="p-3 rounded-full bg-blue-50 text-blue-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Attendance Rate</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $attendanceRate }}%</p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center">
                <div class="p-3 rounded-full bg-indigo-50 text-indigo-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Task Completion</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $completionRate }}%</p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center">
                <div class="p-3 rounded-full bg-green-50 text-green-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Average Grade</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $averageScore }}</p>
                </div>
            </div>
        </div>

        <!-- Report Card & Automated Grading -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#10B981]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Final Report Card
                </h3>
            </div>
            <div class="p-6">
                @foreach($student->enrolledClasses as $class)
                    @php
                        $grade = \App\Models\StudentGrade::where('student_id', $student->id)
                                    ->where('class_id', $class->id)
                                    ->first();
                    @endphp
                    <div class="mb-6 last:mb-0 border border-gray-200 rounded-lg p-5">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
                            <div class="flex items-center space-x-3">
                                <h4 class="text-md font-bold text-gray-800">{{ $class->name }}</h4>
                                @if($grade)
                                    @if($grade->published)
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full uppercase">Published</span>
                                    @else
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full uppercase">Draft</span>
                                    @endif
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full uppercase">Uncalculated</span>
                                @endif
                            </div>
                            <div class="flex space-x-2">
                                <form action="{{ route('teacher.students.calculate-grades', $student) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="class_id" value="{{ $class->id }}">
                                    <button type="submit" onclick="return confirm('This will calculate grades based on submitted assessments and attendance. Proceed?')" class="px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 text-sm font-medium rounded-lg transition shadow-sm flex items-center border border-blue-200">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        Auto-Calculate
                                    </button>
                                </form>
                                @if($grade)
                                    @if($grade->published)
                                        <form action="{{ route('teacher.grading.unpublish', $grade) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-yellow-50 text-yellow-600 hover:bg-yellow-100 text-sm font-medium rounded-lg transition shadow-sm border border-yellow-200">
                                                Unpublish
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('teacher.grading.publish', $grade) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-green-50 text-green-600 hover:bg-green-100 text-sm font-medium rounded-lg transition shadow-sm border border-green-200">
                                                Publish
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                        
                        <form action="{{ route('teacher.grading.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <input type="hidden" name="class_id" value="{{ $class->id }}">
                            
                            <div class="grid grid-cols-2 md:grid-cols-7 gap-4 mt-4 items-end">
                                <div>
                                    <label class="block text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Reading</label>
                                    <input type="number" step="0.01" min="0" max="100" name="reading" value="{{ $grade ? $grade->reading : '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#10B981] focus:border-[#10B981] text-sm text-center font-semibold">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Listening</label>
                                    <input type="number" step="0.01" min="0" max="100" name="listening" value="{{ $grade ? $grade->listening : '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#10B981] focus:border-[#10B981] text-sm text-center font-semibold">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Writing</label>
                                    <input type="number" step="0.01" min="0" max="100" name="writing" value="{{ $grade ? $grade->writing : '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#10B981] focus:border-[#10B981] text-sm text-center font-semibold">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Speaking</label>
                                    <input type="number" step="0.01" min="0" max="100" name="speaking" value="{{ $grade ? $grade->speaking : '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#10B981] focus:border-[#10B981] text-sm text-center font-semibold">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Grammar</label>
                                    <input type="number" step="0.01" min="0" max="100" name="grammar" value="{{ $grade ? $grade->grammar : '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#10B981] focus:border-[#10B981] text-sm text-center font-semibold">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Attendance</label>
                                    <input type="number" step="0.01" min="0" max="100" name="attendance" value="{{ $grade ? $grade->attendance : '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#10B981] focus:border-[#10B981] text-sm text-center font-semibold">
                                </div>
                                <div class="bg-green-50 rounded-lg p-2 text-center border border-green-100 flex flex-col justify-center h-[38px] mt-[18px]">
                                    <span class="block text-[10px] text-green-600 uppercase tracking-wider font-semibold">Total GPA</span>
                                    <span class="text-sm font-bold text-green-700">{{ $grade && $grade->average !== null ? number_format($grade->average, 1) : '-' }}</span>
                                </div>
                            </div>
                            
                            <div class="mt-4 flex justify-end">
                                <button type="submit" class="px-4 py-2 bg-[#10B981] hover:bg-[#0B4637] text-white text-sm font-medium rounded-lg transition shadow-sm">
                                    Save Changes & Recalculate GPA
                                </button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Assignments & Grades -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Assignments & Grades</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assessment</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($student->assessmentScores as $score)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $score->assessment->title }}</div>
                                    <div class="text-xs text-gray-500">{{ $score->assessment->type }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $score->assessment->schoolClass->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($score->file_path)
                                        <div class="text-sm text-gray-900">{{ $score->submitted_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-green-600">File attached</div>
                                    @else
                                        <span class="text-sm text-gray-500 italic">Manual Entry</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($score->score !== null)
                                        <div class="flex items-center space-x-2">
                                            <span class="text-sm font-bold text-gray-900">{{ floatval($score->score) }} / {{ floatval($score->maximum_score ?? 100) }}</span>
                                            @if($score->is_published)
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-800 uppercase tracking-wide">Pub</span>
                                            @else
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-yellow-100 text-yellow-800 uppercase tracking-wide">Draft</span>
                                            @endif
                                        </div>
                                    @else
                                        <a href="{{ route('teacher.assessments.submissions', $score->assessment) }}" class="text-xs font-medium text-orange-600 hover:text-orange-900 bg-orange-50 px-2 py-1 rounded">Needs Grading</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500 text-sm">
                                    No assessments recorded for this student.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Attendance History -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Recent Attendance</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Session</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($student->attendances->sortByDesc('created_at')->take(10) as $attendance)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $attendance->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $attendance->session->schoolClass->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $attendance->session->title }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($attendance->status == 'Present')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Present</span>
                                    @elseif($attendance->status == 'Late')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Late</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Absent</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500 text-sm">
                                    No attendance records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
