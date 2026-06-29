@extends('layouts.teacher')

@section('title', 'Online Meetings')
@section('page-title', 'Online Meetings')
@section('page-subtitle', 'Manage your online class meetings')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-semibold mb-4">Create New Meeting</h3>
    <form action="{{ route('teacher.meetings.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700">Select Class</label>
            <select name="class_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" required>
                @foreach($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Meeting Title</label>
            <input type="text" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" required>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Platform</label>
                <select name="platform" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" required>
                    <option value="Google Meet">Google Meet</option>
                    <option value="Zoom">Zoom</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Link</label>
                <input type="url" name="link" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" required>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" name="meeting_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Time</label>
                <input type="time" name="meeting_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" required>
            </div>
        </div>
        <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-md hover:bg-emerald-700">Create Meeting</button>
    </form>
</div>

<div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-semibold mb-4">Upcoming Meetings</h3>
    @if($meetings->count() > 0)
    <ul class="space-y-3">
        @foreach($meetings as $meeting)
        <li class="p-4 bg-gray-50 rounded-lg flex justify-between items-center">
            <div>
                <p class="font-bold">{{ $meeting->title }}</p>
                <p class="text-sm text-gray-500">{{ $meeting->schoolClass->name }} | {{ $meeting->session_date ? $meeting->session_date->format('d M Y') : '-' }} at {{ $meeting->start_time }}</p>
            </div>
            <div class="space-x-2 flex">
                @php
                    $meetingDateTime = null;
                    if ($meeting->session_date && $meeting->start_time) {
                        $meetingDateTime = \Carbon\Carbon::parse($meeting->session_date->format('Y-m-d') . ' ' . $meeting->start_time, 'Asia/Jakarta');
                    }
                    $now = \Carbon\Carbon::now('Asia/Jakarta');
                    $isExpired = $meetingDateTime ? $now->greaterThan($meetingDateTime->copy()->addHours(2)) : false;
                    $isUpcoming = $meetingDateTime ? $now->lessThan($meetingDateTime) : false;
                @endphp
                @if($isExpired)
                    <span class="px-3 py-1 bg-gray-400 text-white rounded text-sm cursor-not-allowed" title="Meeting has ended">Expired</span>
                @elseif($isUpcoming)
                    <span class="px-3 py-1 bg-yellow-500 text-white rounded text-sm cursor-not-allowed" title="Meeting has not started yet">Upcoming</span>
                @else
                    <a href="{{ $meeting->meeting_link }}" target="_blank" class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Join</a>
                @endif
                <form action="{{ route('teacher.meetings.publish', $meeting) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3 py-1 font-bold {{ $meeting->is_published ? 'bg-orange-500 hover:bg-orange-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded text-sm">
                        {{ $meeting->is_published ? 'Set as Draft' : 'Publish' }}
                    </button>
                </form>
                <form action="{{ route('teacher.meetings.destroy', $meeting) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600">Delete</button>
                </form>
            </div>
        </li>
        @endforeach
    </ul>
    @else
    <p class="text-gray-500">No meetings scheduled.</p>
    @endif
</div>
@endsection
