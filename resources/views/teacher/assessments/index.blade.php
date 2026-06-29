@extends('layouts.teacher')

@section('title', 'assessments Management')
@section('page-title', 'assessments')
@section('page-subtitle', 'Manage assessments and submissions')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h3 class="text-xl font-bold text-gray-800">Your assessments</h3>
    <a href="{{ route('teacher.assessments.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
        Create New assessment
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-3 text-sm font-semibold text-gray-600">Title</th>
                <th class="px-6 py-3 text-sm font-semibold text-gray-600">Class & Week</th>
                <th class="px-6 py-3 text-sm font-semibold text-gray-600">Due Date</th>
                <th class="px-6 py-3 text-sm font-semibold text-gray-600">Status</th>
                <th class="px-6 py-3 text-sm font-semibold text-gray-600 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($assessments as $assessment)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="font-semibold text-gray-800">{{ $assessment->title }}</div>
                    <div class="text-xs text-gray-500">{{ $assessment->scores->count() }} Submissions</div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">
                    {{ $assessment->schoolClass->name }}<br>
                    <span class="text-xs text-emerald-600">{{ $assessment->type }}</span>
                </td>
                <td class="px-6 py-4">
                    @if($assessment->due_date)
                    <div class="text-sm font-medium {{ $assessment->is_overdue ? 'text-red-600' : 'text-gray-800' }}">
                        {{ $assessment->due_date->format('M d, Y') }}
                    </div>
                    <div class="text-xs text-gray-500">{{ $assessment->due_time ? date('H:i', strtotime($assessment->due_time)) : '23:59' }}</div>
                    @else
                    <span class="text-gray-400 italic">No Due Date</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if($assessment->is_open)
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Forced Open</span>
                    @elseif($assessment->is_active)
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Open (Active)</span>
                    @elseif($assessment->is_upcoming)
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Upcoming</span>
                    @elseif(!$assessment->is_published)
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Closed</span>
                    @else
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Overdue</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right space-x-2">
                    <form action="{{ route('teacher.assessments.toggle-status', $assessment) }}" method="POST" class="inline-block">
                        @csrf
                        @if($assessment->is_published)
                            <button type="submit" class="px-3 py-1 bg-red-50 text-red-600 rounded text-xs hover:bg-red-100 font-medium">Close</button>
                        @else
                            <button type="submit" class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded text-xs hover:bg-emerald-100 font-medium">Open</button>
                        @endif
                    </form>
                    @if($assessment->is_published)
                        <form action="{{ route('teacher.assessments.toggle_open', $assessment) }}" method="POST" class="inline-block">
                            @csrf
                            @if($assessment->is_open)
                                <button type="submit" class="px-3 py-1 bg-gray-100 text-gray-700 rounded text-xs hover:bg-gray-200 font-medium">Remove Override</button>
                            @else
                                <button type="submit" class="px-3 py-1 bg-blue-50 text-blue-600 rounded text-xs hover:bg-blue-100 font-medium">Force Open</button>
                            @endif
                        </form>
                    @endif
                    <a href="{{ route('teacher.assessments.submissions', $assessment) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium ml-2">Submissions</a>
                    <a href="{{ route('teacher.assessments.edit', $assessment) }}" class="text-emerald-600 hover:text-emerald-800 text-sm font-medium ml-2">Edit</a>
                    <form action="{{ route('teacher.assessments.destroy', $assessment) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Delete this assessment?');">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:text-red-800 text-sm font-medium">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-500">No assessments created yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
