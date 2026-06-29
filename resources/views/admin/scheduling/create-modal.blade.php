<!-- Add Class Modal -->
<x-modal name="add-class" size="sm:max-w-2xl">
    <x-slot name="title">Create New Class</x-slot>
    
    <form id="addClassForm" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Class Name *</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent" placeholder="e.g., Morning Basic English A">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Course *</label>
                <select name="course_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                    <option value="">Select Course</option>
                    <option value="1">Basic English</option>
                    <option value="2">Intermediate English</option>
                    <option value="3">Advanced English</option>
                    <option value="4">Business English</option>
                    <option value="5">IELTS Preparation</option>
                    <option value="6">TOEFL Preparation</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Teacher *</label>
                <select name="teacher_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                    <option value="">Select Teacher</option>
                    <!-- Teachers will be populated dynamically -->
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Schedule *</label>
                <input type="text" name="schedule" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent" placeholder="e.g., Mon & Wed, 09:00-11:00">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Max Students *</label>
                <input type="number" name="max_students" required value="20" min="1" max="50" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Students</label>
                <input type="number" name="current_students" value="0" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date *</label>
                <input type="date" name="start_date" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">End Date *</label>
                <input type="date" name="end_date" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="completed">Completed</option>
            </select>
        </div>
    </form>

    <x-slot name="footer">
        <button type="button" @click="$dispatch('close-modal', 'add-class')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
            Cancel
        </button>
        <button type="button" onclick="submitAddClass()" class="px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition font-medium">
            Create Class
        </button>
    </x-slot>
</x-modal>

<script>
// Load courses and teachers when modal opens
window.addEventListener('open-modal', function(e) {
    if (e.detail === 'add-class') {
        loadCoursesForClass();
        loadTeachersForClass();
    }
});

function loadCoursesForClass() {
    fetch('/admin/scheduling/courses')
        .then(response => response.json())
        .then(data => {
            const select = document.querySelector('#addClassForm select[name="course_id"]');
            select.innerHTML = '<option value="">Select Course</option>';
            data.data.forEach(course => {
                select.innerHTML += `<option value="${course.id}">${course.name} - ${course.level} (${course.duration} months)</option>`;
            });
        })
        .catch(error => console.error('Error loading courses:', error));
}

function loadTeachersForClass() {
    fetch('/admin/scheduling/teachers')
        .then(response => response.json())
        .then(data => {
            const select = document.querySelector('#addClassForm select[name="teacher_id"]');
            select.innerHTML = '<option value="">Select Teacher</option>';
            data.data.forEach(teacher => {
                select.innerHTML += `<option value="${teacher.id}">${teacher.name} (${teacher.email})</option>`;
            });
        })
        .catch(error => console.error('Error loading teachers:', error));
}

function submitAddClass() {
    const form = document.getElementById('addClassForm');
    const formData = new FormData(form);
    
    Swal.fire({
        title: 'Processing...',
        text: 'Creating new class',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });
    
    fetch('/admin/scheduling', {
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
                title: 'Class Created!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => { window.location.reload(); });
            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'add-class' }));
            form.reset();
        } else {
            Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Failed to create class' });
        }
    })
    .catch(error => {
        Swal.fire({ icon: 'error', title: 'Error', text: 'An error occurred while creating class' });
        console.error('Error:', error);
    });
}
</script>
