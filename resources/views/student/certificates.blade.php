@extends('layouts.student')

@section('title', 'Certificates')
@section('page-title', 'My Certificates')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-xl shadow-lg p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">Your Certificates</h2>
                <p class="text-purple-100">Download and share your achievements</p>
            </div>
            <div class="text-center">
                <div class="text-5xl font-bold mb-2">{{ $certificates->count() }}</div>
                <div class="text-purple-100">Total Certificates</div>
            </div>
        </div>
    </div>

    @if($certificates->isEmpty())
        <div class="bg-white rounded-xl shadow p-12 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Certificates Yet</h3>
            <p class="text-gray-600">Complete your courses to earn certificates!</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($certificates as $certificate)
                <div class="bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition">
                    <!-- Certificate Preview -->
                    <div class="bg-gradient-to-br from-purple-50 to-blue-50 p-8 text-center border-b-4 border-purple-600">
                        <div class="w-20 h-20 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Certificate of Completion</h3>
                        <p class="text-sm text-gray-600">{{ $certificate->schoolClass->course->name }}</p>
                    </div>

                    <!-- Certificate Details -->
                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Certificate Number</p>
                            <p class="font-mono text-sm font-semibold text-gray-900">{{ $certificate->certificate_number }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 mb-1">Class</p>
                            <p class="text-sm font-medium text-gray-900">{{ $certificate->schoolClass->name }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Final Score</p>
                                <p class="text-2xl font-bold text-purple-600">{{ number_format($certificate->final_score, 1) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Grade</p>
                                <p class="text-2xl font-bold text-purple-600">{{ $certificate->letter_grade }}</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 mb-1">Issue Date</p>
                            <p class="text-sm text-gray-900">{{ $certificate->issue_date->format('F d, Y') }}</p>
                        </div>

                        <!-- Actions -->
                        <div class="pt-4 border-t space-y-2">
                            <a href="{{ route('student.certificates.show', $certificate) }}" 
                               class="block w-full text-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition">
                                View Certificate
                            </a>
                            <a href="{{ route('student.certificates.download', $certificate) }}" 
                               class="block w-full text-center px-4 py-2 border border-purple-600 text-purple-600 hover:bg-purple-50 font-medium rounded-lg transition">
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Download PDF
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
