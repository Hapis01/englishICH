@extends('layouts.student')

@section('title', 'Progress & Grades')
@section('page-title', 'My Progress')

@push('styles')
<style>
    canvas {
        max-height: 400px;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Header with GPA -->
    <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-xl shadow-lg p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">Your Academic Progress</h2>
                <p class="text-green-100">Track your learning journey and achievements</p>
            </div>
            <div class="text-center">
                <div class="text-5xl font-bold mb-2">{{ number_format($gpa, 1) }}</div>
                <div class="text-green-100">Average Score</div>
            </div>
        </div>
    </div>

    <!-- Skill Progress Chart -->
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Skills Breakdown</h3>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Radar Chart -->
            <div>
                <canvas id="skillRadarChart"></canvas>
            </div>

            <!-- Skill Bars -->
            <div class="space-y-4">
                @foreach(['listening' => 'Listening', 'speaking' => 'Speaking', 'reading' => 'Reading', 'writing' => 'Writing', 'grammar' => 'Grammar', 'attendance' => 'Attendance'] as $key => $label)
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $skillProgress[$key] }}/100</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="h-3 rounded-full transition-all duration-300 
                                @if($skillProgress[$key] >= 80) bg-green-600
                                @elseif($skillProgress[$key] >= 60) bg-blue-600
                                @elseif($skillProgress[$key] >= 40) bg-yellow-600
                                @else bg-red-600
                                @endif" 
                                style="width: {{ $skillProgress[$key] }}%">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Score History Chart -->
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Score History</h3>
        <canvas id="scoreHistoryChart"></canvas>
    </div>

    <!-- Recent Grades -->
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Recent Grades</h3>
            <a href="{{ route('student.progress.grades') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                View All →
            </a>
        </div>

        @if($grades->isEmpty())
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Grades Yet</h3>
                <p class="text-gray-600">Your grades will appear here once published by your teacher.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Class</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Listening</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Speaking</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Reading</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Writing</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Grammar</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Average</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grades->take(5) as $grade)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-4 px-4">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $grade->schoolClass->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $grade->teacher->name }}</p>
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
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                                        @if($grade->average >= 80) bg-green-100 text-green-800
                                        @elseif($grade->average >= 60) bg-blue-100 text-blue-800
                                        @elseif($grade->average >= 40) bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ number_format($grade->average, 1) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-600">
                                    {{ $grade->grade_date ? $grade->grade_date->format('M d, Y') : '-' }}
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

@push('scripts')
<script>
    // Skill Radar Chart
    const radarCtx = document.getElementById('skillRadarChart').getContext('2d');
    new Chart(radarCtx, {
        type: 'radar',
        data: {
            labels: ['Listening', 'Speaking', 'Reading', 'Writing', 'Grammar', 'Attendance'],
            datasets: [{
                label: 'Your Skills',
                data: [
                    {{ $skillProgress['listening'] }},
                    {{ $skillProgress['speaking'] }},
                    {{ $skillProgress['reading'] }},
                    {{ $skillProgress['writing'] }},
                    {{ $skillProgress['grammar'] }},
                    {{ $skillProgress['attendance'] }}
                ],
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 2,
                pointBackgroundColor: 'rgb(59, 130, 246)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(59, 130, 246)'
            }]
        },
        options: {
            scales: {
                r: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        stepSize: 20
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Score History Line Chart
    const historyCtx = document.getElementById('scoreHistoryChart').getContext('2d');
    new Chart(historyCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($scoreHistory->pluck('date')) !!},
            datasets: [{
                label: 'Average Score',
                data: {!! json_encode($scoreHistory->pluck('average')) !!},
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        stepSize: 20
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        afterLabel: function(context) {
                            const index = context.dataIndex;
                            const classes = {!! json_encode($scoreHistory->pluck('class')) !!};
                            return 'Class: ' + classes[index];
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
