@extends('layouts.admin')

@section('title', 'Attendance Details - ' . $class->name)
@section('page-title', 'Attendance Details')
@section('page-subtitle', $class->name . ' - ' . ($class->course->name ?? 'N/A'))

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.attendance') }}" class="text-[#0B4637] hover:text-[#10B981] flex items-center space-x-2 font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        <span>Back to Classes</span>
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-sm font-medium text-gray-500 mb-1">Total Students</h3>
        <p class="text-3xl font-bold text-gray-900">{{ $class->students->count() }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-sm font-medium text-gray-500 mb-1">Total Sessions</h3>
        <p class="text-3xl font-bold text-gray-900">{{ $sessions->count() }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-sm font-medium text-gray-500 mb-1">Teacher</h3>
        <p class="text-xl font-bold text-gray-900 mt-2">{{ $class->teacher->name ?? 'N/A' }}</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Attendance Sessions</h3>
    </div>
    <div class="divide-y divide-gray-200">
        @forelse($sessions as $session)
            <div x-data="{ open: false }" class="p-6">
                <div class="flex items-center justify-between cursor-pointer" @click="open = !open">
                    <div>
                        <h4 class="text-md font-semibold text-gray-900">{{ $session->title }}</h4>
                        <p class="text-sm text-gray-500">{{ $session->session_date->format('l, d M Y') }} 
                            @if($session->start_time && $session->end_time)
                                ({{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }})
                            @endif
                        </p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500">{{ $session->attendances->count() }} records</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                
                <div x-show="open" x-collapse class="mt-4 pt-4 border-t border-gray-100" style="display: none;">
                    @if($session->attendances->count() > 0)
                        <table class="w-full text-left text-sm text-gray-600">
                            <thead class="bg-gray-50 text-gray-500 uppercase">
                                <tr>
                                    <th class="px-4 py-2">Student</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Notes</th>
                                    <th class="px-4 py-2">Time</th>
                                    <th class="px-4 py-2 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($session->attendances as $attendance)
                                    <tr>
                                        <td class="px-4 py-2 font-medium text-gray-900">{{ $attendance->student->name ?? 'Unknown Student' }}</td>
                                        <td class="px-4 py-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $attendance->status === 'Present' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $attendance->status === 'Absent' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $attendance->status === 'Late' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $attendance->status === 'Excused' ? 'bg-blue-100 text-blue-800' : '' }}">
                                                {{ $attendance->status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2">{{ $attendance->notes ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $attendance->created_at ? $attendance->created_at->format('H:i') : '-' }}</td>
                                        <td class="px-4 py-2 text-right">
                                            <div class="flex items-center justify-end space-x-2">
                                                <button onclick="openEditModal({{ $attendance->id }}, '{{ $attendance->status }}', '{{ addslashes($attendance->notes) }}')" class="text-blue-600 hover:text-blue-800" title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </button>
                                                <form id="delete-form-{{ $attendance->id }}" action="{{ route('admin.attendance.destroy', $attendance->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete('delete-form-{{ $attendance->id }}')" class="text-red-600 hover:text-red-800" title="Delete">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-sm text-gray-500 text-center py-4">No attendance records for this session.</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="p-6 text-center text-gray-500">
                No attendance sessions found for this class.
            </div>
        @endforelse
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Edit Attendance Record</h3>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="edit_status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981]">
                        <option value="Present">Present</option>
                        <option value="Absent">Absent</option>
                        <option value="Late">Late</option>
                        <option value="Excused">Excused</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" id="edit_notes" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981]" rows="3"></textarea>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-[#10B981] text-white rounded-lg hover:bg-[#0B4637] transition">Update</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openEditModal(id, status, notes) {
        document.getElementById('edit_status').value = status;
        document.getElementById('edit_notes').value = notes;
        document.getElementById('editForm').action = '/admin/attendance/' + id + '/update';
        document.getElementById('editModal').classList.remove('hidden');
    }

    function confirmDelete(formId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This attendance record will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>
@endpush
@endsection
