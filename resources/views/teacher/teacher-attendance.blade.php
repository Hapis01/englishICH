@extends('layouts.teacher')

@section('title', 'Teacher Attendance')
@section('page-title', 'Teacher Attendance')
@section('page-subtitle', 'Manage your attendance records')

@section('content')
<div class="space-y-6">
    <!-- Today's Schedule -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Today's Schedule - {{ now()->format('l, F d, Y') }}</h3>

        @if($todaySchedules->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($todaySchedules as $schedule)
                    @php
                        $todayRecord = $todayAttendances->where('class_id', $schedule->id)->first();
                        $isCheckedIn = $todayRecord && $todayRecord->time_in;
                        $isCheckedOut = $todayRecord && $todayRecord->time_out;
                    @endphp
                    <div class="border border-gray-200 rounded-lg p-4 {{ $isCheckedIn ? 'bg-green-50 border-green-300' : 'bg-white' }}">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="font-semibold text-gray-900">{{ $schedule->schoolClass->name }}</h4>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $schedule->attendance_type === 'morning' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ ucfirst($schedule->attendance_type) }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-600 space-y-1 mb-3">
                            <p><span class="font-medium">Time Window:</span> {{ date('H:i', strtotime($schedule->start_time)) }} - {{ date('H:i', strtotime($schedule->end_time)) }}</p>
                        </div>

                        @if($isCheckedOut)
                            <div class="text-center py-2">
                                <span class="text-green-700 font-semibold text-sm">✓ Completed</span>
                                <p class="text-xs text-gray-500 mt-1">In: {{ $todayRecord->time_in }} | Out: {{ $todayRecord->time_out }}</p>
                                <span class="inline-block mt-1 px-2 py-1 text-xs font-semibold rounded-full
                                    @if($todayRecord->status === 'Present') bg-green-100 text-green-800
                                    @elseif($todayRecord->status === 'Late') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $todayRecord->status }}
                                </span>
                            </div>
                        @elseif($isCheckedIn)
                            <div class="space-y-2">
                                <p class="text-sm text-green-700 font-semibold">✓ Checked In at {{ $todayRecord->time_in }}</p>
                                <form action="{{ route('teacher.teacher-attendance.checkout') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="attendance_id" value="{{ $todayRecord->id }}">
                                    <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm font-medium">
                                        Check Out
                                    </button>
                                </form>
                            </div>
                        @else
                            <form action="{{ route('teacher.teacher-attendance.checkin') }}" method="POST">
                                @csrf
                                <input type="hidden" name="setting_id" value="{{ $schedule->id }}">
                                <button type="submit" class="w-full px-4 py-2 bg-[#10B981] text-white rounded-lg hover:bg-[#0B4637] transition text-sm font-medium">
                                    Check In
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-16 h-16 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-gray-500 mt-4">No attendance schedule for today</p>
            </div>
        @endif
    </div>

    <!-- Attendance History -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">Attendance History</h3>
        </div>
        <div class="overflow-x-auto">
            @if($attendanceHistory->count() > 0)
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Day</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Time In</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Time Out</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($attendanceHistory as $record)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $record->date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $record->date->format('l') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $record->schoolClass->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-center text-gray-900">{{ $record->time_in ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-center text-gray-900">{{ $record->time_out ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($record->status === 'Present') bg-green-100 text-green-800
                                    @elseif($record->status === 'Late') bg-yellow-100 text-yellow-800
                                    @elseif($record->status === 'Absent') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $record->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($record->notes, 50) ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4">
                    {{ $attendanceHistory->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500">No attendance records found</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
