@extends('layouts.admin')

@section('title', 'Reports Generation')
@section('page-title', 'Reports')
@section('page-subtitle', 'Generate and download comprehensive PDF reports')

@section('content')
<div class="space-y-8">
    <!-- System-wide Reports -->
    <div>
        <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">System-wide Reports</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Financial Income Report -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col h-full">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Financial Income</h3>
                </div>
                <p class="text-sm text-gray-500 mb-6 flex-1">Overview of income from student registration fees, broken down by month, year, full payments, and installments.</p>
                
                <form action="{{ route('admin.reports.generate') }}" method="POST" target="_blank">
                    @csrf
                    <input type="hidden" name="report_type" value="financial_income">
                    <div class="mb-4">
                        <select name="period" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent text-sm">
                            <option value="all_time">All Time</option>
                            <option value="this_month">This Month</option>
                            <option value="last_month">Last Month</option>
                            <option value="this_year">This Year</option>
                            <option value="last_year">Last Year</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        <span>Generate PDF</span>
                    </button>
                </form>
            </div>


            <!-- Population Demographics Report -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col h-full">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-rose-100 text-rose-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Population Demographics</h3>
                </div>
                <p class="text-sm text-gray-500 mb-6 flex-1">Analytics on the total number of teachers and students, including active vs inactive status and class level distribution.</p>
                
                <form action="{{ route('admin.reports.generate') }}" method="POST" target="_blank">
                    @csrf
                    <input type="hidden" name="report_type" value="population_demographics">
                    <button type="submit" class="w-full px-4 py-2 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition font-medium flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        <span>Generate PDF</span>
                    </button>
                </form>
            </div>

            <!-- Teacher Attendance Report -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col h-full">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-teal-100 text-teal-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Teacher Attendance</h3>
                </div>
                <p class="text-sm text-gray-500 mb-6 flex-1">Export teacher attendance records in PDF or Excel format.</p>
                
                <form action="{{ route('admin.reports.generate') }}" method="POST" target="_blank">
                    @csrf
                    <input type="hidden" name="report_type" value="teacher_attendance">
                    <div class="space-y-3 mb-4">
                        <select name="period" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent text-sm">
                            <option value="">All Time</option>
                            <option value="today">Today</option>
                            <option value="this_week">This Week</option>
                            <option value="this_month">This Month</option>
                        </select>
                        <select name="format" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent text-sm">
                            <option value="pdf">PDF Format</option>
                            <option value="excel">Excel (CSV) Format</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition font-medium flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        <span>Generate Report</span>
                    </button>
                </form>
            </div>
            
    </div>

    <!-- Class-specific Reports -->
    <div>
        <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Class-specific Reports</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Student Attendance Report -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col h-full">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Student Attendance</h3>
                </div>
                <p class="text-sm text-gray-500 mb-6 flex-1">Detailed attendance records and rates for all students in a specific class.</p>
                
                <form action="{{ route('admin.reports.generate') }}" method="POST" target="_blank" class="mt-auto">
                    @csrf
                    <input type="hidden" name="report_type" value="attendance_record">
                    <div class="mb-4">
                        <select name="class_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                            <option value="">Select Class...</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition font-medium flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        <span>Generate PDF</span>
                    </button>
                </form>
            </div>

            <!-- Class Roster / Student Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col h-full">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Class Roster</h3>
                </div>
                <p class="text-sm text-gray-500 mb-6 flex-1">Generate a simple list of all enrolled students and their contact details for a class.</p>
                
                <form action="{{ route('admin.reports.generate') }}" method="POST" target="_blank" class="mt-auto">
                    @csrf
                    <input type="hidden" name="report_type" value="student_summary">
                    <div class="mb-4">
                        <select name="class_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                            <option value="">Select Class...</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition font-medium flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        <span>Generate PDF</span>
                    </button>
                </form>
            </div>

            <!-- Individual Report Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col h-full" x-data="reportCardData()">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Individual Report Card</h3>
                </div>
                <p class="text-sm text-gray-500 mb-6 flex-1">Generate a detailed report card showing final grades and teacher notes for a specific student.</p>
                
                <form action="{{ route('admin.reports.generate') }}" method="POST" target="_blank" class="mt-auto">
                    @csrf
                    <input type="hidden" name="report_type" value="report_card">
                    <div class="space-y-3 mb-4">
                        <select name="class_id" x-model="selectedClass" @change="fetchStudents()" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent text-sm">
                            <option value="">Select Class...</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                        
                        <select name="student_id" required :disabled="!selectedClass || loading" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent disabled:bg-gray-100 text-sm">
                            <option value="">Select Student...</option>
                            <template x-for="student in students" :key="student.id">
                                <option :value="student.id" x-text="student.name"></option>
                            </template>
                        </select>
                    </div>
                    <button type="submit" :disabled="!selectedClass" class="w-full px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition font-medium flex items-center justify-center space-x-2 disabled:opacity-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        <span>Generate PDF</span>
                    </button>
                </form>
            </div>
            
        </div>
    </div>
</div>

<script>
    function reportCardData() {
        return {
            selectedClass: '',
            students: [],
            loading: false,
            fetchStudents() {
                if(!this.selectedClass) {
                    this.students = [];
                    return;
                }
                this.loading = true;
                fetch(`/admin/payments/students?class_id=${this.selectedClass}`)
                    .then(res => res.json())
                    .then(data => {
                        this.students = data.data;
                        this.loading = false;
                    })
                    .catch(err => {
                        console.error(err);
                        this.loading = false;
                    });
            }
        }
    }
</script>
@endsection
