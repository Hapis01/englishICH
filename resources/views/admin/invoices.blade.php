@extends('layouts.admin')

@section('title', 'Invoice Management')

@section('page-title', 'Invoice Management')

@section('page-subtitle', 'Create invoices and verify student payments')

@section('content')
    <!-- Tabs Navigation -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="flex flex-wrap border-b border-gray-200">
            <button onclick="switchTab('create-invoice')" class="tab-btn active px-6 py-4 text-sm font-medium text-gray-900 border-b-2 border-[#10B981]">
                Create Invoice
            </button>
            <button onclick="switchTab('pending-verification')" class="tab-btn px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">
                Pending Verification
            </button>
        </div>
    </div>

    <!-- Create Invoice Tab -->
    <div id="create-invoice-tab" class="tab-content block">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Create New Invoice</h3>
                    
                    <form id="createInvoiceForm" class="space-y-4">
                        @csrf
                        
                        <!-- Student Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Student *</label>
                            <select name="user_id" id="studentSelect" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                                <option value="">-- Choose a student --</option>
                            </select>
                        </div>

                        <!-- Invoice Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Invoice Title *</label>
                            <input type="text" name="title" required placeholder="e.g., Class Fee Payment" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="3" placeholder="Add payment description..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent"></textarea>
                        </div>

                        <!-- Payment Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Type</label>
                            <select name="payment_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                                <option value="">-- Select Payment Type (Optional) --</option>
                                <option value="Kursus Basic">Kursus Basic</option>
                                <option value="Kursus Premium">Kursus Premium</option>
                                <option value="Kursus VIP">Kursus VIP</option>
                                <option value="Private Class">Private Class</option>
                                <option value="TOEFL Program">TOEFL Program</option>
                                <option value="IELTS Program">IELTS Program</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- Payment Notes -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Notes</label>
                            <textarea name="payment_notes" rows="2" placeholder="e.g., Pembayaran Cicilan 1, Pelunasan Program Premium..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent"></textarea>
                        </div>

                        <!-- Amount & Due Date -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Amount (Rp) *</label>
                                <input type="number" name="amount" required min="0" placeholder="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Due Date *</label>
                                <input type="date" name="due_date" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" class="w-full px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition font-medium">
                                Create Invoice
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- QRIS Preview -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h4 class="text-sm font-bold text-gray-900 mb-4">QRIS Preview</h4>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex items-center justify-center">
                        @if(file_exists(public_path('images/qris.jpg')))
                            <img src="{{ asset('images/qris.jpg') }}" alt="QRIS" class="w-full object-cover rounded">
                        @elseif(file_exists(storage_path('app/public/qris.jpg')))
                            <img src="{{ asset('storage/qris.jpg') }}" alt="QRIS" class="w-full object-cover rounded">
                        @else
                            <div class="w-full aspect-square bg-gray-200 rounded flex items-center justify-center text-gray-500 text-center">
                                <div>
                                    <p class="text-sm">No QRIS image found</p>
                                    <p class="text-xs mt-2">Place qris.jpg in:</p>
                                    <p class="text-xs">public/images/qris.jpg</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 mt-3 text-center">
                        QRIS will be displayed to students when they receive invoices
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Verification Tab -->
    <div id="pending-verification-tab" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Student</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Invoice</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Uploaded</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="pendingVerificationList" class="divide-y divide-gray-200">
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                Loading pending verifications...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Verification Modal -->
    <div id="verificationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Verify Payment Proof</h3>
                <button onclick="closeVerificationModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div id="verificationContent" class="space-y-4">
                <!-- Student Info -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Student: <span id="verifyStudentName" class="font-bold text-gray-900"></span></p>
                    <p class="text-sm text-gray-600">Invoice: <span id="verifyInvoiceTitle" class="font-bold text-gray-900"></span></p>
                    <p class="text-sm text-gray-600">Amount: <span id="verifyAmount" class="font-bold text-gray-900"></span></p>
                    <p class="text-sm text-gray-600" id="verifyTypeContainer" style="display:none;">Type: <span id="verifyPaymentType" class="font-bold text-gray-900"></span></p>
                    <p class="text-sm text-gray-600" id="verifyNotesContainer" style="display:none;">Notes: <span id="verifyPaymentNotes" class="font-bold text-gray-900"></span></p>
                </div>

                <!-- Proof Preview -->
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-2">Payment Proof:</p>
                    <div id="proofPreview" class="bg-gray-100 rounded-lg overflow-hidden max-h-96">
                        <!-- Will be populated dynamically -->
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-4">
                    <button onclick="approvePayment()" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                        Approve
                    </button>
                    <button onclick="rejectPayment()" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                        Reject
                    </button>
                </div>
            </div>

            <input type="hidden" id="verifyPaymentId">
        </div>
    </div>

    <script>
        let currentPaymentId = null;

        // Load students on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadStudents();
            loadPendingVerifications();
        });

        async function loadStudents() {
            try {
                const response = await fetch('/admin/payments/students');
                const data = await response.json();
                
                const select = document.getElementById('studentSelect');
                select.innerHTML = '<option value="">-- Choose a student --</option>';
                
                data.data.forEach(student => {
                    const option = document.createElement('option');
                    option.value = student.id;
                    option.textContent = `${student.name} (${student.email})`;
                    select.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading students:', error);
            }
        }

        async function loadPendingVerifications() {
            try {
                const response = await fetch('/admin/payments/pending/verification');
                const data = await response.json();
                
                const tbody = document.getElementById('pendingVerificationList');
                
                if (!data.data || data.data.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                No pending verifications
                            </td>
                        </tr>
                    `;
                    return;
                }

                tbody.innerHTML = data.data.map(payment => `
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-[#10B981] rounded-full flex items-center justify-center text-white font-bold text-sm">
                                    ${payment.user.name.charAt(0)}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">${payment.user.name}</p>
                                    <p class="text-xs text-gray-500">${payment.user.email}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-900">${payment.title || 'Payment Invoice'}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm font-bold text-gray-900">Rp ${new Intl.NumberFormat('id-ID').format(payment.amount)}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm text-gray-600">${new Date(payment.created_at).toLocaleDateString('id-ID')}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button onclick="openVerificationModal(${payment.id}, '${payment.user.name}', '${payment.title || 'Payment'}', ${payment.amount}, '${payment.proof_of_payment}', '${payment.payment_type || ''}', '${payment.payment_notes || ''}')"
                                class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition text-sm font-medium">
                                Review
                            </button>
                        </td>
                    </tr>
                `).join('');
            } catch (error) {
                console.error('Error loading pending verifications:', error);
            }
        }

        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active', 'border-[#10B981]', 'text-gray-900');
                btn.classList.add('border-transparent', 'text-gray-500');
            });

            // Show selected tab
            document.getElementById(tabName + '-tab').classList.remove('hidden');
            
            // Highlight tab button
            event.target.classList.add('active', 'border-[#10B981]', 'text-gray-900');
            event.target.classList.remove('border-transparent', 'text-gray-500');

            if (tabName === 'pending-verification') {
                loadPendingVerifications();
            }
        }

        function openVerificationModal(paymentId, studentName, invoiceTitle, amount, proofPath, paymentType, paymentNotes) {
            currentPaymentId = paymentId;
            
            document.getElementById('verifyPaymentId').value = paymentId;
            document.getElementById('verifyStudentName').textContent = studentName;
            document.getElementById('verifyInvoiceTitle').textContent = invoiceTitle;
            document.getElementById('verifyAmount').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
            
            // Show payment type if available
            if (paymentType) {
                document.getElementById('verifyTypeContainer').style.display = 'block';
                document.getElementById('verifyPaymentType').textContent = paymentType;
            } else {
                document.getElementById('verifyTypeContainer').style.display = 'none';
            }
            
            // Show payment notes if available
            if (paymentNotes) {
                document.getElementById('verifyNotesContainer').style.display = 'block';
                document.getElementById('verifyPaymentNotes').textContent = paymentNotes;
            } else {
                document.getElementById('verifyNotesContainer').style.display = 'none';
            }
            
            // Preview proof
            const proofPreview = document.getElementById('proofPreview');
            const safeProofPath = proofPath || '';
            const fullPath = safeProofPath.startsWith('images/') ? '/' + safeProofPath : '/storage/' + safeProofPath;
            
            if (!safeProofPath) {
                proofPreview.innerHTML = '<div class="p-6 text-center text-sm text-gray-500">No proof uploaded</div>';
                return;
            }

            if (safeProofPath.endsWith('.pdf')) {
                proofPreview.innerHTML = `
                    <embed src="${fullPath}" type="application/pdf" width="100%" height="400px">
                `;
            } else {
                proofPreview.innerHTML = `
                    <img src="${fullPath}" alt="Payment Proof" class="w-full h-auto">
                `;
            }
            
            document.getElementById('verificationModal').classList.remove('hidden');
        }

        function closeVerificationModal() {
            document.getElementById('verificationModal').classList.add('hidden');
            currentPaymentId = null;
        }

        async function approvePayment() {
            if (!currentPaymentId) return;
            
            try {
                const response = await fetch(`/admin/payments/${currentPaymentId}/verify`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ status: 'approved' })
                });

                const data = await response.json();

                if (data.success) {
                    alert('Payment approved successfully!');
                    closeVerificationModal();
                    loadPendingVerifications();
                } else {
                    alert('Error: ' + (data.error || 'Failed to approve payment'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            }
        }

        async function rejectPayment() {
            if (!currentPaymentId) return;
            
            const reason = prompt('Reason for rejection (optional):');
            if (reason === null) return;
            
            try {
                const response = await fetch(`/admin/payments/${currentPaymentId}/verify`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ 
                        status: 'rejected',
                        notes: reason
                    })
                });

                const data = await response.json();

                if (data.success) {
                    alert('Payment rejected. Student can upload proof again.');
                    closeVerificationModal();
                    loadPendingVerifications();
                } else {
                    alert('Error: ' + (data.error || 'Failed to reject payment'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            }
        }

        // Form submission
        document.getElementById('createInvoiceForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = {
                user_id: this.user_id.value,
                title: this.title.value,
                description: this.description.value,
                payment_type: this.payment_type.value,
                payment_notes: this.payment_notes.value,
                amount: this.amount.value,
                due_date: this.due_date.value
            };

            try {
                const response = await fetch('/admin/payments/invoice/create', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (data.success) {
                    alert('Invoice created successfully!');
                    this.reset();
                } else {
                    alert('Error: ' + (data.errors?.user_id?.[0] || data.error || 'Failed to create invoice'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            }
        });
    </script>
@endsection
