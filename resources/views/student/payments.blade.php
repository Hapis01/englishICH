@extends('layouts.student')

@section('title', 'My Payments')

@section('page-title', 'Payments')

@section('page-subtitle', 'View and manage your payment invoices')

@section('content')
    <!-- Payments List -->
    <div class="grid grid-cols-1 gap-6">
        @forelse($payments as $payment)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between p-6 gap-6">
                    <!-- Left: Payment Details -->
                    <div class="flex-1">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $payment->title ?? 'Payment Invoice' }}</h3>
                                <p class="text-sm text-gray-500 mt-1">Invoice #{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                {{ $payment->payment_status === 'paid' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $payment->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $payment->payment_status === 'failed' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $payment->payment_status === 'refunded' ? 'bg-blue-100 text-blue-700' : '' }}">
                                {{ ucfirst($payment->payment_status) }}
                            </span>
                        </div>

                        @if($payment->description)
                            <p class="text-sm text-gray-600 mb-3">{{ $payment->description }}</p>
                        @endif

                        @if($payment->payment_type)
                            <p class="text-sm text-gray-600 mb-2"><strong>Type:</strong> {{ ucfirst($payment->payment_type) }}</p>
                        @endif

                        @if($payment->payment_notes)
                            <p class="text-sm text-gray-600 mb-3"><strong>Notes:</strong> {{ $payment->payment_notes }}</p>
                        @endif

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mt-4">
                            <div>
                                <p class="text-gray-500 font-medium">Total Harga Kelas</p>
                                <p class="text-gray-900 font-bold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                            </div>
                            
                            @if(strtolower($payment->payment_type) === 'installment')
                                @php
                                    $paidCount = $payment->installments->where('status', 'paid')->count();
                                    $totalCount = $payment->installments->count();
                                    $paidAmount = $payment->installment_paid ?? 0;
                                    $totalAmount = $payment->installment_total ?? $payment->amount;
                                    $remainingAmount = $payment->installment_remaining ?? ($totalAmount - $paidAmount);
                                @endphp
                                <div>
                                    <p class="text-gray-500 font-medium">Progress Cicilan</p>
                                    <p class="text-gray-900 font-bold">{{ $paidCount }}/{{ $totalCount }} Cicilan</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 font-medium">Total Sudah Dibayar</p>
                                    <p class="text-green-600 font-bold">Rp {{ number_format($paidAmount, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 font-medium">Sisa Pembayaran</p>
                                    <p class="text-red-600 font-bold">Rp {{ number_format($remainingAmount, 0, ',', '.') }}</p>
                                </div>
                                
                                {{-- Progress Bar --}}
                                <div class="col-span-2 md:col-span-4 mt-2">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-emerald-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ $totalCount > 0 ? ($paidCount / $totalCount * 100) : 0 }}%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">{{ $paidCount }}/{{ $totalCount }} cicilan terbayar &bull; Rp {{ number_format($paidAmount, 0, ',', '.') }} / Rp {{ number_format($totalAmount, 0, ',', '.') }}</p>
                                </div>

                                @php
                                    $nextInstallment = $payment->installments
                                        ->where('status', '!=', 'paid')
                                        ->where('verification_status', '!=', 'pending_verification')
                                        ->sortBy('installment_number')
                                        ->first();
                                @endphp
                                <div>
                                    <p class="text-gray-500 font-medium">Cicilan Berikutnya</p>
                                    <p class="text-gray-900">{{ $nextInstallment ? 'Ke-' . $nextInstallment->installment_number : ($paidCount >= $totalCount ? 'Lunas ✅' : '-') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 font-medium">Due Date Berikutnya</p>
                                    <p class="text-gray-900">{{ $nextInstallment ? \Carbon\Carbon::parse($nextInstallment->due_date)->format('d M Y') : '-' }}</p>
                                </div>
                            @else
                                <div>
                                    <p class="text-gray-500 font-medium">Due Date</p>
                                    <p class="text-gray-900">{{ $payment->due_date ? \Carbon\Carbon::parse($payment->due_date)->format('d M Y') : '-' }}</p>
                                </div>
                            @endif

                            <div>
                                <p class="text-gray-500 font-medium">Verification</p>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                    {{ $payment->verification_status === 'none' ? 'bg-gray-100 text-gray-700' : '' }}
                                    {{ $payment->verification_status === 'pending_verification' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $payment->verification_status === 'approved' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $payment->verification_status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $payment->verification_status)) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-gray-500 font-medium">Created</p>
                                <p class="text-gray-900">{{ $payment->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right: QRIS & Actions or Installments -->
                    <div class="flex flex-col items-center gap-4 w-full md:w-auto">
                        @if(strtolower($payment->payment_type) === 'installment')
                            <div class="w-full mt-4 md:mt-0">
                                <h4 class="font-semibold text-gray-900 mb-3 text-center md:text-left">Jadwal Cicilan</h4>
                                <div class="space-y-3">
                                    @foreach($payment->installments->sortBy('installment_number') as $installment)
                                        @php
                                            $isPaid = $installment->status === 'paid';
                                            $isOverdue = $installment->status === 'overdue';
                                            $isPendingVerification = $installment->verification_status === 'pending_verification';
                                            $isRejected = $installment->verification_status === 'rejected';
                                            $isNextPayable = $nextInstallment && $nextInstallment->id === $installment->id;
                                            
                                            $borderClass = $isPaid ? 'border-green-300 bg-green-50' : ($isOverdue ? 'border-red-300 bg-red-50' : ($isPendingVerification ? 'border-blue-300 bg-blue-50' : ($isRejected ? 'border-orange-300 bg-orange-50' : 'border-gray-200 bg-gray-50')));
                                        @endphp
                                        <div class="border rounded-lg p-4 {{ $borderClass }} flex flex-col gap-3">
                                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2">
                                                        @if($isPaid)
                                                            <span class="inline-flex items-center justify-center w-6 h-6 bg-green-500 rounded-full">
                                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                            </span>
                                                        @elseif($isOverdue)
                                                            <span class="inline-flex items-center justify-center w-6 h-6 bg-red-500 rounded-full">
                                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"></path></svg>
                                                            </span>
                                                        @elseif($isPendingVerification)
                                                            <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-500 rounded-full">
                                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path></svg>
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center justify-center w-6 h-6 bg-gray-300 rounded-full text-gray-600 text-xs font-bold">{{ $installment->installment_number }}</span>
                                                        @endif
                                                        <p class="text-sm font-semibold text-gray-900">Cicilan #{{ $installment->installment_number }}</p>
                                                    </div>
                                                    <p class="text-xs text-gray-500 mt-1 ml-8">Jatuh tempo: {{ $installment->due_date->format('d M Y') }}</p>
                                                    <p class="text-sm font-bold mt-1 ml-8">Rp {{ number_format($installment->amount, 0, ',', '.') }}</p>
                                                    <div class="flex items-center gap-3 mt-1 ml-8">
                                                        <span class="text-xs px-2 py-0.5 rounded font-medium
                                                            {{ $isPaid ? 'bg-green-200 text-green-800' : '' }}
                                                            {{ $isOverdue ? 'bg-red-200 text-red-800' : '' }}
                                                            {{ (!$isPaid && !$isOverdue) ? 'bg-yellow-200 text-yellow-800' : '' }}">
                                                            {{ ucfirst($installment->status) }}
                                                        </span>
                                                        @if($installment->verification_status !== 'none')
                                                            <span class="text-xs px-2 py-0.5 rounded font-medium
                                                                {{ $installment->verification_status === 'approved' ? 'bg-green-200 text-green-800' : '' }}
                                                                {{ $installment->verification_status === 'rejected' ? 'bg-red-200 text-red-800' : '' }}
                                                                {{ $installment->verification_status === 'pending_verification' ? 'bg-blue-200 text-blue-800' : '' }}">
                                                                {{ ucfirst(str_replace('_', ' ', $installment->verification_status)) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex flex-col gap-2 items-end">
                                                    @if($isNextPayable)
                                                        <button onclick='openUploadInstallmentProofModal(@json($installment->id))' 
                                                            class="px-3 py-1.5 bg-[#10B981] text-white rounded hover:bg-[#0B4637] transition font-medium text-xs whitespace-nowrap">
                                                            📤 Upload Bukti
                                                        </button>
                                                    @endif
                                                    @if($installment->proof_of_payment)
                                                        @php
                                                            $instProofUrl = Str::startsWith($installment->proof_of_payment, 'images/') ? asset($installment->proof_of_payment) : asset('storage/' . $installment->proof_of_payment);
                                                            $instAmount = number_format($installment->amount, 0, ',', '.');
                                                            $instDate = $installment->payment_date ? $installment->payment_date->format('d M Y') : '-';
                                                        @endphp
                                                        <button onclick="openViewProofModal('{{ $instProofUrl }}', '{{ $instAmount }}', '{{ $instDate }}', '{{ $installment->verification_status }}')" 
                                                            class="p-1 text-green-600 hover:bg-green-50 rounded transition" 
                                                            title="View Proof">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Show QRIS on the next payable installment --}}
                                            @if($isNextPayable)
                                                <div class="border-t border-gray-200 pt-3 mt-1">
                                                    <p class="text-xs font-semibold text-gray-700 mb-2">Scan QRIS untuk membayar cicilan ini:</p>
                                                    <div class="flex items-center gap-3">
                                                        @php
                                                            $qrisUrl = null;
                                                            if(file_exists(public_path('images/qris.jpg'))) {
                                                                $qrisUrl = asset('images/qris.jpg');
                                                            } elseif(file_exists(storage_path('app/public/qris.jpg'))) {
                                                                $qrisUrl = asset('storage/qris.jpg');
                                                            }
                                                        @endphp
                                                        @if($qrisUrl)
                                                            <button type="button" onclick="openQrisModal('{{ $qrisUrl }}', '{{ number_format($installment->amount, 0, ',', '.') }}')" title="Click to view QRIS">
                                                                <img src="{{ $qrisUrl }}" alt="QRIS" class="w-24 h-24 object-cover rounded hover:scale-105 transition-transform cursor-pointer shadow-sm border border-gray-200">
                                                            </button>
                                                            <div class="flex flex-col gap-2">
                                                                <button type="button" onclick="openQrisModal('{{ $qrisUrl }}', '{{ number_format($installment->amount, 0, ',', '.') }}')" class="text-xs font-semibold px-3 py-1.5 bg-blue-100 text-blue-800 rounded hover:bg-blue-200 transition text-center">
                                                                    🔍 View QRIS
                                                                </button>
                                                                <p class="text-xs text-gray-500 font-semibold text-center">Rp {{ number_format($installment->amount, 0, ',', '.') }}</p>
                                                            </div>
                                                        @else
                                                            <div class="w-24 h-24 bg-gray-200 rounded flex items-center justify-center text-gray-500 text-xs text-center p-2">
                                                                QRIS Image
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <!-- QRIS Image for Full Payment -->
                            @if($payment->payment_status === 'pending' || $payment->verification_status === 'rejected')
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col items-center gap-3">
                                    @php
                                        $qrisUrl = null;
                                        if(file_exists(public_path('images/qris.jpg'))) {
                                            $qrisUrl = asset('images/qris.jpg');
                                        } elseif(file_exists(storage_path('app/public/qris.jpg'))) {
                                            $qrisUrl = asset('storage/qris.jpg');
                                        }
                                    @endphp

                                    @if($qrisUrl)
                                        <button type="button" onclick="openQrisModal('{{ $qrisUrl }}', '{{ number_format($payment->amount, 0, ',', '.') }}')" title="Click to view QRIS">
                                            <img src="{{ $qrisUrl }}" alt="QRIS" class="w-32 h-32 object-cover rounded hover:scale-105 transition-transform cursor-pointer shadow-sm border border-gray-200">
                                        </button>
                                        <button type="button" onclick="openQrisModal('{{ $qrisUrl }}', '{{ number_format($payment->amount, 0, ',', '.') }}')" class="text-sm font-semibold px-4 py-2 bg-blue-100 text-blue-800 rounded-lg hover:bg-blue-200 transition text-center w-full mt-2">
                                            🔍 View QRIS
                                        </button>
                                    @else
                                        <div class="w-32 h-32 bg-gray-200 rounded flex items-center justify-center text-gray-500 text-xs text-center p-2">
                                            QRIS Image
                                        </div>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                @if($payment->verification_status === 'rejected')
                                    <!-- Rejected Payment: Show Both Options -->
                                    <div class="w-full space-y-2">
                                        <button onclick='openUploadProofModal(@json($payment->id))' 
                                            class="w-full px-4 py-2 bg-[#10B981] text-white rounded-lg hover:bg-[#0B4637] transition font-medium text-sm">
                                            📤 Upload Bukti Baru
                                        </button>
                                        <form action="{{ route('student.select.class.again') }}" method="POST" class="w-full">
                                            @csrf
                                            <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                            <button type="submit" 
                                                onclick="return confirm('Yakin ingin memilih kelas lagi? Pembayaran ini akan dibatalkan.')"
                                                class="w-full px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition font-medium text-sm">
                                                🔄 Pilih Kelas Lagi
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <!-- Pending Payment: Show Upload Only -->
                                    <button onclick='openUploadProofModal(@json($payment->id))' 
                                        class="w-full px-4 py-2 bg-[#10B981] text-white rounded-lg hover:bg-[#0B4637] transition font-medium text-sm">
                                        📤 Upload Bukti Pembayaran
                                    </button>
                                @endif
                            @else
                                <div class="text-center">
                                    @if($payment->verification_status === 'approved')
                                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-2 mx-auto">
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-green-600">Approved</p>
                                    @elseif($payment->verification_status === 'pending_verification')
                                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-2 mx-auto">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-blue-600">Menunggu Verifikasi</p>
                                    @else
                                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-2 mx-auto">
                                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-gray-600">Completed</p>
                                    @endif
                                </div>

                                @if($payment->proof_of_payment)
                                    @php
                                        $proofUrl = Str::startsWith($payment->proof_of_payment, 'images/') ? asset($payment->proof_of_payment) : asset('storage/' . $payment->proof_of_payment);
                                        $amountStr = number_format($payment->amount, 0, ',', '.');
                                        $dateStr = $payment->payment_date ? $payment->payment_date->format('d M Y') : '-';
                                    @endphp
                                    <button onclick="openViewProofModal('{{ $proofUrl }}', '{{ $amountStr }}', '{{ $dateStr }}', '{{ $payment->verification_status }}')" 
                                        class="w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium text-sm flex justify-center items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Lihat Bukti
                                    </button>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-bold text-gray-900 mb-2">No Invoices Yet</h3>
                <p class="text-sm text-gray-500">Your payment invoices will appear here</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($payments->hasPages())
        <div class="mt-8">
            {{ $payments->links() }}
        </div>
    @endif

    <!-- Upload Proof Modal -->
    <div id="uploadProofModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Upload Bukti Pembayaran</h3>
                <button onclick="closeUploadProofModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="uploadProofForm" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" id="paymentId" name="payment_id">

                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-[#10B981] transition"
                    onclick="document.getElementById('proofFile').click()">
                    <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3v-6"></path>
                    </svg>
                    <p class="text-sm font-medium text-gray-600">Click to upload or drag and drop</p>
                    <p class="text-xs text-gray-500 mt-1">JPG, PNG, PDF (max 5MB)</p>
                </div>

                <input type="file" id="proofFile" name="proof_of_payment" accept=".jpg,.jpeg,.png,.pdf" class="hidden" required>
                <div id="fileName" class="text-sm text-gray-600 hidden">
                    <span class="font-medium">Selected:</span> <span id="fileNameText"></span>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeUploadProofModal()" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-[#10B981] text-white rounded-lg hover:bg-[#0B4637] transition font-medium">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Proof Modal -->
    <div id="viewProofModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Bukti Pembayaran</h3>
                <button onclick="closeViewProofModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="space-y-4">
                <img id="viewProofImage" src="" alt="Bukti Pembayaran" class="w-full rounded-lg border border-gray-200">
                <div class="grid grid-cols-2 gap-4 text-sm mt-4">
                    <div>
                        <p class="text-gray-500 font-medium">Nominal</p>
                        <p class="font-bold text-[#10B981]">Rp <span id="viewProofAmount"></span></p>
                    </div>
                    <div>
                        <p class="text-gray-500 font-medium">Tanggal</p>
                        <p id="viewProofDate" class="font-medium text-gray-900"></p>
                    </div>
                    <div>
                        <p class="text-gray-500 font-medium mb-1">Status Verifikasi</p>
                        <span id="viewProofStatus" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium uppercase"></span>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 border-t border-gray-200 pt-6">
                <button type="button" onclick="closeViewProofModal()" class="w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- QRIS Modal -->
    <div id="qrisModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-lg max-w-sm w-full p-6 text-center">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Scan QRIS</h3>
                <button onclick="closeQrisModal()" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <p class="text-sm text-gray-600 mb-4">Total Pembayaran: <strong id="qrisModalAmountText" class="text-gray-900"></strong></p>
            
            <img id="qrisModalImg" src="" alt="QRIS Code" class="w-full h-auto mx-auto border-2 border-gray-100 rounded-lg shadow-sm mb-4">
            
            <a id="qrisModalDownloadBtn" href="" download="QRIS_ICH.jpg" class="w-full inline-flex justify-center items-center gap-2 px-4 py-3 bg-[#10B981] text-white rounded-lg hover:bg-[#0B4637] transition font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Download QR
            </a>
            
            <button onclick="closeQrisModal()" class="w-full mt-3 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium text-sm">
                Tutup
            </button>
        </div>
    </div>

    <script>
        function openQrisModal(url, amount) {
            document.getElementById('qrisModalImg').src = url;
            document.getElementById('qrisModalDownloadBtn').href = url;
            document.getElementById('qrisModalAmountText').textContent = 'Rp ' + amount;
            document.getElementById('qrisModal').classList.remove('hidden');
        }

        function closeQrisModal() {
            document.getElementById('qrisModal').classList.add('hidden');
        }

        function openUploadProofModal(paymentId, isInstallment = false) {
            document.getElementById('paymentId').value = paymentId;
            document.getElementById('uploadProofModal').classList.remove('hidden');
            document.getElementById('uploadProofForm').dataset.isInstallment = isInstallment;
        }

        function openViewProofModal(imageUrl, amount, date, status) {
            document.getElementById('viewProofImage').src = imageUrl;
            document.getElementById('viewProofAmount').textContent = amount;
            document.getElementById('viewProofDate').textContent = date;
            
            const statusEl = document.getElementById('viewProofStatus');
            statusEl.textContent = status.replace('_', ' ');
            statusEl.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium uppercase ' + 
                (status === 'approved' ? 'bg-green-100 text-green-800' : 
                (status === 'rejected' ? 'bg-red-100 text-red-800' : 
                (status === 'pending_verification' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')));
            
            document.getElementById('viewProofModal').classList.remove('hidden');
        }

        function closeViewProofModal() {
            document.getElementById('viewProofModal').classList.add('hidden');
        }

        function openUploadInstallmentProofModal(installmentId) {
            openUploadProofModal(installmentId, true);
        }

        function closeUploadProofModal() {
            document.getElementById('uploadProofModal').classList.add('hidden');
            document.getElementById('uploadProofForm').reset();
            document.getElementById('fileName').classList.add('hidden');
            document.getElementById('uploadProofForm').dataset.isInstallment = false;
        }

        // File input handler
        document.getElementById('proofFile').addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                document.getElementById('fileNameText').textContent = e.target.files[0].name;
                document.getElementById('fileName').classList.remove('hidden');
            }
        });

        // Form submission
        document.getElementById('uploadProofForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const id = document.getElementById('paymentId').value;
            const isInstallment = this.dataset.isInstallment === 'true';
            const formData = new FormData(this);
            
            const url = isInstallment 
                ? `/student/installments/${id}/upload-proof`
                : `/student/payments/${id}/upload-proof`;

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                });

                const data = await response.json();

                if (data.success) {
                    alert('Bukti pembayaran berhasil diupload. Tunggu verifikasi dari admin.');
                    closeUploadProofModal();
                    location.reload();
                } else {
                    alert('Error: ' + (data.errors?.proof_of_payment?.[0] || data.error || 'Gagal mengunggah file'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });

        // Close modal when clicking outside
        document.getElementById('uploadProofModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeUploadProofModal();
            }
        });
    </script>
@endsection
