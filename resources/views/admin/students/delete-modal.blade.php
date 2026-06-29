<!-- Delete Student Modal -->
<x-modal name="delete-student" size="sm:max-w-md">
    <x-slot name="title">Delete Student</x-slot>
    
    <div class="text-center py-4">
        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Are you sure?</h3>
        <p class="text-sm text-gray-500 mb-4">
            Do you really want to delete <span id="delete_student_name" class="font-semibold text-gray-900"></span>? 
            This action cannot be undone.
        </p>
        <input type="hidden" id="delete_student_id">
    </div>

    <x-slot name="footer">
        <button type="button" @click="$dispatch('close-modal', 'delete-student')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
            Cancel
        </button>
        <button type="button" onclick="submitDeleteStudent()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
            Delete Student
        </button>
    </x-slot>
</x-modal>

<script>
function openDeleteStudent(id, name) {
    document.getElementById('delete_student_id').value = id;
    document.getElementById('delete_student_name').textContent = name;
    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'delete-student' }));
}

function submitDeleteStudent() {
    const id = document.getElementById('delete_student_id').value;
    
    Swal.fire({
        title: 'Deleting...',
        text: 'Removing student record',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });
    
    fetch(`/admin/students/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Student Deleted!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => { window.location.reload(); });
            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'delete-student' }));
        } else {
            Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Failed to delete student' });
        }
    })
    .catch(error => {
        Swal.fire({ icon: 'error', title: 'Error', text: 'An error occurred while deleting student' });
        console.error('Error:', error);
    });
}
</script>
