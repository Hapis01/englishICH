@extends('layouts.admin')

@section('title', 'Class Scheduling')

@section('page-title', 'Scheduling')

@section('page-subtitle', 'Manage all class schedules and assignments')

@section('content')
    <!-- Page Header with Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <!-- Search Bar -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <input type="text" id="searchInput" name="search" value="{{ request('search') }}" placeholder="Search by class name or teacher..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent" onkeyup="if(event.key === 'Enter') performSearch()">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Filter Buttons -->
            <div class="flex items-center space-x-3">
                <select id="statusFilter" name="status" onchange="performSearch()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
                @if(Auth::user()->role !== 'owner')
                <button 
    onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'add-class' }))"
    class="px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition font-medium">
    Create Class
</button>
                @endif
            </div>
        </div>
    </div>

    <!-- Classes Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Class</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Teacher</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Schedule</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Students</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Duration</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($classes as $class)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-[#0B4637] rounded-lg flex items-center justify-center text-white font-bold text-xs">
                                        {{ substr($class->course->name ?? 'N/A', 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $class->name }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $class->course->name ?? 'N/A' }} - {{ ucfirst($class->course->level ?? 'N/A') }}
                                            <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $class->learning_method === 'online' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                                {{ ucfirst($class->learning_method ?? 'offline') }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    @if($class->teacher)
                                        @if($class->teacher->profile_photo)
                                            <img src="{{ asset($class->teacher->profile_photo) }}" alt="{{ $class->teacher->name }}" class="w-8 h-8 rounded-full object-cover">
                                        @else
                                            <div class="w-8 h-8 bg-[#10B981] rounded-full flex items-center justify-center text-white font-bold text-xs">
                                                {{ substr($class->teacher->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $class->teacher->name }}</p>
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500">No teacher assigned</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-900">{{ $class->schedule }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <div class="flex-1">
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-[#10B981] h-2 rounded-full" style="width: {{ $class->max_students > 0 ? ($class->students->count() / $class->max_students * 100) : 0 }}%"></div>
                                        </div>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900">{{ $class->students->count() }}/{{ $class->max_students }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-900">{{ $class->start_date->format('d M Y') }}</p>
                                <p class="text-xs text-gray-500">to {{ $class->end_date->format('d M Y') }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $class->status === 'active' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $class->status === 'inactive' ? 'bg-gray-100 text-gray-700' : '' }}
                                    {{ $class->status === 'completed' ? 'bg-blue-100 text-blue-700' : '' }}">
                                    {{ ucfirst($class->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <button onclick='openViewStudentsModal(@json($class->students))' class="p-1 text-blue-600 hover:bg-blue-50 rounded transition" title="View Students">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                    </button>
                                    @if(Auth::user()->role !== 'owner')
                                    <button onclick='openEditClass(
    @json($class->id),
    @json($class->course_id),
    @json($class->teacher_id),
    @json($class->name),
    @json($class->schedule),
    @json($class->max_students),
    @json($class->start_date?->format("Y-m-d")),
    @json($class->end_date?->format("Y-m-d")),
    @json($class->status),
    @json($class->learning_method)
)'>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button onclick="openDeleteClass({{ $class->id }}, '{{ $class->name }}')" class="p-1 text-red-600 hover:bg-red-50 rounded transition" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-sm text-gray-500">No classes found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($classes->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $classes->links() }}
            </div>
        @endif
    </div>

    <!-- Add Class Modal -->
    <div x-data="{ open: false }" @open-modal.window="if ($event.detail === 'add-class') open = true" @close-modal.window="if ($event.detail === 'add-class') open = false" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative bg-white rounded-lg shadow-xl max-w-3xl w-full">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Create New Class</h3>
                </div>

                <form id="addClassForm" class="px-6 py-4 space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                            <select name="course_id" id="add_course_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent" onchange="updateClassNames('add')">
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Teacher</label>
                            <select name="teacher_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                                <option value="">Select Teacher</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Class Name</label>
                            <select name="name" id="add_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                                <option value="">Select Course First</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Learning Method</label>
                            <select name="learning_method" id="add_learning_method" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                                <option value="">Select Method</option>
                                <option value="offline">Offline</option>
                                <option value="online">Online</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Class Days</label>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <label class="inline-flex items-center"><input type="checkbox" value="Monday" class="add_day form-checkbox text-[#10B981] rounded border-gray-300" onchange="updateScheduleString('add')"> <span class="ml-2">Monday</span></label>
                                <label class="inline-flex items-center"><input type="checkbox" value="Tuesday" class="add_day form-checkbox text-[#10B981] rounded border-gray-300" onchange="updateScheduleString('add')"> <span class="ml-2">Tuesday</span></label>
                                <label class="inline-flex items-center"><input type="checkbox" value="Wednesday" class="add_day form-checkbox text-[#10B981] rounded border-gray-300" onchange="updateScheduleString('add')"> <span class="ml-2">Wednesday</span></label>
                                <label class="inline-flex items-center"><input type="checkbox" value="Thursday" class="add_day form-checkbox text-[#10B981] rounded border-gray-300" onchange="updateScheduleString('add')"> <span class="ml-2">Thursday</span></label>
                                <label class="inline-flex items-center"><input type="checkbox" value="Friday" class="add_day form-checkbox text-[#10B981] rounded border-gray-300" onchange="updateScheduleString('add')"> <span class="ml-2">Friday</span></label>
                                <label class="inline-flex items-center"><input type="checkbox" value="Saturday" class="add_day form-checkbox text-[#10B981] rounded border-gray-300" onchange="updateScheduleString('add')"> <span class="ml-2">Saturday</span></label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Class Time</label>
                            <select id="add_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent" onchange="updateScheduleString('add')">
                                <option value="">Select Time</option>
                                <option value="09:00-11:00">09:00 - 11:00 (Morning)</option>
                                <option value="14:00-16:00">14:00 - 16:00 (Afternoon)</option>
                            </select>
                            <input type="hidden" name="schedule" id="add_schedule" required>
                            <p class="text-xs text-gray-500 mt-2">Result: <span id="add_schedule_preview" class="font-semibold text-gray-800"></span></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Max Students</label>
                            <input type="number" name="max_students" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent" placeholder="20" min="1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                            <input type="date" name="start_date" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                            <input type="date" name="end_date" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </form>

                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" @click="open = false" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                    <button type="button" onclick="submitClass('add')" class="px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition">Create Class</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Class Modal -->
    <div x-data="{ open: false }" @open-modal.window="if ($event.detail === 'edit-class') open = true" @close-modal.window="if ($event.detail === 'edit-class') open = false" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative bg-white rounded-lg shadow-xl max-w-3xl w-full">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Edit Class</h3>
                </div>

                <form id="editClassForm" class="px-6 py-4 space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="class_id" id="edit_class_id">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                            <select name="course_id" id="edit_course_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent" onchange="updateClassNames('edit')">
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Teacher</label>
                            <select name="teacher_id" id="edit_teacher_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                                <option value="">Select Teacher</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Class Name</label>
                            <select name="name" id="edit_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                                <option value="">Select Course First</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Learning Method</label>
                            <select name="learning_method" id="edit_learning_method" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                                <option value="">Select Method</option>
                                <option value="offline">Offline</option>
                                <option value="online">Online</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Class Days</label>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <label class="inline-flex items-center"><input type="checkbox" value="Monday" class="edit_day form-checkbox text-[#10B981] rounded border-gray-300" onchange="updateScheduleString('edit')"> <span class="ml-2">Monday</span></label>
                                <label class="inline-flex items-center"><input type="checkbox" value="Tuesday" class="edit_day form-checkbox text-[#10B981] rounded border-gray-300" onchange="updateScheduleString('edit')"> <span class="ml-2">Tuesday</span></label>
                                <label class="inline-flex items-center"><input type="checkbox" value="Wednesday" class="edit_day form-checkbox text-[#10B981] rounded border-gray-300" onchange="updateScheduleString('edit')"> <span class="ml-2">Wednesday</span></label>
                                <label class="inline-flex items-center"><input type="checkbox" value="Thursday" class="edit_day form-checkbox text-[#10B981] rounded border-gray-300" onchange="updateScheduleString('edit')"> <span class="ml-2">Thursday</span></label>
                                <label class="inline-flex items-center"><input type="checkbox" value="Friday" class="edit_day form-checkbox text-[#10B981] rounded border-gray-300" onchange="updateScheduleString('edit')"> <span class="ml-2">Friday</span></label>
                                <label class="inline-flex items-center"><input type="checkbox" value="Saturday" class="edit_day form-checkbox text-[#10B981] rounded border-gray-300" onchange="updateScheduleString('edit')"> <span class="ml-2">Saturday</span></label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Class Time</label>
                            <select id="edit_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent" onchange="updateScheduleString('edit')">
                                <option value="">Select Time</option>
                                <option value="09:00-11:00">09:00 - 11:00 (Morning)</option>
                                <option value="14:00-16:00">14:00 - 16:00 (Afternoon)</option>
                            </select>
                            <input type="hidden" name="schedule" id="edit_schedule" required>
                            <p class="text-xs text-gray-500 mt-2">Result: <span id="edit_schedule_preview" class="font-semibold text-gray-800"></span></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Max Students</label>
                            <input type="number" name="max_students" id="edit_max_students" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent" min="1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                            <input type="date" name="start_date" id="edit_start_date" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                            <input type="date" name="end_date" id="edit_end_date" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" id="edit_status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </form>

                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" @click="open = false" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                    <button type="button" onclick="submitClass('edit')" class="px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition">Update Class</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Students Modal -->
    <div x-data="{ open: false, students: [] }" @open-students-modal.window="open = true; students = $event.detail" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" @click.away="open = false" class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Enrolled Students</h3>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="px-6 py-4">
                    <p class="text-sm text-gray-500 mb-4">Total Students: <span x-text="students.length" class="font-bold text-gray-900"></span></p>
                    
                    <ul class="divide-y divide-gray-200 border rounded-lg max-h-96 overflow-y-auto">
                        <template x-for="student in students" :key="student.id">
                            <li class="p-4 flex items-center space-x-3 hover:bg-gray-50">
                                <div class="w-10 h-10 rounded-full bg-[#10B981] flex items-center justify-center text-white font-bold text-sm">
                                    <span x-text="student.name.substring(0,2).toUpperCase()"></span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900" x-text="student.name"></p>
                                    <p class="text-xs text-gray-500" x-text="student.email"></p>
                                </div>
                            </li>
                        </template>
                        <template x-if="students.length === 0">
                            <li class="p-8 text-center text-gray-500 text-sm">No students enrolled in this class yet.</li>
                        </template>
                    </ul>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                    <button type="button" @click="open = false" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function performSearch() {
            const search = document.getElementById('searchInput').value;
            const status = document.getElementById('statusFilter').value;
            
            const params = new URLSearchParams();
            if (search) params.set('search', search);
            if (status) params.set('status', status);
            
            window.location.href = '/admin/scheduling' + (params.toString() ? '?' + params.toString() : '');
        }

        function openViewStudentsModal(students) {
            window.dispatchEvent(
                new CustomEvent('open-students-modal', {
                    detail: students
                })
            );
        }

        function openEditClass(
    id,
    courseId,
    teacherId,
    name,
    schedule,
    maxStudents,
    startDate,
    endDate,
    status,
    learningMethod
) {

    document.getElementById('edit_class_id').value = id;

    document.getElementById('edit_course_id').value = courseId;
    window.currentEditName = name;
    updateClassNames('edit');

    document.getElementById('edit_teacher_id').value = teacherId;

    document.getElementById('edit_schedule').value = schedule;
    
    // Parse the schedule string to populate days and time
    document.querySelectorAll('.edit_day').forEach(cb => cb.checked = false);
    document.getElementById('edit_time').value = '';
    document.getElementById('edit_schedule_preview').innerText = schedule || '';
    
    if (schedule) {
        const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        days.forEach(day => {
            if (schedule.includes(day)) {
                const cb = document.querySelector(`.edit_day[value="${day}"]`);
                if (cb) cb.checked = true;
            }
        });
        
        if (schedule.includes('09:00-11:00')) {
            document.getElementById('edit_time').value = '09:00-11:00';
        } else if (schedule.includes('14:00-16:00')) {
            document.getElementById('edit_time').value = '14:00-16:00';
        }
    }

    document.getElementById('edit_learning_method').value = learningMethod;

    document.getElementById('edit_max_students').value = maxStudents;

    document.getElementById('edit_start_date').value = startDate;

    document.getElementById('edit_end_date').value = endDate;

    document.getElementById('edit_status').value = status;

    window.dispatchEvent(
        new CustomEvent('open-modal', {
            detail: 'edit-class'
        })
    );
}

function updateClassNames(mode) {
    const courseSelect = document.getElementById(mode + '_course_id');
    const nameSelect = document.getElementById(mode + '_name');
    const courseName = courseSelect.options[courseSelect.selectedIndex]?.text || '';
    
    nameSelect.innerHTML = '<option value="">Select Class Name</option>';
    
    if (courseSelect.value) {
        const plans = ['Plan - Morning Class', 'Plan - Afternoon Class'];
        plans.forEach(plan => {
            const optionValue = `${courseName} ${plan}`;
            nameSelect.innerHTML += `<option value="${optionValue}">${optionValue}</option>`;
        });
        
        if (mode === 'edit' && window.currentEditName) {
            let exists = Array.from(nameSelect.options).some(opt => opt.value === window.currentEditName);
            if (!exists) {
                nameSelect.innerHTML += `<option value="${window.currentEditName}">${window.currentEditName}</option>`;
            }
            nameSelect.value = window.currentEditName;
        }
    }
}

function updateScheduleString(mode) {
    const checkboxes = document.querySelectorAll(`.${mode}_day:checked`);
    const days = Array.from(checkboxes).map(cb => cb.value);
    const time = document.getElementById(`${mode}_time`).value;
    
    let scheduleString = '';
    if (days.length > 0) {
        scheduleString += days.join(' & ');
    }
    if (time) {
        scheduleString += (scheduleString ? ' ' : '') + time;
    }
    
    document.getElementById(`${mode}_schedule`).value = scheduleString;
    document.getElementById(`${mode}_schedule_preview`).innerText = scheduleString || '-';
}

        function openDeleteClass(id, name) {
            Swal.fire({
                title: 'Delete Class?',
                html: `Are you sure you want to delete class <strong>${name}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteClass(id);
                }
            });
        }

        function submitClass(mode) {

    const form = mode === 'add'
        ? document.getElementById('addClassForm')
        : document.getElementById('editClassForm');

    const formData = new FormData(form);

    let url = '/admin/scheduling';

    if (mode === 'edit') {

        const id = document.getElementById('edit_class_id').value;

        url = '/admin/scheduling/' + id;

        formData.append('_method', 'PUT');
    }

    Swal.fire({
        title: 'Processing...',
        text: mode === 'add'
            ? 'Creating class'
            : 'Updating class',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(async response => {

        const data = await response.json();

        if (!response.ok) {

            let errorMessage = data.message || 'Validation failed';

            if (data.errors) {

                errorMessage = Object.values(data.errors)
                    .flat()
                    .join('\n');
            }

            throw new Error(errorMessage);
        }

        return data;
    })
    .then(data => {

        Swal.fire({
            icon: 'success',
            title: mode === 'add'
                ? 'Class Created!'
                : 'Class Updated!',
            text: data.message,
            timer: 2000,
            showConfirmButton: false
        });

        setTimeout(() => {
            window.location.reload();
        }, 1500);

    })
    .catch(error => {

        Swal.fire({
            icon: 'error',
            title: 'Validation Failed',
            text: error.message
        });

        console.error(error);

    });
}

        function deleteClass(id) {

    Swal.fire({
        title: 'Delete Class?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete'
    }).then((result) => {

        if (result.isConfirmed) {

            const formData = new FormData();

            formData.append('_method', 'DELETE');

            fetch('/admin/scheduling/' + id, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {

                if (data.success) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                    setTimeout(() => {
                        location.reload();
                    }, 1500);

                }

            });

        }

    });

}
    </script>
@endsection
