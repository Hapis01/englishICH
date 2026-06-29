<!-- Edit Class Modal -->
<x-modal name="edit-class" size="sm:max-w-2xl">
    <x-slot name="title">Edit Class</x-slot>
    
    <form id="editClassForm" class="space-y-4">
        <input type="hidden" name="class_id" id="edit_class_id">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Class Name *</label>
                <input type="text" name="name" id="edit_class_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Course *</label>
                <select name="course_id" id="edit_class_course" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
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
                <select name="teacher_id" id="edit_class_teacher" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                    <option value="">Select Teacher</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Schedule *</label>
                <input type="text" name="schedule" id="edit_class_schedule" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Max Students *</label>
                <input type="number" name="max_students" id="edit_class_max" required min="1" max="50" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Students</label>
                <input type="number" name="current_students" id="edit_class_current" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date *</label>
                <input type="date" name="start_date" id="edit_class_start" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">End Date *</label>
                <input type="date" name="end_date" id="edit_class_end" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select name="status" id="edit_class_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="completed">Completed</option>
            </select>
        </div>
    </form>

    <x-slot name="footer">
        <button type="button" @click="$dispatch('close-modal', 'edit-class')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
            Cancel
        </button>
        <button type="button" onclick="submitEditClass()" class="px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition font-medium">
            Update Class
        </button>
    </x-slot>
</x-modal>

<script>
// Load courses and teachers when modal opens
window.addEventListener('open-modal', function(e) {
    if (e.detail === 'edit-class') {
        loadCoursesForEditClass();
        loadTeachersForEditClass();
    }
});

function loadCoursesForEditClass() {
    fetch('/admin/scheduling/courses')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('edit_class_course');
            const currentValue = select.value;
            select.innerHTML = '<option value="">Select Course</option>';
            data.data.forEach(course => {
                const selected = course.id == currentValue ? 'selected' : '';
                select.innerHTML += `<option value="${course.id}" ${selected}>${course.name} - ${course.level} (${course.duration} months)</option>`;
            });
        })
        .catch(error => console.error('Error loading courses:', error));
}

function loadTeachersForEditClass() {
    fetch('/admin/scheduling/teachers')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('edit_class_teacher');
            const currentValue = select.value;
            select.innerHTML = '<option value="">Select Teacher</option>';
            data.data.forEach(teacher => {
                const selected = teacher.id == currentValue ? 'selected' : '';
                select.innerHTML += `<option value="${teacher.id}" ${selected}>${teacher.name} (${teacher.email})</option>`;
            });
        })
        .catch(error => console.error('Error loading teachers:', error));
}

function openEditClass(id, name, courseId, teacherId, schedule, maxStudents, currentStudents, startDate, endDate, status) {
    document.getElementById('edit_class_id').value = id;
    document.getElementById('edit_class_name').value = name;
    document.getElementById('edit_class_course').value = courseId;
    document.getElementById('edit_class_teacher').value = teacherId;
    document.getElementById('edit_class_schedule').value = schedule;
    document.getElementById('edit_class_max').value = maxStudents;
    document.getElementById('edit_class_current').value = currentStudents;
    document.getElementById('edit_class_start').value = startDate;
    document.getElementById('edit_class_end').value = endDate;
    document.getElementById('edit_class_status').value = status;
    
    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'edit-class' }));
}

function submitEditClass() {
    const form = document.getElementById('editClassForm');
    const formData = new FormData(form);
    const classId = document.getElementById('edit_class_id').value;
    
    Swal.fire({
        title: 'Processing...',
        text: 'Updating class',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });
    
    fetch(`/admin/scheduling/${classId}`, {
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
                title: 'Class Updated!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => { window.location.reload(); });
            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'edit-class' }));
        } else {
            Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Failed to update class' });
        }
    })
    .catch(error => {
        Swal.fire({ icon: 'error', title: 'Error', text: 'An error occurred while updating class' });
        console.error('Error:', error);
    });
}
</script>
