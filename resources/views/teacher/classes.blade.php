@extends('layouts.teacher')

@section('title', 'Classes & Materials')
@section('page-title', 'Classes & Materials')
@section('page-subtitle', 'Manage your classes and upload materials')

@section('content')
<div class="space-y-6">
    @foreach($classes as $class)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Class Header -->
        <div class="px-6 py-4 bg-gradient-to-r from-[#0B4637] to-[#10B981] text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold">{{ $class->name }}</h3>
                    <p class="text-emerald-100 text-sm mt-1">{{ $class->course->name }}</p>
                </div>
                <div class="flex flex-col items-end justify-between">
                    <div class="text-right">
                        <p class="text-sm text-emerald-100">{{ $class->schedule }}</p>
                        <p class="text-xs text-emerald-200 mt-1">{{ $class->students->count() }} / {{ $class->max_students }} students</p>
                    </div>
                    <a href="{{ route('teacher.classes.show', $class) }}" class="mt-3 inline-flex items-center px-3 py-1.5 border border-white/30 rounded-lg text-sm font-medium text-white hover:bg-white/10 transition-colors">
                        View Analytics & Overview
                        <svg class="ml-1.5 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Class Info -->
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Start Date</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $class->start_date->format('M d, Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Status</p>
                        <p class="text-sm font-semibold text-green-600">{{ ucfirst($class->status) }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Materials</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $class->materials->count() }} files</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Materials & Weeks Section -->
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-semibold text-gray-800">Weekly Learning Modules</h4>
                <div class="flex space-x-2">
                    <button onclick="openWeekModal({{ $class->id }})" class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center space-x-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span>Add Week</span>
                    </button>
                    <button onclick="openUploadModal({{ $class->id }})" class="px-3 py-2 bg-[#10B981] text-white rounded-lg hover:bg-[#0B4637] transition flex items-center space-x-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        <span>Upload Material</span>
                    </button>
                </div>
            </div>

            <div class="space-y-4">
                @if($class->materials->whereNull('week_id')->count() > 0)
                    <!-- Unassigned Materials -->
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <h5 class="font-semibold text-gray-700 mb-3 text-sm uppercase tracking-wider">Unassigned Materials</h5>
                        <div class="space-y-2">
                            @foreach($class->materials->whereNull('week_id') as $material)
                                @include('teacher.partials.material_item', ['material' => $material])
                            @endforeach
                        </div>
                    </div>
                @endif

                @forelse($class->weeks as $week)
                    <div class="border border-gray-200 rounded-xl overflow-hidden bg-white">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                            <div>
                                <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider">Week {{ $week->week_number }}</span>
                                <h4 class="font-bold text-gray-900">{{ $week->title }}</h4>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button onclick="openUploadModal({{ $class->id }}, {{ $week->id }})" class="text-xs px-2 py-1 bg-emerald-100 text-emerald-700 rounded hover:bg-emerald-200">Add Material</button>
                                <a href="{{ route('teacher.assessments.create', ['class_id' => $class->id, 'week_id' => $week->id]) }}" class="text-xs px-2 py-1 bg-purple-100 text-purple-700 rounded hover:bg-purple-200">Add Assessment</a>
                                <form action="{{ route('teacher.weeks.destroy', $week) }}" method="POST" onsubmit="return confirm('Delete this week? This will NOT delete the materials, they will just become unassigned.');">
                                    @csrf @method('DELETE')
                                    <button class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200">Delete</button>
                                </form>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($week->description)
                                <p class="text-gray-600 text-sm mb-4">{{ $week->description }}</p>
                            @endif
                            
                            @if($week->materials->count() > 0)
                                <div class="space-y-2">
                                    @foreach($week->materials as $material)
                                        @include('teacher.partials.material_item', ['material' => $material])
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-sm italic">No materials assigned to this week.</p>
                            @endif

                            @if($week->assignments->count() > 0)
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <h6 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Assignments</h6>
                                    <div class="space-y-2">
                                        @foreach($week->assignments as $assignment)
                                            <div class="flex justify-between items-center bg-purple-50 p-3 rounded-lg border border-purple-100">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                    <span class="text-sm font-medium text-purple-900">{{ $assignment->title }}</span>
                                                </div>
                                                <a href="{{ route('teacher.assessments.edit', $assignment) }}" class="text-xs text-purple-600 hover:text-purple-800">Edit</a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                        <p class="text-gray-500 mb-2">No weekly modules created yet.</p>
                        <button onclick="openWeekModal({{ $class->id }})" class="text-blue-600 font-medium hover:underline text-sm">Create First Week</button>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    @endforeach

    @if($classes->count() == 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
        <svg class="w-20 h-20 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
        </svg>
        <h3 class="text-xl font-semibold text-gray-800 mt-4">No Classes Assigned</h3>
        <p class="text-gray-500 mt-2">You don't have any classes assigned yet. Please contact the administrator.</p>
    </div>
    @endif
</div>

<!-- Add Week Modal -->
<div id="weekModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Add Learning Week</h3>
        </div>
        <form action="{{ route('teacher.weeks.store') }}" method="POST">
            @csrf
            <input type="hidden" name="class_id" id="week_class_id">
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Week Number</label>
                    <input type="number" name="week_number" min="1" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" name="title" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g. Introduction to Variables">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="closeWeekModal()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Save Week</button>
            </div>
        </form>
    </div>
</div>

<!-- Upload Material Modal -->
<div id="uploadModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Upload Material</h3>
        </div>
        <form action="{{ route('teacher.materials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="class_id" id="upload_class_id">
            <input type="hidden" name="week_id" id="upload_week_id">
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" name="title" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">File</label>
                    <input type="file" name="file" required accept=".pdf,.doc,.docx,.ppt,.pptx,.zip,.jpg,.jpeg,.png" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#10B981] file:text-white hover:file:bg-[#0B4637]">
                    <p class="text-xs text-gray-500 mt-2">Supported: PDF, DOC, PPT, ZIP, Images (Max 10MB)</p>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="closeUploadModal()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-[#10B981] text-white rounded-lg hover:bg-[#0B4637] transition">
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openWeekModal(classId) {
        document.getElementById('week_class_id').value = classId;
        document.getElementById('weekModal').classList.remove('hidden');
    }

    function closeWeekModal() {
        document.getElementById('weekModal').classList.add('hidden');
    }

    function openUploadModal(classId, weekId = '') {
        document.getElementById('upload_class_id').value = classId;
        document.getElementById('upload_week_id').value = weekId;
        document.getElementById('uploadModal').classList.remove('hidden');
    }

    function closeUploadModal() {
        document.getElementById('uploadModal').classList.add('hidden');
    }

    function deleteMaterial(materialId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This material will be permanently deleted",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/teacher/materials/${materialId}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // Close modals on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeUploadModal();
            closeWeekModal();
        }
    });
</script>
@endpush
