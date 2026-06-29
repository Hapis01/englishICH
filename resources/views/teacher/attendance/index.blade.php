@extends('layouts.teacher')

@section('title', 'Attendance Management')
@section('page-title', 'Attendance')
@section('page-subtitle', 'Manage student attendance for your classes')

@section('content')
<div class="mb-6 flex justify-end">
    <a href="{{ route('teacher.attendance.report') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <span>View Attendance Report</span>
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-semibold mb-4">Create New Session</h3>
    <form action="{{ route('teacher.attendance.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Select Class</label>
                <select name="class_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" required>
                    @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Session Title</label>
                <input type="text" name="title" placeholder="e.g. Week 1 - Introduction" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" required>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" name="session_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Start Time (Optional)</label>
                <input type="time" name="start_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">End Time (Optional)</label>
                <input type="time" name="end_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
            </div>
        </div>
        <div class="text-xs text-gray-500 italic mb-2">
            If start and end times are set, the session will automatically open and close for students during that window. Otherwise, you must manually open it.
        </div>
        <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-md hover:bg-emerald-700 transition">Create Session</button>
    </form>
</div>

<div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-semibold mb-4">Recent Sessions</h3>
    @if($sessions->count() > 0)
    <ul class="space-y-3">
        @foreach($sessions as $session)
        <li class="p-4 bg-gray-50 rounded-lg flex justify-between items-center hover:bg-gray-100 transition">
            <div>
                <a href="{{ route('teacher.attendance.show', $session) }}" class="font-bold text-emerald-600 hover:text-emerald-700">{{ $session->title }}</a>
                <p class="text-sm text-gray-500">
                    {{ $session->schoolClass->name }} | {{ $session->session_date->format('d M Y') }}
                    @if($session->start_time && $session->end_time)
                        | {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }}
                    @endif
                </p>
                <div class="mt-1 flex items-center space-x-2">
                    <span class="w-2 h-2 rounded-full {{ $session->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                    <span class="text-xs font-semibold text-gray-600">{{ $session->is_active ? 'Open' : 'Closed' }}</span>
                    @if($session->is_open)
                        <span class="text-[10px] bg-blue-100 text-blue-700 px-1.5 rounded ml-1">Manually Opened</span>
                    @elseif($session->start_time && $session->end_time)
                        <span class="text-[10px] bg-purple-100 text-purple-700 px-1.5 rounded ml-1">Auto Scheduled</span>
                    @endif
                </div>
            </div>
            <div class="space-x-2 flex items-center">
                <a href="{{ route('teacher.attendance.show', $session) }}" class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded text-sm hover:bg-emerald-200">Manage</a>
                <form action="{{ route('teacher.attendance.destroy', $session) }}" method="POST" onsubmit="return confirm('Delete this session?');">
                    @csrf @method('DELETE')
                    <button class="px-3 py-1 bg-red-50 text-red-600 rounded text-sm hover:bg-red-100">Delete</button>
                </form>
            </div>
        </li>
        @endforeach
    </ul>
    @else
    <p class="text-gray-500">No attendance sessions created yet.</p>
    @endif
</div>
@endsection
