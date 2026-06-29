@extends('layouts.student')

@section('title', 'E-Learning Hub')
@section('page-title', 'E-Learning Hub')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Learning Materials</h2>
        <p class="text-gray-600">Access all your course materials and track your progress</p>
    </div>

    @if($enrolledClasses->isEmpty())
        <div class="bg-white rounded-xl shadow p-12 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Classes Yet</h3>
            <p class="text-gray-600">You haven't enrolled in any classes yet.</p>
        </div>
    @else
        @foreach($enrolledClasses as $class)
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <!-- Class Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6 text-white">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold mb-2">{{ $class->name }}</h3>
                            <p class="text-blue-100 mb-3">{{ $class->course->name }}</p>
                            <div class="flex items-center space-x-4 text-sm">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ $class->teacher->name }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $class->schedule }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold">{{ $classProgress[$class->id]['percentage'] }}%</div>
                            <div class="text-sm text-blue-100">Progress</div>
                        </div>
                    </div>
                </div>

                <!-- Materials List -->
                <div class="p-6">
                    @if($class->weeks->isEmpty() && $class->materials->isEmpty())
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-600">No materials available yet</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            <!-- Unassigned Materials -->
                            @if($class->materials->count() > 0)
                                <div>
                                    <h4 class="font-bold text-gray-800 mb-3 text-lg">General Materials</h4>
                                    <div class="space-y-3">
                                        @foreach($class->materials as $material)
                                            @include('student.partials.material_card', ['material' => $material])
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Weekly Materials -->
                            @foreach($class->weeks as $week)
                                <div class="border border-gray-200 rounded-xl overflow-hidden" x-data="{ expanded: {{ $loop->first ? 'true' : 'false' }} }">
                                    <button @click="expanded = !expanded" class="w-full px-6 py-4 bg-gray-50 flex justify-between items-center hover:bg-gray-100 transition focus:outline-none">
                                        <div class="text-left">
                                            <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider">Week {{ $week->week_number }}</span>
                                            <h4 class="font-bold text-gray-900 text-lg">{{ $week->title }}</h4>
                                        </div>
                                        <svg class="w-6 h-6 text-gray-500 transform transition-transform" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    
                                    <div x-show="expanded" x-collapse x-cloak class="border-t border-gray-200 px-6 py-4 bg-white">
                                        @if($week->description)
                                            <p class="text-gray-600 text-sm mb-4">{{ $week->description }}</p>
                                        @endif
                                        
                                        @if($week->materials->count() > 0)
                                            <div class="space-y-3">
                                                @foreach($week->materials as $material)
                                                    @include('student.partials.material_card', ['material' => $material])
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-gray-500 text-sm italic">No materials uploaded for this week yet.</p>
                                        @endif

                                        @if($week->assignments->count() > 0)
                                            <div class="mt-4 pt-4 border-t border-gray-100">
                                                <h6 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Assignments</h6>
                                                <div class="space-y-2">
                                                    @foreach($week->assignments as $assignment)
                                                        <div class="flex justify-between items-center bg-blue-50 p-3 rounded-lg border border-blue-100 hover:shadow-sm transition">
                                                            <div class="flex items-center">
                                                                <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                                <span class="text-sm font-medium text-blue-900">{{ $assignment->title }} (Due: {{ $assignment->due_date->format('M d') }})</span>
                                                            </div>
                                                            <a href="{{ route('student.assignments.show', $assignment) }}" class="text-xs font-semibold text-blue-700 bg-blue-100 hover:bg-blue-200 px-3 py-1 rounded-full transition">View Details</a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
