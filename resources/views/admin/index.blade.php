@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('page-title', 'Dashboard')

@section('page-subtitle', 'Welcome back, Admin')

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Students -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Students</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalStudents }}</h3>
                    <p class="text-xs text-green-600 mt-2">Active learners</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Teachers -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Teachers</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalTeachers }}</h3>
                    <p class="text-xs text-green-600 mt-2">Active instructors</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p class="text-xs text-green-600 mt-2">From paid transactions</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Classes -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Active Classes</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $upcomingClasses->count() }}</h3>
                    <p class="text-xs text-green-600 mt-2">Currently running</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Statistics -->
    <div class="mb-8">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Performance Overview</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Overall GPA -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Overall Student GPA</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($overallGpa, 2) }}</h3>
                        <p class="text-xs text-green-600 mt-2">Average score</p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Average Attendance -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Average Attendance</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($avgAttendance, 1) }}%</h3>
                        <p class="text-xs text-green-600 mt-2">Student participation rate</p>
                    </div>
                    <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Total Assessments -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Assessments</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalAssessments }}</h3>
                        <p class="text-xs text-blue-600 mt-2">Created by teachers</p>
                    </div>
                    <div class="w-12 h-12 bg-sky-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Payments & Upcoming Classes -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Payments -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900">Recent Payments</h3>
                    <a href="{{ route('admin.payments') }}" class="text-sm text-[#10B981] hover:text-[#0B4637] font-medium">View All</a>
                </div>
            </div>
            <div class="p-6">
                @if($recentPayments->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentPayments as $payment)
                            <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-[#10B981] rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr($payment->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $payment->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $payment->schoolClass->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-gray-900">Rp {{ number_format(strtolower($payment->payment_type) === 'installment' ? ($payment->installment_paid ?? 0) : $payment->amount, 0, ',', '.') }}</p>
                                    <span class="inline-block px-2 py-1 text-xs font-medium rounded-full
                                        {{ $payment->payment_status === 'paid' && strtolower($payment->payment_type) === 'installment' && $payment->installment_remaining > 0 ? 'bg-blue-100 text-blue-700' : ($payment->payment_status === 'paid' ? 'bg-green-100 text-green-700' : '') }}
                                        {{ $payment->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $payment->payment_status === 'failed' ? 'bg-red-100 text-red-700' : '' }}">
                                        {{ $payment->payment_status === 'paid' && strtolower($payment->payment_type) === 'installment' && $payment->installment_remaining > 0 ? 'Partially Paid' : ucfirst($payment->payment_status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <p class="text-sm text-gray-500">No recent payments</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Upcoming Classes -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900">Upcoming Classes</h3>
                    <a href="{{ route('admin.scheduling') }}" class="text-sm text-[#10B981] hover:text-[#0B4637] font-medium">View All</a>
                </div>
            </div>
            <div class="p-6">
                @if($upcomingClasses->count() > 0)
                    <div class="space-y-4">
                        @foreach($upcomingClasses as $class)
                            <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-[#0B4637] rounded-lg flex items-center justify-center text-white font-bold text-xs">
                                        {{ substr($class->course->name ?? 'N/A', 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $class->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $class->teacher->name ?? 'No teacher' }} • {{ $class->schedule }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">{{ $class->current_students }}/{{ $class->max_students }}</p>
                                    <span class="inline-block px-2 py-1 text-xs font-medium rounded-full
                                        {{ $class->status === 'active' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $class->status === 'inactive' ? 'bg-gray-100 text-gray-700' : '' }}
                                        {{ $class->status === 'completed' ? 'bg-blue-100 text-blue-700' : '' }}">
                                        {{ ucfirst($class->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-sm text-gray-500">No upcoming classes</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Student Status Reports -->
    <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-900">Student Status Breakdown</h3>
            <p class="text-sm text-gray-500">Current enrollment pipeline</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach([
                    'CLASS_NOT_SELECTED' => ['bg-gray-100', 'text-gray-700', 'Class Not Selected'],
                    'AWAITING_PAYMENT' => ['bg-yellow-100', 'text-yellow-700', 'Awaiting Payment'],
                    'PAYMENT_VERIFICATION' => ['bg-blue-100', 'text-blue-700', 'Verifying Payment'],
                    'ACTIVE' => ['bg-green-100', 'text-green-700', 'Active'],
                    'PAYMENT_OVERDUE' => ['bg-red-100', 'text-red-700', 'Payment Overdue'],
                    'SUSPENDED' => ['bg-purple-100', 'text-purple-700', 'Suspended'],
                    'INACTIVE' => ['bg-gray-200', 'text-gray-800', 'Inactive']
                ] as $status => $style)
                    <div class="p-4 rounded-lg border border-gray-100 flex flex-col items-center justify-center bg-gray-50">
                        <span class="inline-block px-3 py-1 text-xs font-medium rounded-full {{ $style[0] }} {{ $style[1] }} mb-2 text-center">
                            {{ $style[2] }}
                        </span>
                        <h4 class="text-2xl font-bold text-gray-900">{{ $studentStatusCounts->get($status, 0) }}</h4>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
