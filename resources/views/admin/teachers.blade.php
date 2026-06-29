@extends('layouts.admin')

@section('title', 'Teachers Management')

@section('page-title', 'Teachers')

@section('page-subtitle', 'Manage all instructors and teaching staff')

@section('content')
    <!-- Page Header with Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <!-- Search Bar -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <input type="text" id="searchInput" name="search" value="{{ request('search') }}" placeholder="Search by name, email, or phone..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent" onkeyup="if(event.key === 'Enter') performSearch()">
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
                </select>
                @if(Auth::user()->role !== 'owner')
                <button 
    onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'add-teacher' }))"
    class="px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition font-medium">
    Add Teacher
</button>
                @endif
            </div>
        </div>
    </div>

    <!-- Teachers Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Teacher</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Classes</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Students</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Joined Date</th>
                        @if(Auth::user()->role !== 'owner')
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        @else
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Logs</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($teachers as $teacher)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    @if($teacher->profile_photo)
                                        <img src="{{ asset($teacher->profile_photo) }}" alt="{{ $teacher->name }}" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 bg-[#0B4637] rounded-full flex items-center justify-center text-white font-bold text-sm">
                                            {{ substr($teacher->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $teacher->name }}</p>
                                        <p class="text-xs text-gray-500">ID: #{{ str_pad($teacher->id, 4, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-900">{{ $teacher->email }}</p>
                                <p class="text-xs text-gray-500">{{ $teacher->whatsapp ?? $teacher->phone ?? 'N/A' }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-bold text-gray-900">{{ $teacher->taughtClasses->count() }}</p>
                                <p class="text-xs text-gray-500">Active classes</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-bold text-gray-900">{{ $teacher->taughtClasses->sum('current_students') }}</p>
                                <p class="text-xs text-gray-500">Total students</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $teacher->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($teacher->status ?? 'active') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-900">{{ $teacher->created_at->format('d M Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $teacher->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    @if(Auth::user()->role !== 'owner')
                                    <button onclick='openEditTeacher(
    @json($teacher->id),
    @json($teacher->name),
    @json($teacher->email),
    @json($teacher->phone),
    @json($teacher->whatsapp),
    @json($teacher->status ?? "active")
)' class="p-1 text-green-600 hover:bg-green-50 rounded transition" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button onclick="openDeleteTeacher({{ $teacher->id }}, '{{ $teacher->name }}')" class="p-1 text-red-600 hover:bg-red-50 rounded transition" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                    @endif
                                    <button onclick="openUserLogs({{ $teacher->id }}, '{{ $teacher->name }}')" class="p-1 text-blue-600 hover:bg-blue-50 rounded transition" title="Activity Logs">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <p class="text-sm text-gray-500">No teachers found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($teachers->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $teachers->links() }}
            </div>
        @endif
    </div>

    <!-- Add Teacher Modal -->
    <div x-data="{ open: false }" @open-modal.window="if ($event.detail === 'add-teacher') open = true" @close-modal.window="if ($event.detail === 'add-teacher') open = false" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Add New Teacher</h3>
                </div>

                <form id="addTeacherForm" class="px-6 py-4 space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent" placeholder="Enter full name">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent" placeholder="teacher@example.com">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp Number</label>
                            <input type="tel" name="whatsapp" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent" placeholder="+62 812-3456-7890">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <input type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent" placeholder="Minimum 8 characters">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </form>

                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" @click="open = false" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                    <button type="button" onclick="submitTeacher('add')" class="px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition">Add Teacher</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Teacher Modal -->
    <div x-data="{ open: false }" @open-modal.window="if ($event.detail === 'edit-teacher') open = true" @close-modal.window="if ($event.detail === 'edit-teacher') open = false" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Edit Teacher</h3>
                </div>

                <form id="editTeacherForm" class="px-6 py-4 space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="teacher_id" id="edit_teacher_id">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text" name="name" id="edit_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" id="edit_email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp Number</label>
                            <input type="tel" name="whatsapp" id="edit_whatsapp" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password (leave blank to keep current)</label>
                            <input type="password" name="password" id="edit_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent" placeholder="Leave blank to keep current">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" id="edit_status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </form>

                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" @click="open = false" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                    <button type="button" onclick="submitTeacher('edit')" class="px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition">Update Teacher</button>
                </div>
            </div>
        </div>
    </div>

    <!-- User Logs Modal -->
    <div x-data="{ open: false }" @open-modal.window="if ($event.detail === 'user-logs') open = true" @close-modal.window="if ($event.detail === 'user-logs') open = false" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative bg-white rounded-lg shadow-xl max-w-3xl w-full">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Activity Logs: <span id="logsUserName" class="text-[#0B4637]"></span></h3>
                    <button type="button" @click="open = false" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="px-6 py-4 max-h-[60vh] overflow-y-auto">
                    <div id="logsLoading" class="text-center py-4">
                        <svg class="animate-spin h-8 w-8 text-[#10B981] mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    <div id="logsContent" class="hidden">
                        <div class="flow-root">
                            <ul id="logsList" class="-mb-8">
                                <!-- Logs will be injected here -->
                            </ul>
                        </div>
                    </div>
                    <div id="logsEmpty" class="hidden text-center py-8 text-gray-500">
                        No activity logs found for this user.
                    </div>
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
            
            window.location.href = '/admin/teachers' + (params.toString() ? '?' + params.toString() : '');
        }

        function openEditTeacher(
    id,
    name,
    email,
    phone,
    whatsapp,
    status
) {

    document.getElementById('edit_teacher_id').value = id;

    document.getElementById('edit_name').value = name;

    document.getElementById('edit_email').value = email;

    document.getElementById('edit_whatsapp').value = whatsapp || '';

    document.getElementById('edit_status').value = status;

    window.dispatchEvent(
        new CustomEvent('open-modal', {
            detail: 'edit-teacher'
        })
    );
}

        function openDeleteTeacher(id, name) {
            Swal.fire({
                title: 'Delete Teacher?',
                html: `Are you sure you want to delete teacher <strong>${name}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteTeacher(id);
                }
            });
        }

        function submitTeacher(mode) {

    const form = mode === 'add'
        ? document.getElementById('addTeacherForm')
        : document.getElementById('editTeacherForm');

    const formData = new FormData(form);

    let url = '/admin/teachers';

    if (mode === 'edit') {

        const id = document.getElementById('edit_teacher_id').value;

        url = '/admin/teachers/' + id;

        // FIX LARAVEL
        formData.append('_method', 'PUT');
    }

    Swal.fire({
        title: 'Processing...',
        text: mode === 'add'
            ? 'Adding teacher'
            : 'Updating teacher',
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
                ? 'Teacher Added!'
                : 'Teacher Updated!',
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

        function deleteTeacher(id) {

    Swal.fire({
        title: 'Delete Teacher?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete'
    }).then((result) => {

        if (result.isConfirmed) {

            const formData = new FormData();

            formData.append('_method', 'DELETE');

            fetch('/admin/teachers/' + id, {
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
    
    function openUserLogs(id, name) {
        document.getElementById('logsUserName').textContent = name;
        document.getElementById('logsLoading').classList.remove('hidden');
        document.getElementById('logsContent').classList.add('hidden');
        document.getElementById('logsEmpty').classList.add('hidden');
        
        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'user-logs' }));
        
        fetch('/admin/users/' + id + '/logs', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('logsLoading').classList.add('hidden');
            if (data.success && data.logs.length > 0) {
                const logsList = document.getElementById('logsList');
                logsList.innerHTML = '';
                
                data.logs.forEach((log, index) => {
                    const isLast = index === data.logs.length - 1;
                    const li = document.createElement('li');
                    li.innerHTML = `
                        <div class="relative pb-8">
                            ${!isLast ? '<span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>' : ''}
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full bg-[#10B981] flex items-center justify-center ring-8 ring-white">
                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-500">
                                            <span class="font-medium text-gray-900">${log.action}</span> - ${log.description}
                                        </p>
                                    </div>
                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                        <time datetime="${log.created_at}">${log.created_at_human}</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    logsList.appendChild(li);
                });
                document.getElementById('logsContent').classList.remove('hidden');
            } else {
                document.getElementById('logsEmpty').classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Error fetching logs:', error);
            document.getElementById('logsLoading').classList.add('hidden');
            document.getElementById('logsEmpty').classList.remove('hidden');
        });
    }
    </script>
@endsection
