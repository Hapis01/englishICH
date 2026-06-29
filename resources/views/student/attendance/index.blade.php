@extends('layouts.student')

@section('title', 'Attendance')
@section('page-title', 'Attendance')

@section('content')
<div class="space-y-6">
    <!-- Active Sessions -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Mark Attendance (Today)</h2>
        
        @if($activeSessions->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($activeSessions as $session)
                    @php
                        // Check if student already marked attendance for this session
                        $alreadyMarked = \App\Models\Attendance::where('attendance_session_id', $session->id)
                            ->where('student_id', Auth::id())
                            ->exists();
                    @endphp
                    <div class="border border-blue-100 rounded-xl p-5 bg-blue-50/50 hover:bg-blue-50 transition">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $session->schoolClass->name }}</h3>
                                <p class="text-sm text-blue-600">{{ $session->title }}</p>
                            </div>
                            @if($alreadyMarked)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Marked
                                </span>
                            @elseif($session->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 animate-pulse">
                                    Open
                                </span>
                            @elseif($session->end_time && now()->format('H:i:s') > $session->end_time)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Closed
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Upcoming
                                </span>
                            @endif
                        </div>
                        
                        <div class="text-sm text-gray-500 mb-4">
                            <p class="flex items-center mb-1">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $session->session_date->format('M d, Y') }}
                            </p>
                            <p class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ $session->teacher->name }}
                            </p>
                        </div>

                        @if(!$alreadyMarked)
                            @if($session->is_active)
                                <form action="{{ route('student.attendance.mark', $session) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition">
                                        Mark as Present
                                    </button>
                                </form>
                            @elseif($session->end_time && now()->format('H:i:s') > $session->end_time)
                                <button type="button" disabled class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-500 bg-gray-100 cursor-not-allowed transition">
                                    Session Ended
                                </button>
                            @else
                                <button type="button" disabled class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-500 bg-gray-100 cursor-not-allowed transition">
                                    Starts at {{ $session->start_time ? date('H:i', strtotime($session->start_time)) : 'Manually by Teacher' }}
                                </button>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <p class="text-gray-500">No active attendance sessions right now.</p>
            </div>
        @endif
    </div>

    <!-- Attendance History -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">My Attendance History</h2>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Class</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Session</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($history as $record)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium whitespace-nowrap">
                            {{ $record->session->session_date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $record->session->schoolClass->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $record->session->title }}
                        </td>
                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $record->status === 'Present' ? 'bg-green-100 text-green-800' : 
                                   ($record->status === 'Late' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($record->status === 'Excused' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                {{ $record->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            No attendance history found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
