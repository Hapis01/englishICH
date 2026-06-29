<!-- Add Payment Modal -->
<x-modal name="add-payment" size="sm:max-w-2xl">
    <x-slot name="title">Record New Payment</x-slot>
    
    <form id="addPaymentForm" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Student *</label>
                <select name="user_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                    <option value="">Select Student</option>
                    <!-- Students will be populated dynamically -->
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Class *</label>
                <select name="class_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                    <option value="">Select Class</option>
                    <!-- Classes will be populated dynamically -->
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Amount (Rp) *</label>
                <input type="number" name="amount" required min="0" step="1000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent" placeholder="e.g., 1500000">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Date *</label>
                <input type="date" name="payment_date" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method *</label>
                <select name="payment_method" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                    <option value="">Select Method</option>
                    <option value="transfer">Bank Transfer</option>
                    <option value="cash">Cash</option>
                    <option value="credit_card">Credit Card</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Status *</label>
                <select name="payment_status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="failed">Failed</option>
                    <option value="refunded">Refunded</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Proof of Payment</label>
            <input type="file" name="proof_of_payment" accept="image/*,.pdf" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
            <p class="text-xs text-gray-500 mt-1">Upload receipt or transfer proof (JPG, PNG, PDF)</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
            <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent" placeholder="Additional notes or remarks..."></textarea>
        </div>
    </form>

    <x-slot name="footer">
        <button type="button" @click="$dispatch('close-modal', 'add-payment')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
            Cancel
        </button>
        <button type="button" onclick="submitAddPayment()" class="px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition font-medium">
            Record Payment
        </button>
    </x-slot>
</x-modal>

<script>
// Load students and classes when modal opens
window.addEventListener('open-modal', function(e) {
    if (e.detail === 'add-payment') {
        loadStudentsForPayment();
        loadClassesForPayment();
    }
});

function loadStudentsForPayment() {
    fetch('/admin/payments/students')
        .then(response => response.json())
        .then(data => {
            const select = document.querySelector('#addPaymentForm select[name="user_id"]');
            select.innerHTML = '<option value="">Select Student</option>';
            data.data.forEach(student => {
                select.innerHTML += `<option value="${student.id}">${student.name} (${student.email})</option>`;
            });
        })
        .catch(error => console.error('Error loading students:', error));
}

function loadClassesForPayment() {
    fetch('/admin/payments/classes')
        .then(response => response.json())
        .then(data => {
            const select = document.querySelector('#addPaymentForm select[name="class_id"]');
            select.innerHTML = '<option value="">Select Class</option>';
            data.data.forEach(cls => {
                select.innerHTML += `<option value="${cls.id}">${cls.name} - ${cls.course.name} (${cls.schedule})</option>`;
            });
        })
        .catch(error => console.error('Error loading classes:', error));
}

function submitAddPayment() {
    const form = document.getElementById('addPaymentForm');
    const formData = new FormData(form);
    
    // Show loading
    Swal.fire({
        title: 'Processing...',
        text: 'Recording payment',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    fetch('/admin/payments', {
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
                title: 'Payment Recorded!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.reload();
            });
            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'add-payment' }));
            form.reset();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Failed to record payment'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while recording payment'
        });
        console.error('Error:', error);
    });
}
</script>
