<div class="flex items-center justify-between p-3 bg-white border border-gray-100 rounded-lg hover:border-blue-200 hover:shadow-sm transition">
    <div class="flex items-center space-x-3 flex-1 min-w-0">
        <div class="w-10 h-10 rounded-lg flex items-center justify-center font-bold flex-shrink-0 text-xs
            @if($material->file_type === 'pdf') bg-red-100 text-red-700
            @elseif(in_array($material->file_type, ['doc', 'docx'])) bg-blue-100 text-blue-700
            @elseif(in_array($material->file_type, ['ppt', 'pptx'])) bg-orange-100 text-orange-700
            @else bg-emerald-100 text-emerald-700
            @endif">
            {{ strtoupper(substr($material->file_type, 0, 3)) }}
        </div>
        <div class="flex-1 min-w-0">
            <h5 class="text-sm font-semibold text-gray-800 truncate">{{ $material->title }}</h5>
            <p class="text-xs text-gray-500 mt-0.5">{{ $material->file_size_human }} • Uploaded {{ $material->created_at->diffForHumans() }}</p>
        </div>
    </div>
    <div class="flex items-center space-x-1 ml-4">
        <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded transition" title="View File">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
        </a>
        <button onclick="deleteMaterial({{ $material->id }})" class="p-1.5 text-red-600 hover:bg-red-50 rounded transition" title="Delete Material">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </button>
    </div>
</div>
