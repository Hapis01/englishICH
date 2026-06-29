<!-- Add Teacher Modal -->
<x-modal name="add-teacher" size="sm:max-w-2xl">
    <x-slot name="title">Add New Teacher</x-slot>
    
    <form id="addTeacherForm" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                <input type="tel" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp Number *</label>
                <input type="tel" name="whatsapp" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
            <input type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
    </form>

    <x-slot name="footer">
        <button type="button" @click="$dispatch('close-modal', 'add-teacher')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
            Cancel
        </button>
        <button type="button" onclick="submitAddTeacher()" class="px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition font-medium">
            Add Teacher
        </button>
    </x-slot>
</x-modal>

<script>
function submitAddTeacher() {
    const form = document.getElementById('addTeacherForm');
    const formData = new FormData(form);
    
    Swal.fire({
        title: 'Processing...',
        text: 'Adding new teacher',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });
    
    fetch('/admin/teachers', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Teacher Added!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => { window.location.reload(); });
            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'add-teacher' }));
            form.reset();
        } else {
            Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Failed to add teacher' });
        }
    })
    .catch(error => {
        Swal.fire({ icon: 'error', title: 'Error', text: 'An error occurred while adding teacher' });
        console.error('Error:', error);
    });
}
</script>
