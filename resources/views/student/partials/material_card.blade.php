<div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 hover:shadow-md transition bg-white">
    <div class="flex items-start justify-between">
        <div class="flex items-start space-x-4 flex-1">
            <!-- File Icon -->
            <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0
                @if($material->file_type === 'pdf') bg-red-100
                @elseif(in_array($material->file_type, ['doc', 'docx'])) bg-blue-100
                @elseif(in_array($material->file_type, ['ppt', 'pptx'])) bg-orange-100
                @else bg-gray-100
                @endif">
                <svg class="w-6 h-6 
                    @if($material->file_type === 'pdf') text-red-600
                    @elseif(in_array($material->file_type, ['doc', 'docx'])) text-blue-600
                    @elseif(in_array($material->file_type, ['ppt', 'pptx'])) text-orange-600
                    @else text-gray-600
                    @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>

            <!-- Material Info -->
            <div class="flex-1 min-w-0">
                <h4 class="font-semibold text-gray-900 mb-1">{{ $material->title }}</h4>
                @if($material->description)
                    <p class="text-sm text-gray-600 mb-2">{{ Str::limit($material->description, 100) }}</p>
                @endif
                <div class="flex items-center space-x-4 text-xs text-gray-500">
                    <span class="flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $material->uploaded_at->format('M d, Y') }}
                    </span>
                    <span class="flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        {{ $material->file_size_human }}
                    </span>
                    <span class="uppercase">{{ $material->file_type }}</span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center space-x-2 ml-4">
            <a href="{{ route('student.elearning.material', $material) }}" 
               class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition"
               title="View Details">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </a>
            <a href="{{ route('student.elearning.download', $material) }}" 
               class="p-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition"
               title="Download">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
            </a>
        </div>
    </div>
</div>
