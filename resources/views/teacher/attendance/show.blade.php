@extends('layouts.teacher')

@section('title', 'Attendance: ' . $session->title)
@section('page-title', 'Attendance Session')
@section('page-subtitle', $session->schoolClass->name . ' - ' . $session->session_date->format('l, d M Y'))

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('teacher.attendance.index') }}" class="text-emerald-600 hover:text-emerald-700 flex items-center space-x-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Back to Sessions</span>
    </a>
    
    <div class="flex space-x-3">
        <form action="{{ route('teacher.attendance.toggle-open', $session) }}" method="POST">
            @csrf
            <button class="px-4 py-2 rounded-lg font-medium text-white transition {{ $session->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-emerald-500 hover:bg-emerald-600' }}">
                {{ $session->is_active ? 'Close Attendance' : 'Open Attendance' }}
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h4 class="text-sm font-medium text-gray-500 mb-1">Status</h4>
        <div class="flex items-center space-x-2">
            <span class="w-3 h-3 rounded-full {{ $session->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
            <span class="font-bold text-gray-800">{{ $session->is_active ? 'Open for Students' : 'Closed' }}</span>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h4 class="text-sm font-medium text-gray-500 mb-1">Total Students</h4>
        <div class="font-bold text-gray-800 text-2xl">{{ $session->schoolClass->students->count() }}</div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h4 class="text-sm font-medium text-gray-500 mb-1">Marked Present</h4>
        <div class="font-bold text-emerald-600 text-2xl">{{ $attendances->where('status', 'Present')->count() }}</div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <h3 class="font-semibold text-gray-800">Student List</h3>
    </div>
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-3 text-sm font-semibold text-gray-600">Student Name</th>
                <th class="px-6 py-3 text-sm font-semibold text-gray-600">Status</th>
                <th class="px-6 py-3 text-sm font-semibold text-gray-600">Notes</th>
                <th class="px-6 py-3 text-sm font-semibold text-gray-600 text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($session->schoolClass->students as $student)
                @php
                    $attendance = $attendances->get($student->id);
                    $status = $attendance ? $attendance->status : '-'; // Default if not marked
                    $notes = $attendance ? $attendance->notes : '';
                @endphp
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-800">{{ $student->name }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $status === 'Present' ? 'bg-green-100 text-green-800' : 
                           ($status === 'Late' ? 'bg-yellow-100 text-yellow-800' : 
                           ($status === 'Excused' ? 'bg-blue-100 text-blue-800' : 
                           ($status === 'Absent' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))) }}">
                        {{ $status === '-' ? 'Not Marked' : $status }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $notes ?: '-' }}</td>
                <td class="px-6 py-4 text-right">
                    <button onclick="openEditModal({{ $student->id }}, '{{ $student->name }}', '{{ $status }}', '{{ $notes }}')" class="text-emerald-600 hover:text-emerald-800 text-sm font-medium">
                        Edit
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-8 text-center text-gray-500">No students enrolled in this class.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Edit Attendance Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Edit Attendance: <span id="studentName"></span></h3>
        </div>
        <form action="{{ route('teacher.attendance.update-student', $session) }}" method="POST">
            @csrf
            <input type="hidden" name="student_id" id="studentIdInput">
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="statusInput" name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        <option value="" disabled selected>-- Select Status --</option>
                        <option value="Present">Present</option>
                        <option value="Absent">Absent</option>
                        <option value="Late">Late</option>
                        <option value="Excused">Excused</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                    <textarea id="notesInput" name="notes" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent"></textarea>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-[#10B981] text-white rounded-lg hover:bg-[#0B4637] transition">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openEditModal(studentId, studentName, status, notes) {
        document.getElementById('studentIdInput').value = studentId;
        document.getElementById('studentName').innerText = studentName;
        document.getElementById('statusInput').value = status;
        document.getElementById('notesInput').value = notes;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
@endpush
