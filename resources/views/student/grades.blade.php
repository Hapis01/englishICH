@extends('layouts.student')

@section('title', 'All Grades')
@section('page-title', 'All Grades')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">All Grades</h2>
                <p class="text-gray-600">View all your published grades</p>
            </div>
            <div class="text-right">
                <div class="text-3xl font-bold text-gray-900">{{ number_format($grades->avg('average'), 1) }}</div>
                <div class="text-sm text-gray-600">Overall Average</div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow p-6">
        <form method="GET" class="flex items-end space-x-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Class</label>
                <select name="class_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Classes</option>
                    @foreach($enrolledClasses as $class)
                        <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                Apply Filter
            </button>
            @if($classId)
                <a href="{{ route('student.progress.grades') }}" class="px-6 py-2 border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium rounded-lg transition">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Grades Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        @if($grades->isEmpty())
            <div class="p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Grades Yet</h3>
                <p class="text-gray-600">Your grades will appear here once published by your teacher.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left py-4 px-6 text-sm font-semibold text-gray-700">Class</th>
                            <th class="text-center py-4 px-4 text-sm font-semibold text-gray-700">Listening</th>
                            <th class="text-center py-4 px-4 text-sm font-semibold text-gray-700">Speaking</th>
                            <th class="text-center py-4 px-4 text-sm font-semibold text-gray-700">Reading</th>
                            <th class="text-center py-4 px-4 text-sm font-semibold text-gray-700">Writing</th>
                            <th class="text-center py-4 px-4 text-sm font-semibold text-gray-700">Grammar</th>
                            <th class="text-center py-4 px-4 text-sm font-semibold text-gray-700">Attendance</th>
                            <th class="text-center py-4 px-4 text-sm font-semibold text-gray-700">Average</th>
                            <th class="text-left py-4 px-6 text-sm font-semibold text-gray-700">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($grades as $grade)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $grade->schoolClass->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $grade->schoolClass->course->name }}</p>
                                        <p class="text-xs text-gray-500 mt-1">Teacher: {{ $grade->teacher->name }}</p>
                                    </div>
                                </td>
                                <td class="text-center py-4 px-4">
                                    <span class="font-semibold text-gray-900">{{ $grade->listening ?? '-' }}</span>
                                </td>
                                <td class="text-center py-4 px-4">
                                    <span class="font-semibold text-gray-900">{{ $grade->speaking ?? '-' }}</span>
                                </td>
                                <td class="text-center py-4 px-4">
                                    <span class="font-semibold text-gray-900">{{ $grade->reading ?? '-' }}</span>
                                </td>
                                <td class="text-center py-4 px-4">
                                    <span class="font-semibold text-gray-900">{{ $grade->writing ?? '-' }}</span>
                                </td>
                                <td class="text-center py-4 px-4">
                                    <span class="font-semibold text-gray-900">{{ $grade->grammar ?? '-' }}</span>
                                </td>
                                <td class="text-center py-4 px-4">
                                    <span class="font-semibold text-gray-900">{{ $grade->attendance ?? '-' }}</span>
                                </td>
                                <td class="text-center py-4 px-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                                        @if($grade->average >= 80) bg-green-100 text-green-800
                                        @elseif($grade->average >= 60) bg-blue-100 text-blue-800
                                        @elseif($grade->average >= 40) bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ number_format($grade->average, 1) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-sm text-gray-900">{{ $grade->grade_date ? $grade->grade_date->format('M d, Y') : '-' }}</p>
                                    @if($grade->notes)
                                        <p class="text-xs text-gray-600 mt-1" title="{{ $grade->notes }}">
                                            {{ Str::limit($grade->notes, 50) }}
                                        </p>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
