@extends('layouts.teacher')

@section('title', 'Attendance Report')
@section('page-title', 'Attendance Report')
@section('page-subtitle', 'View attendance statistics for your classes')

@section('content')
<div class="mb-6">
    <a href="{{ route('teacher.attendance.index') }}" class="text-emerald-600 hover:text-emerald-700 flex items-center space-x-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Back to Attendance</span>
    </a>
</div>

<div class="space-y-6">
    @forelse($classes as $class)
        @php
            $totalSessions = $class->attendanceSessions->count();
            $students = $class->students;
        @endphp
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-800">{{ $class->name }}</h3>
                <p class="text-sm text-gray-500">{{ $class->course->name }} • {{ $totalSessions }} Sessions Total</p>
            </div>
            
            @if($totalSessions > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-sm font-semibold text-gray-600 sticky left-0 bg-white">Student Name</th>
                            <th class="px-6 py-3 text-sm font-semibold text-gray-600 text-center">Present</th>
                            <th class="px-6 py-3 text-sm font-semibold text-gray-600 text-center">Absent</th>
                            <th class="px-6 py-3 text-sm font-semibold text-gray-600 text-center">Late</th>
                            <th class="px-6 py-3 text-sm font-semibold text-gray-600 text-center">Excused</th>
                            <th class="px-6 py-3 text-sm font-semibold text-gray-600 text-right">Attendance Rate</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($students as $student)
                            @php
                                $studentAttendances = collect();
                                foreach($class->attendanceSessions as $session) {
                                    $att = $session->attendances->where('student_id', $student->id)->first();
                                    if ($att) {
                                        $studentAttendances->push($att);
                                    }
                                }
                                
                                $presentCount = $studentAttendances->where('status', 'Present')->count();
                                $absentCount = $studentAttendances->where('status', 'Absent')->count() + ($totalSessions - $studentAttendances->count());
                                $lateCount = $studentAttendances->where('status', 'Late')->count();
                                $excusedCount = $studentAttendances->where('status', 'Excused')->count();
                                
                                // Present + Late (partial) / Total
                                // For simplicity, Present and Late count towards attendance rate
                                $attendanceRate = $totalSessions > 0 ? round((($presentCount + $lateCount) / $totalSessions) * 100) : 0;
                            @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-800 sticky left-0 bg-inherit">{{ $student->name }}</td>
                            <td class="px-6 py-4 text-center text-green-600 font-semibold">{{ $presentCount }}</td>
                            <td class="px-6 py-4 text-center text-red-600 font-semibold">{{ $absentCount }}</td>
                            <td class="px-6 py-4 text-center text-yellow-600 font-semibold">{{ $lateCount }}</td>
                            <td class="px-6 py-4 text-center text-blue-600 font-semibold">{{ $excusedCount }}</td>
                            <td class="px-6 py-4 text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $attendanceRate >= 80 ? 'bg-green-100 text-green-800' : ($attendanceRate >= 60 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $attendanceRate }}%
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-6 text-center text-gray-500">
                No attendance sessions recorded for this class yet.
            </div>
            @endif
        </div>
    @empty
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center text-gray-500">
            You don't have any classes assigned.
        </div>
    @endforelse
</div>
@endsection
