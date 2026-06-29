@extends('layouts.admin')

@section('title', 'Teacher Attendance Management')
@section('page-title', 'Teacher Attendance Management')

@section('content')
<div class="space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Present</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['total_present'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Absent</p>
                    <p class="text-3xl font-bold text-red-600">{{ $stats['total_absent'] }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Schedule & Status -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Today's Schedule & Status - {{ now()->format('l, F d, Y') }}</h3>
        
        @if($todaySchedules->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teacher</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Time Window</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($todaySchedules as $schedule)
                            @php
                                $todayRecord = $todayAttendances->where('class_id', $schedule->id)->first();
                                $hasStarted = now()->format('H:i') >= date('H:i', strtotime($schedule->start_time));
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $schedule->teacher->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $schedule->schoolClass->name }}</td>
                                <td class="px-4 py-3 text-sm text-center text-gray-900">{{ date('H:i', strtotime($schedule->start_time)) }} - {{ date('H:i', strtotime($schedule->end_time)) }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($todayRecord)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                            @if($todayRecord->teacher_attendance_status === 'Present') bg-green-100 text-green-800
                                            @elseif($todayRecord->teacher_attendance_status === 'Late') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $todayRecord->teacher_attendance_status }}
                                        </span>
                                    @elseif(!$hasStarted)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Coming Soon
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                                            Pending
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-6 text-gray-500">
                No classes scheduled for today.
            </div>
        @endif
    </div>

    <!-- Schedule Management -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Attendance Schedules</h3>
            @if(Auth::user()->role !== 'owner')
            <button onclick="document.getElementById('addScheduleModal').classList.remove('hidden')" class="px-4 py-2 bg-[#10B981] text-white rounded-lg hover:bg-[#0B4637] transition text-sm font-medium">
                + Add Schedule
            </button>
            @endif
        </div>

        @if($settings->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teacher</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Days</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Time</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Schedule</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($settings as $setting)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $setting->teacher->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $setting->schoolClass->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                @foreach($setting->days as $day)
                                    <span class="inline-block px-2 py-0.5 text-xs bg-blue-100 text-blue-800 rounded mr-1 mb-1">{{ substr($day, 0, 3) }}</span>
                                @endforeach
                            </td>
                            <td class="px-4 py-3 text-sm text-center text-gray-900">{{ date('H:i', strtotime($setting->start_time)) }} - {{ date('H:i', strtotime($setting->end_time)) }}</td>
                            <td class="px-4 py-3 text-sm text-center">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $setting->attendance_type === 'morning' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($setting->attendance_type) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-center">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $setting->schedule_type === 'recurring' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                    {{ $setting->schedule_type === 'recurring' ? 'Recurring' : 'Today Only' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if(Auth::user()->role !== 'owner')
                                <form action="{{ route('admin.teacher-attendance.schedule.destroy', $setting) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-red-600 hover:bg-red-50 rounded transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-500">No attendance schedules created yet.</p>
            </div>
        @endif
    </div>

    <!-- Filters & Attendance Records -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Attendance Records</h3>

        <!-- Filters -->
        <form method="GET" action="{{ route('admin.teacher-attendance.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teacher</label>
                <select name="teacher_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] text-sm">
                    <option value="">All Teachers</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                <select name="class_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] text-sm">
                    <option value="">All Classes</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Period</label>
                <select name="period" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] text-sm">
                    <option value="">All Time</option>
                    <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="this_week" {{ request('period') == 'this_week' ? 'selected' : '' }}>This Week</option>
                    <option value="this_month" {{ request('period') == 'this_month' ? 'selected' : '' }}>This Month</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] text-sm">
                    <option value="">All Status</option>
                    <option value="Present" {{ request('status') == 'Present' ? 'selected' : '' }}>Present</option>
                    <option value="Absent" {{ request('status') == 'Absent' ? 'selected' : '' }}>Absent</option>
                </select>
            </div>
            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-[#10B981] text-white rounded-lg hover:bg-[#0B4637] transition text-sm">Filter</button>
                <a href="{{ route('admin.teacher-attendance.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm">Reset</a>
            </div>
        </form>

        <!-- Export Buttons moved to Reports Module -->

        <!-- Table -->
        <div class="overflow-x-auto">
            @if($attendances->count() > 0)
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teacher</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Time In</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Time Out</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($attendances as $att)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $att->teacher->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $att->schoolClass->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $att->date->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-sm text-center text-gray-900">{{ $att->time_in ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-center text-gray-900">{{ $att->time_out ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($att->status === 'Present') bg-green-100 text-green-800
                                    @elseif($att->status === 'Absent') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $att->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ Str::limit($att->notes, 40) ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-4 py-4">
                    {{ $attendances->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500">No attendance records found.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Schedule Modal -->
<div id="addScheduleModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Add Attendance Schedule</h3>
        </div>
        <form action="{{ route('admin.teacher-attendance.schedule.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Target Type</label>
                    <select name="target_type" id="target_type" onchange="toggleSpecificFields(this)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981]">
                        <option value="all">All Teachers</option>
                        <option value="morning">Morning Teachers Only</option>
                        <option value="afternoon">Afternoon Teachers Only</option>
                        <option value="specific_teacher">Specific Teacher</option>
                    </select>
                </div>

                <div id="specific_teacher_container" class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">If the teacher is specific then select from the following</label>
                    <select name="teacher_id" id="teacher_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981]">
                        <option value="">-- Choose Teacher --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Days</label>
                    <div class="grid grid-cols-4 gap-2">
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            <label class="flex items-center space-x-2 text-sm">
                                <input type="checkbox" name="days[]" value="{{ $day }}" class="rounded border-gray-300 text-[#10B981] focus:ring-[#10B981]">
                                <span>{{ $day }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Time</label>
                        <input type="time" name="start_time" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">End Time</label>
                        <input type="time" name="end_time" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981]">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Attendance Type</label>
                        <select name="attendance_type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981]">
                            <option value="morning">Morning (11:00 - 14:00)</option>
                            <option value="afternoon">Afternoon (16:00 - 20:00)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Schedule Type</label>
                        <select name="schedule_type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981]">
                            <option value="recurring">Recurring</option>
                            <option value="today_only">Today Only</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('addScheduleModal').classList.add('hidden')" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-[#10B981] text-white rounded-lg hover:bg-[#0B4637] transition">Save Schedule</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function toggleSpecificFields(element) {
        const targetSelect = element || document.querySelector('#addScheduleModal #target_type');
        const targetType = targetSelect ? targetSelect.value : '';
        const teacherSelect = document.querySelector('#addScheduleModal #teacher_id');
        
        if (!teacherSelect) return;

        if (targetType === 'specific_teacher') {
            teacherSelect.required = true;
        } else {
            teacherSelect.required = false;
            teacherSelect.value = '';
        }
    }

    // Call on load to set initial state
    toggleSpecificFields();

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('addScheduleModal').classList.add('hidden');
        }
    });
</script>
@endpush
@endsection
