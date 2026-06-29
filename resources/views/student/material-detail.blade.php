@extends('layouts.student')

@section('title', 'Material Detail')
@section('page-title', 'Material Detail')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('student.elearning') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to E-Learning Hub
        </a>
    </div>

    <!-- Material Header -->
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-3">
                    @php
                        $extension = strtolower(pathinfo($material->file_path, PATHINFO_EXTENSION));
                        $iconColor = match($extension) {
                            'pdf' => 'text-red-600',
                            'doc', 'docx' => 'text-blue-600',
                            'ppt', 'pptx' => 'text-orange-600',
                            'xls', 'xlsx' => 'text-green-600',
                            'mp4', 'avi', 'mov' => 'text-purple-600',
                            'mp3', 'wav' => 'text-pink-600',
                            default => 'text-gray-600'
                        };
                    @endphp
                    <svg class="w-12 h-12 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $material->title }}</h1>
                        <p class="text-sm text-gray-600 mt-1">{{ strtoupper($extension) }} File</p>
                    </div>
                </div>

                @if($material->description)
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-700 leading-relaxed">{{ $material->description }}</p>
                    </div>
                @endif
            </div>

            <div class="ml-6">
                <a href="{{ route('student.elearning.download', $material) }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download
                </a>
            </div>
        </div>
    </div>

    <!-- Material Info -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center space-x-3">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Class</p>
                    <p class="font-semibold text-gray-900">{{ $material->schoolClass->name }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center space-x-3">
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Teacher</p>
                    <p class="font-semibold text-gray-900">{{ $material->schoolClass->teacher->name }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center space-x-3">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Uploaded</p>
                    <p class="font-semibold text-gray-900">{{ $material->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Materials -->
    @if($relatedMaterials->isNotEmpty())
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Other Materials in This Class</h2>
            <div class="space-y-3">
                @foreach($relatedMaterials as $related)
                    <a href="{{ route('student.elearning.material', $related) }}" 
                       class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition group">
                        <div class="flex items-center space-x-3">
                            @php
                                $ext = strtolower(pathinfo($related->file_path, PATHINFO_EXTENSION));
                                $color = match($ext) {
                                    'pdf' => 'text-red-600',
                                    'doc', 'docx' => 'text-blue-600',
                                    'ppt', 'pptx' => 'text-orange-600',
                                    default => 'text-gray-600'
                                };
                            @endphp
                            <svg class="w-8 h-8 {{ $color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            <div>
                                <p class="font-medium text-gray-900 group-hover:text-blue-600">{{ $related->title }}</p>
                                <p class="text-sm text-gray-600">{{ $related->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
