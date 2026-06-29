<!-- Edit Payment Modal -->
<x-modal name="edit-payment" size="sm:max-w-2xl">
    <x-slot name="title">Edit Payment</x-slot>
    
    <form id="editPaymentForm" class="space-y-4">
        <input type="hidden" name="payment_id" id="edit_payment_id">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Student *</label>
                <select name="user_id" id="edit_payment_user" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                    <option value="">Select Student</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Class *</label>
                <select name="class_id" id="edit_payment_class" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                    <option value="">Select Class</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Amount (Rp) *</label>
                <input type="number" name="amount" id="edit_payment_amount" required min="0" step="1000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Date *</label>
                <input type="date" name="payment_date" id="edit_payment_date" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method *</label>
                <select name="payment_method" id="edit_payment_method" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                    <option value="transfer">Bank Transfer</option>
                    <option value="cash">Cash</option>
                    <option value="credit_card">Credit Card</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Status *</label>
                <select name="payment_status" id="edit_payment_status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="failed">Failed</option>
                    <option value="refunded">Refunded</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Update Proof of Payment</label>
            <input type="file" name="proof_of_payment" accept="image/*,.pdf" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            <p class="text-xs text-gray-500 mt-1">Upload new receipt or leave blank to keep existing</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
            <textarea name="notes" id="edit_payment_notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent"></textarea>
        </div>
    </form>

    <x-slot name="footer">
        <button type="button" @click="$dispatch('close-modal', 'edit-payment')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
            Cancel
        </button>
        <button type="button" onclick="submitEditPayment()" class="px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition font-medium">
            Update Payment
        </button>
    </x-slot>
</x-modal>

<script>
// Load students and classes when modal opens
window.addEventListener('open-modal', function(e) {
    if (e.detail === 'edit-payment') {
        loadStudentsForEditPayment();
        loadClassesForEditPayment();
    }
});

function loadStudentsForEditPayment() {
    fetch('/admin/payments/students')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('edit_payment_user');
            const currentValue = select.value;
            select.innerHTML = '<option value="">Select Student</option>';
            data.data.forEach(student => {
                const selected = student.id == currentValue ? 'selected' : '';
                select.innerHTML += `<option value="${student.id}" ${selected}>${student.name} (${student.email})</option>`;
            });
        })
        .catch(error => console.error('Error loading students:', error));
}

function loadClassesForEditPayment() {
    fetch('/admin/payments/classes')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('edit_payment_class');
            const currentValue = select.value;
            select.innerHTML = '<option value="">Select Class</option>';
            data.data.forEach(cls => {
                const selected = cls.id == currentValue ? 'selected' : '';
                select.innerHTML += `<option value="${cls.id}" ${selected}>${cls.name} - ${cls.course.name} (${cls.schedule})</option>`;
            });
        })
        .catch(error => console.error('Error loading classes:', error));
}

function openEditPayment(id, userId, classId, amount, paymentDate, paymentMethod, paymentStatus, notes) {
    document.getElementById('edit_payment_id').value = id;
    document.getElementById('edit_payment_user').value = userId;
    document.getElementById('edit_payment_class').value = classId;
    document.getElementById('edit_payment_amount').value = amount;
    document.getElementById('edit_payment_date').value = paymentDate;
    document.getElementById('edit_payment_method').value = paymentMethod;
    document.getElementById('edit_payment_status').value = paymentStatus;
    document.getElementById('edit_payment_notes').value = notes || '';
    
    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'edit-payment' }));
}

function submitEditPayment() {
    const form = document.getElementById('editPaymentForm');
    const formData = new FormData(form);
    const paymentId = document.getElementById('edit_payment_id').value;
    
    // Show loading
    Swal.fire({
        title: 'Processing...',
        text: 'Updating payment',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    fetch(`/admin/payments/${paymentId}`, {
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
                title: 'Payment Updated!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.reload();
            });
            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'edit-payment' }));
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Failed to update payment'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while updating payment'
        });
        console.error('Error:', error);
    });
}
</script>
    
    window.dispatchEvent(new CustomEvent('close-modal', { detail: 'edit-payment' }));
}
</script>
