<!-- Edit Teacher Modal -->
<x-modal name="edit-teacher" size="sm:max-w-2xl">
    <x-slot name="title">Edit Teacher</x-slot>
    
    <form id="editTeacherForm" class="space-y-4">
        <input type="hidden" name="teacher_id" id="edit_teacher_id">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                <input type="text" name="name" id="edit_teacher_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                <input type="email" name="email" id="edit_teacher_email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                <input type="tel" name="phone" id="edit_teacher_phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp Number *</label>
                <input type="tel" name="whatsapp" id="edit_teacher_whatsapp" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select name="status" id="edit_teacher_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">New Password (leave blank to keep current)</label>
            <input type="password" name="password" id="edit_teacher_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
        </div>
    </form>

    <x-slot name="footer">
        <button type="button" @click="$dispatch('close-modal', 'edit-teacher')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
            Cancel
        </button>
        <button type="button" onclick="submitEditTeacher()" class="px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition font-medium">
            Update Teacher
        </button>
    </x-slot>
</x-modal>

<script>
function openEditTeacher(id, name, email, phone, whatsapp, status) {
    document.getElementById('edit_teacher_id').value = id;
    document.getElementById('edit_teacher_name').value = name;
    document.getElementById('edit_teacher_email').value = email;
    document.getElementById('edit_teacher_phone').value = phone || '';
    document.getElementById('edit_teacher_whatsapp').value = whatsapp || '';
    document.getElementById('edit_teacher_status').value = status || 'active';
    
    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'edit-teacher' }));
}

function submitEditTeacher() {
    const form = document.getElementById('editTeacherForm');
    const formData = new FormData(form);
    const teacherId = document.getElementById('edit_teacher_id').value;
    
    Swal.fire({
        title: 'Processing...',
        text: 'Updating teacher',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });
    
    fetch(`/admin/teachers/${teacherId}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            'X-HTTP-Method-Override': 'PUT'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Teacher Updated!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => { window.location.reload(); });
            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'edit-teacher' }));
        } else {
            Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Failed to update teacher' });
        }
    })
    .catch(error => {
        Swal.fire({ icon: 'error', title: 'Error', text: 'An error occurred while updating teacher' });
        console.error('Error:', error);
    });
}
</script>
