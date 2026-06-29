@extends('layouts.admin')

@section('title', 'Package Management')

@section('page-title', 'Packages & Pricing')

@section('page-subtitle', 'Manage course packages, pricing, and features displayed on the landing page')

@section('content')
    <!-- Page Header with Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <!-- Search Bar -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <input type="text" id="searchInput" name="search" value="{{ request('search') }}" placeholder="Search packages..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent" onkeyup="if(event.key === 'Enter') performSearch()">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Filter Buttons -->
            <div class="flex items-center space-x-3">
                <select id="statusFilter" name="status" onchange="performSearch()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @if(Auth::user()->role !== 'owner')
                <button onclick="openCourseModal('add')" class="px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Package
                </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Courses Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Package Name</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Level & Duration</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        @if(Auth::user()->role !== 'owner')
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($courses as $course)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 {{ $course->is_featured ? 'bg-yellow-100 text-yellow-600' : 'bg-green-100 text-[#10B981]' }} rounded-lg flex items-center justify-center font-bold">
                                        {{ substr($course->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                            {{ $course->name }}
                                            @if($course->is_featured)
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-yellow-100 text-yellow-800">Featured</span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500">{{ $course->subtitle ?? 'No subtitle' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-bold text-gray-900">Rp {{ number_format($course->price, 0, ',', '.') }}</p>
                                @if($course->original_price)
                                <p class="text-xs text-gray-500 line-through">Rp {{ number_format($course->original_price, 0, ',', '.') }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-900 capitalize">{{ $course->level }}</p>
                                <p class="text-xs text-gray-500">{{ $course->duration }} Months</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $course->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $course->status === 'active' ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            @if(Auth::user()->role !== 'owner')
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <button onclick='openCourseModal("edit", @json($course))' class="p-1 text-green-600 hover:bg-green-50 rounded transition" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button onclick='deleteCourse({{ $course->id }}, @json($course->name))' class="p-1 text-red-600 hover:bg-red-50 rounded transition" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <p class="text-sm text-gray-500">No course packages found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($courses->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $courses->links() }}
            </div>
        @endif
    </div>

    <!-- Add Course Modal -->
    <div x-data="{ open: false }" @open-modal.window="if ($event.detail === 'add-course') open = true" @close-modal.window="if ($event.detail === 'add-course') open = false" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="open = false"></div>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl w-full">
                
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Add Course Package</h3>
                </div>

                <form id="addCourseForm" class="px-6 py-4 max-h-[70vh] overflow-y-auto space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Package Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required placeholder="Example: Basic" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Subtitle (Motto)</label>
                            <input type="text" name="subtitle" placeholder="Example: Perfect for beginners" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Suitable For</label>
                            <input type="text" name="suitable_for" placeholder="Example: Beginners & Casual Learners" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Short Description <span class="text-red-500">*</span></label>
                            <textarea name="description" required rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Level <span class="text-red-500">*</span></label>
                            <select name="level" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                                <option value="basic">Basic</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="advanced">Advanced</option>
                                <option value="business">Business English</option>
                                <option value="ielts">IELTS Preparation</option>
                                <option value="toefl">TOEFL Preparation</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Duration (Months) <span class="text-red-500">*</span></label>
                            <input type="number" name="duration" required min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Price (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="price" required min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Original Price / Strikethrough (Rp)</label>
                            <input type="number" name="original_price" min="0" placeholder="Leave blank if no discount" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                            <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center">
                        <input type="checkbox" name="is_featured" id="add_course_featured" value="1" class="w-4 h-4 text-[#10B981] bg-gray-100 border-gray-300 rounded focus:ring-[#10B981]">
                        <label for="add_course_featured" class="ml-2 text-sm font-medium text-gray-700">Highlight this package (Featured)</label>
                    </div>

                    <div class="border-t border-gray-200 pt-4 mt-6">
                        <div class="flex justify-between items-center mb-4">
                            <label class="block text-sm font-medium text-gray-700">Package Features / Benefits</label>
                            <button type="button" onclick="addFeatureInput('addFeaturesList')" class="text-sm text-[#10B981] hover:text-[#0B4637] font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Add Feature
                            </button>
                        </div>
                        <div id="addFeaturesList" class="space-y-3">
                            <div class="flex items-center gap-2">
                                <input type="text" name="features[]" placeholder="Example: 12 Live Sessions" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                                <button type="button" onclick="this.parentElement.remove()" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3 bg-gray-50">
                    <button type="button" @click="open = false" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                    <button type="button" onclick="submitCourseForm('add')" class="px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition">Add Package</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Course Modal -->
    <div x-data="{ open: false }" @open-modal.window="if ($event.detail === 'edit-course') open = true" @close-modal.window="if ($event.detail === 'edit-course') open = false" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="open = false"></div>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl w-full">
                
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Edit Course Package</h3>
                </div>

                <form id="editCourseForm" class="px-6 py-4 max-h-[70vh] overflow-y-auto space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_course_id">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Package Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="edit_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Subtitle (Motto)</label>
                            <input type="text" name="subtitle" id="edit_subtitle" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Suitable For</label>
                            <input type="text" name="suitable_for" id="edit_suitable_for" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Short Description <span class="text-red-500">*</span></label>
                            <textarea name="description" id="edit_description" required rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Level <span class="text-red-500">*</span></label>
                            <select name="level" id="edit_level" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                                <option value="basic">Basic</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="advanced">Advanced</option>
                                <option value="business">Business English</option>
                                <option value="ielts">IELTS Preparation</option>
                                <option value="toefl">TOEFL Preparation</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Duration (Months) <span class="text-red-500">*</span></label>
                            <input type="number" name="duration" id="edit_duration" required min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Price (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="price" id="edit_price" required min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Original Price / Strikethrough (Rp)</label>
                            <input type="number" name="original_price" id="edit_original_price" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                            <select name="status" id="edit_status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center">
                        <input type="checkbox" name="is_featured" id="edit_featured" value="1" class="w-4 h-4 text-[#10B981] bg-gray-100 border-gray-300 rounded focus:ring-[#10B981]">
                        <label for="edit_featured" class="ml-2 text-sm font-medium text-gray-700">Highlight this package (Featured)</label>
                    </div>

                    <div class="border-t border-gray-200 pt-4 mt-6">
                        <div class="flex justify-between items-center mb-4">
                            <label class="block text-sm font-medium text-gray-700">Package Features / Benefits</label>
                            <button type="button" onclick="addFeatureInput('editFeaturesList')" class="text-sm text-[#10B981] hover:text-[#0B4637] font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Add Feature
                            </button>
                        </div>
                        <div id="editFeaturesList" class="space-y-3">
                            <!-- Populated dynamically -->
                        </div>
                    </div>
                </form>

                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3 bg-gray-50">
                    <button type="button" @click="open = false" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                    <button type="button" onclick="submitCourseForm('edit')" class="px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition">Save Changes</button>
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
            window.location.href = "{{ route('admin.courses.index') }}" + (params.toString() ? '?' + params.toString() : '');
        }

        function createFeatureInput(val = '') {
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2';
            
            // Escape double quotes to prevent breaking value attribute
            const escapedVal = val.replace(/"/g, '&quot;');
            
            div.innerHTML = `
                <input type="text" name="features[]" value="${escapedVal}" placeholder="Example: 12 Live Sessions" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                <button type="button" onclick="this.parentElement.remove()" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            `;
            return div;
        }

        function addFeatureInput(listId, val = '') {
            document.getElementById(listId).appendChild(createFeatureInput(val));
        }

        function openCourseModal(mode, course = null) {
            if (mode === 'add') {
                document.getElementById('addCourseForm').reset();
                // Clear existing inputs in list
                document.getElementById('addFeaturesList').innerHTML = `
                    <div class="flex items-center gap-2">
                        <input type="text" name="features[]" placeholder="Example: 12 Live Sessions" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        <button type="button" onclick="this.parentElement.remove()" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                `;
                window.dispatchEvent(new CustomEvent('open-modal', { detail: 'add-course' }));
            } else if (mode === 'edit') {
                document.getElementById('edit_course_id').value = course.id;
                document.getElementById('edit_name').value = course.name;
                document.getElementById('edit_subtitle').value = course.subtitle || '';
                document.getElementById('edit_suitable_for').value = course.suitable_for || '';
                document.getElementById('edit_description').value = course.description;
                document.getElementById('edit_level').value = course.level;
                document.getElementById('edit_duration').value = course.duration;
                document.getElementById('edit_price').value = Math.floor(course.price);
                document.getElementById('edit_original_price').value = course.original_price ? Math.floor(course.original_price) : '';
                document.getElementById('edit_status').value = course.status;
                document.getElementById('edit_featured').checked = course.is_featured ? true : false;
                
                // Load features
                const featuresList = document.getElementById('editFeaturesList');
                featuresList.innerHTML = '';
                if (course.features && course.features.length > 0) {
                    course.features.forEach(feat => {
                        addFeatureInput('editFeaturesList', feat);
                    });
                } else {
                    addFeatureInput('editFeaturesList');
                }
                window.dispatchEvent(new CustomEvent('open-modal', { detail: 'edit-course' }));
            }
        }

        function submitCourseForm(mode) {
            const form = mode === 'add' ? document.getElementById('addCourseForm') : document.getElementById('editCourseForm');
            const formData = new FormData(form);
            
            let url = "{{ route('admin.courses.store') }}";
            if (mode === 'edit') {
                const id = document.getElementById('edit_course_id').value;
                url = `/admin/courses/${id}`;
            }

            Swal.fire({
                title: 'Processing...',
                text: mode === 'add' ? 'Adding course package' : 'Updating course package',
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
                        errorMessage = Object.values(data.errors).flat().join('\n');
                    }
                    throw new Error(errorMessage);
                }
                return data;
            })
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: mode === 'add' ? 'Package Added!' : 'Package Updated!',
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
            });
        }

        function deleteCourse(id, name) {
            Swal.fire({
                title: 'Delete Package?',
                html: `Are you sure you want to delete package <strong>${name}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('_method', 'DELETE');

                    fetch(`/admin/courses/${id}`, {
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
                            throw new Error(data.message || 'Failed to delete package');
                        }
                        return data;
                    })
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Deletion Failed',
                            text: error.message
                        });
                    });
                }
            });
        }
    </script>
@endsection
