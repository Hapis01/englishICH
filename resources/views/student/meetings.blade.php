@extends('layouts.student')

@section('title', 'Online Meetings')
@section('page-title', 'Online Meetings')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Upcoming Online Meetings</h2>
        <p class="text-gray-600">View your upcoming online meetings from enrolled classes.</p>
    </div>

    @if($meetings->isEmpty())
        <div class="bg-white rounded-xl shadow p-12 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Upcoming Meetings</h3>
            <p class="text-gray-600">You don't have any upcoming online meetings scheduled at the moment.</p>
        </div>
    @else
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <ul class="divide-y divide-gray-200">
                @foreach($meetings as $meeting)
                    @php
                        $meetingDateTime = null;
                        if ($meeting->session_date && $meeting->start_time) {
                            $meetingDateTime = \Carbon\Carbon::parse($meeting->session_date->format('Y-m-d') . ' ' . $meeting->start_time, 'Asia/Jakarta');
                        }
                        $now = \Carbon\Carbon::now('Asia/Jakarta');
                        $isExpired = $meetingDateTime ? $now->greaterThan($meetingDateTime->copy()->addHours(2)) : false;
                        $isUpcoming = $meetingDateTime ? $now->lessThan($meetingDateTime) : false;
                        $isActive = !$isExpired && !$isUpcoming;
                    @endphp
                    <li class="p-6 {{ $isActive ? 'bg-blue-50' : 'hover:bg-gray-50' }} transition">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-12 h-12 rounded-lg flex items-center justify-center {{ $isActive ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600' }}">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-bold text-gray-900">{{ $meeting->title }}</h3>
                                    <p class="text-sm font-medium text-gray-600 mt-1">{{ $meeting->schoolClass->name }}</p>
                                    <div class="mt-2 flex items-center text-sm text-gray-500 space-x-4">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $meeting->session_date->format('l, M d, Y') }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ date('H:i', strtotime($meeting->start_time)) }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            {{ $meeting->teacher->name }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0 mt-4 sm:mt-0">
                                @if($isExpired)
                                    <span class="inline-flex items-center px-4 py-2 bg-gray-400 text-white font-medium rounded-lg shadow-sm cursor-not-allowed">
                                        Expired
                                    </span>
                                @elseif($isUpcoming)
                                    <span class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white font-medium rounded-lg shadow-sm cursor-not-allowed">
                                        Starts at {{ date('H:i', strtotime($meeting->start_time)) }} WIB
                                    </span>
                                @else
                                    <a href="{{ $meeting->meeting_link }}" target="_blank" class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition">
                                        Join {{ $meeting->platform ?? 'Meeting' }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
