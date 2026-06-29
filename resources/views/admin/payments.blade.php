@extends('layouts.admin')

@section('title', 'Payments Management')

@section('page-title', 'Payments')

@section('page-subtitle', 'Manage all student payments and transactions')

@section('content')
    <!-- Page Header with Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <!-- Search Bar -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <input type="text" id="searchInput" name="search" value="{{ request('search') }}" placeholder="Search by student name or class..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent" onkeyup="if(event.key === 'Enter') performSearch()">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Filter Buttons -->
            <div class="flex items-center space-x-3">
                <select id="typeFilter" name="payment_type" onchange="performSearch()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                    <option value="">All Types</option>
                    <option value="full" {{ request('payment_type') === 'full' ? 'selected' : '' }}>Full Payment</option>
                    <option value="installment" {{ request('payment_type') === 'installment' ? 'selected' : '' }}>Installment</option>
                </select>
                <select id="statusFilter" name="status" onchange="performSearch()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
                @if(Auth::user()->role !== 'owner')
                <button 
    onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'add-payment' }))"
    class="px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition font-medium">
    Add Payment
</button>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <h4 class="text-xs font-semibold text-gray-500 uppercase">Full Payment</h4>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total_full'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <h4 class="text-xs font-semibold text-gray-500 uppercase">Installment</h4>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total_installment'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <h4 class="text-xs font-semibold text-gray-500 uppercase">Paid</h4>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['total_paid'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <h4 class="text-xs font-semibold text-gray-500 uppercase">Pending</h4>
            <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $stats['total_pending'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <h4 class="text-xs font-semibold text-gray-500 uppercase">Overdue</h4>
            <p class="text-2xl font-bold text-red-600 mt-1">{{ $stats['total_overdue'] }}</p>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Student</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Class</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Installments</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($payments as $payment)
                        @php
                            $isInstallment = strtolower($payment->payment_type) === 'installment';
                            $paidCount = $isInstallment ? $payment->installments->where('status', 'paid')->count() : 0;
                            $totalCount = $isInstallment ? $payment->installments->count() : 0;
                            $progressPct = $totalCount > 0 ? ($paidCount / $totalCount * 100) : 0;
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-[#10B981] rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr($payment->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $payment->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $payment->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-medium text-gray-900">{{ $payment->schoolClass->name ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500">{{ $payment->schoolClass->course->name ?? 'N/A' }}</p>
                                @if($payment->payment_type)
                                    <div class="mt-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ strtolower($payment->payment_type) === 'full' ? 'bg-indigo-100 text-indigo-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ strtoupper($payment->payment_type) }}
                                        </span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-bold text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                @if($isInstallment)
                                    <p class="text-xs text-green-600 mt-0.5">Paid: Rp {{ number_format($payment->installment_paid ?? 0, 0, ',', '.') }}</p>
                                    <p class="text-xs text-red-600">Left: Rp {{ number_format($payment->installment_remaining ?? $payment->amount, 0, ',', '.') }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($isInstallment)
                                    <div class="min-w-[120px]">
                                        <div class="flex items-center justify-between mb-1">
                                            <p class="text-xs font-bold text-gray-900">{{ $paidCount }}/{{ $totalCount }} Paid</p>
                                            <button onclick="toggleInstallmentDetail({{ $payment->id }})" class="text-blue-600 hover:text-blue-800 ml-2" title="View Details">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </button>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-[#10B981] h-2 rounded-full transition-all duration-300" style="width: {{ $progressPct }}%"></div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $payment->payment_status === 'paid' && strtolower($payment->payment_type) === 'installment' && $payment->installment_remaining > 0 ? 'bg-blue-100 text-blue-700' : ($payment->payment_status === 'paid' ? 'bg-green-100 text-green-700' : '') }}
                                    {{ $payment->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $payment->payment_status === 'failed' ? 'bg-red-100 text-red-700' : '' }}">
                                    {{ $payment->payment_status === 'paid' && strtolower($payment->payment_type) === 'installment' && $payment->installment_remaining > 0 ? 'Partially Paid' : ucfirst($payment->payment_status) }}
                                </span>
                                
                                <div class="mt-2">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                        {{ $payment->verification_status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $payment->verification_status === 'pending_verification' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $payment->verification_status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $payment->verification_status === 'none' ? 'bg-gray-100 text-gray-800' : '' }}">
                                        Verify: {{ ucfirst(str_replace('_', ' ', $payment->verification_status)) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-900">{{ $payment->payment_date->format('d M Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $payment->created_at->format('H:i') }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    @if(Auth::user()->role !== 'owner')
                                    <button onclick='openEditPayment(@json($payment->id), @json($payment->user_id), @json($payment->class_id), @json($payment->amount), @json($payment->payment_date?->format("Y-m-d")), @json($payment->payment_status), @json($payment->notes))' class="p-1 text-blue-600 hover:bg-blue-50 rounded transition" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    @endif
                                    
                                    @if($payment->proof_of_payment && !$isInstallment)
                                        @php
                                            $proofUrl = Str::startsWith($payment->proof_of_payment, 'images/') ? asset($payment->proof_of_payment) : asset('storage/' . $payment->proof_of_payment);
                                            $amountStr = number_format($payment->amount, 0, ',', '.');
                                            $dateStr = $payment->payment_date ? $payment->payment_date->format('d M Y') : '-';
                                        @endphp
                                        <button onclick="openProofModal({{ $payment->id }}, '{{ $proofUrl }}', '{{ addslashes($payment->user->name) }}', '{{ $dateStr }}', '{{ $amountStr }}', '{{ $payment->verification_status }}')"
                                           class="p-1 text-green-600 hover:bg-green-50 rounded transition"
                                           title="View Proof">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </button>
                                    @endif

                                    @if($isInstallment)
                                        <button onclick="toggleInstallmentDetail({{ $payment->id }})" class="p-1 text-purple-600 hover:bg-purple-50 rounded transition" title="View Installments">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                                        </button>
                                    @endif

                                    @if(Auth::user()->role !== 'owner')
                                    <button onclick="openDeletePayment({{ $payment->id }}, '{{ addslashes($payment->user->name) }}', {{ $payment->amount }})" class="p-1 text-red-600 hover:bg-red-50 rounded transition" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- Expandable Installment Detail Row --}}
                        @if($isInstallment)
                            <tr id="installment-detail-{{ $payment->id }}" class="hidden">
                                <td colspan="7" class="px-6 py-4 bg-gray-50">
                                    <div class="max-w-4xl">
                                        <h4 class="text-sm font-bold text-gray-800 mb-3">📋 Installment Details — {{ $payment->user->name }}</h4>
                                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                                            <table class="w-full text-sm">
                                                <thead class="bg-gray-100">
                                                    <tr>
                                                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">#</th>
                                                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Amount</th>
                                                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Due Date</th>
                                                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Status</th>
                                                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Verification</th>
                                                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Proof</th>
                                                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-100">
                                                    @foreach($payment->installments->sortBy('installment_number') as $inst)
                                                        <tr class="{{ $inst->status === 'paid' ? 'bg-green-50' : ($inst->status === 'overdue' ? 'bg-red-50' : '') }}">
                                                            <td class="px-4 py-3 font-medium">{{ $inst->installment_number }}</td>
                                                            <td class="px-4 py-3 font-bold">Rp {{ number_format($inst->amount, 0, ',', '.') }}</td>
                                                            <td class="px-4 py-3">{{ $inst->due_date->format('d M Y') }}</td>
                                                            <td class="px-4 py-3">
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                                    {{ $inst->status === 'paid' ? 'bg-green-200 text-green-800' : '' }}
                                                                    {{ $inst->status === 'pending' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                                                    {{ $inst->status === 'overdue' ? 'bg-red-200 text-red-800' : '' }}">
                                                                    {{ ucfirst($inst->status) }}
                                                                </span>
                                                            </td>
                                                            <td class="px-4 py-3">
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                                    {{ $inst->verification_status === 'approved' ? 'bg-green-200 text-green-800' : '' }}
                                                                    {{ $inst->verification_status === 'pending_verification' ? 'bg-blue-200 text-blue-800' : '' }}
                                                                    {{ $inst->verification_status === 'rejected' ? 'bg-red-200 text-red-800' : '' }}
                                                                    {{ $inst->verification_status === 'none' ? 'bg-gray-200 text-gray-800' : '' }}">
                                                                    {{ ucfirst(str_replace('_', ' ', $inst->verification_status)) }}
                                                                </span>
                                                            </td>
                                                            <td class="px-4 py-3">
                                                                @if($inst->proof_of_payment)
                                                                    @php
                                                                        $instProofUrl = Str::startsWith($inst->proof_of_payment, 'images/') ? asset($inst->proof_of_payment) : asset('storage/' . $inst->proof_of_payment);
                                                                    @endphp
                                                                    <button onclick="openProofModal({{ $inst->id }}, '{{ $instProofUrl }}', '{{ addslashes($payment->user->name) }}', '{{ $inst->payment_date ? $inst->payment_date->format('d M Y') : '-' }}', '{{ number_format($inst->amount, 0, ',', '.') }}', '{{ $inst->verification_status }}', 'installment')"
                                                                       class="p-1 text-green-600 hover:bg-green-50 rounded transition"
                                                                       title="View Proof">
                                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                        </svg>
                                                                    </button>
                                                                @else
                                                                    <span class="text-gray-400 text-xs">—</span>
                                                                @endif
                                                            </td>
                                                            <td class="px-4 py-3">
                                                                @if($inst->verification_status === 'pending_verification')
                                                                    @if(Auth::user()->role !== 'owner')
                                                                    <div class="flex items-center space-x-1">
                                                                        <button onclick="verifyInstallment({{ $inst->id }}, 'approved')" class="px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700 transition" title="Approve">
                                                                            ✓
                                                                        </button>
                                                                        <button onclick="verifyInstallment({{ $inst->id }}, 'rejected')" class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700 transition" title="Reject">
                                                                            ✗
                                                                        </button>
                                                                    </div>
                                                                    @else
                                                                    <span class="text-yellow-600 text-xs font-medium">Pending Review</span>
                                                                    @endif
                                                                @elseif($inst->status === 'paid')
                                                                    <span class="text-green-600 text-xs font-medium">✓ Done</span>
                                                                @else
                                                                    <span class="text-gray-400 text-xs">—</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-2 text-xs text-gray-500">
                                            Progress: {{ $paidCount }}/{{ $totalCount }} installments • Rp {{ number_format($payment->installment_paid ?? 0, 0, ',', '.') }} / Rp {{ number_format($payment->installment_total ?? $payment->amount, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                <p class="text-sm text-gray-500">No payments found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($payments->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $payments->links() }}
            </div>
        @endif
    </div>

    <!-- Add Payment Modal -->
    <div x-data="{ open: false }" @open-modal.window="if ($event.detail === 'add-payment') open = true" @close-modal.window="if ($event.detail === 'add-payment') open = false" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Add New Payment</h3>
                </div>

                <form id="addPaymentForm" class="px-6 py-4 space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Student</label>
                            <select name="user_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                                <option value="">Select Student</option>
                                <!-- Will be populated dynamically -->
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Class</label>
                            <select name="class_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                                <option value="">Select Class</option>
                                <!-- Will be populated dynamically -->
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Amount</label>
                            <input type="number" name="amount" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent" placeholder="0">
                        </div>
                        
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Date</label>
                            <input type="date" name="payment_date" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Status</label>
                            <select name="payment_status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent" placeholder="Additional notes..."></textarea>
                    </div>
                </form>

                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" @click="open = false" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                    <button type="button" onclick="submitPayment('add')" class="px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition">Add Payment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Payment Modal -->
    <div x-data="{ open: false }" @open-modal.window="if ($event.detail === 'edit-payment') open = true" @close-modal.window="if ($event.detail === 'edit-payment') open = false" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Edit Payment</h3>
                </div>

                <form id="editPaymentForm" class="px-6 py-4 space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="payment_id" id="edit_payment_id">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Student</label>
                            <select name="user_id" id="edit_user_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                                <option value="">Select Student</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Class</label>
                            <select name="class_id" id="edit_class_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                                <option value="">Select Class</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Amount</label>
                            <input type="number" name="amount" id="edit_amount" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>
                        
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Date</label>
                            <input type="date" name="payment_date" id="edit_payment_date" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Status</label>
                            <select name="payment_status" id="edit_payment_status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <textarea name="notes" id="edit_notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent"></textarea>
                    </div>
                </form>

                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" @click="open = false" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                    <button type="button" onclick="submitPayment('edit')" class="px-4 py-2 bg-[#0B4637] text-white rounded-lg hover:bg-[#10B981] transition">Update Payment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Proof Modal -->
    <div x-data="{ open: false }" @open-modal.window="if ($event.detail === 'view-proof') open = true" @close-modal.window="if ($event.detail === 'view-proof') open = false" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" @click="open = false"></div>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative bg-white rounded-xl shadow-2xl max-w-3xl w-full flex flex-col md:flex-row overflow-hidden">
                <!-- Left: Image -->
                <div class="w-full md:w-2/3 bg-gray-100 flex items-center justify-center min-h-[300px] md:min-h-[500px]">
                    <img id="proofModalImage" src="" alt="Payment Proof" class="max-w-full max-h-[70vh] object-contain">
                </div>
                
                <!-- Right: Info & Actions -->
                <div class="w-full md:w-1/3 p-6 flex flex-col">
                    <div class="flex justify-between items-start mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Payment Proof</h3>
                        <button type="button" @click="open = false" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4 flex-1">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Student</p>
                            <p id="proofModalStudent" class="text-base font-semibold text-gray-900"></p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Upload Date</p>
                            <p id="proofModalDate" class="text-base font-medium text-gray-900"></p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Amount</p>
                            <p id="proofModalAmount" class="text-xl font-bold text-[#10B981]"></p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Status</p>
                            <span id="proofModalStatus" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium uppercase"></span>
                        </div>
                    </div>

                    <div id="proofModalActions" class="mt-8 space-y-3 pt-6 border-t border-gray-200">
                        <input type="hidden" id="proofModalPaymentId">
                        <input type="hidden" id="proofModalType" value="payment">
                        @if(Auth::user()->role !== 'owner')
                        <button type="button" onclick="submitModalVerification('approved')" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Approve
                        </button>
                        <button type="button" onclick="submitModalVerification('rejected')" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Reject
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function performSearch() {
            const search = document.getElementById('searchInput').value;
            const status = document.getElementById('statusFilter').value;
            const paymentType = document.getElementById('typeFilter').value;
            
            const params = new URLSearchParams();
            if (search) params.set('search', search);
            if (status) params.set('status', status);
            if (paymentType) params.set('payment_type', paymentType);
            
            window.location.href = '/admin/payments' + (params.toString() ? '?' + params.toString() : '');
        }

        function formatCurrency(amount) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
        }
        async function loadStudentsAndClasses(selectedUser = null, selectedClass = null) {

    // LOAD STUDENTS
    const studentsResponse = await fetch('/admin/payments/students');

    const studentsData = await studentsResponse.json();

    const studentSelects = [
        document.querySelector('#addPaymentForm select[name="user_id"]'),
        document.querySelector('#edit_user_id')
    ];

    studentSelects.forEach(select => {

        if (!select) return;

        select.innerHTML = '<option value="">Select Student</option>';

        studentsData.data.forEach(student => {

            select.innerHTML += `
                <option value="${student.id}">
                    ${student.name}
                </option>
            `;
        });

        if (selectedUser) {
            select.value = selectedUser;
        }
    });

    // LOAD CLASSES
    const classesResponse = await fetch('/admin/payments/classes');

    const classesData = await classesResponse.json();

    const classSelects = [
        document.querySelector('#addPaymentForm select[name="class_id"]'),
        document.querySelector('#edit_class_id')
    ];

    classSelects.forEach(select => {

        if (!select) return;

        select.innerHTML = '<option value="">Select Class</option>';

        classesData.data.forEach(cls => {

            select.innerHTML += `
                <option value="${cls.id}">
                    ${cls.name}
                </option>
            `;
        });

        if (selectedClass) {
            select.value = selectedClass;
        }
    });
}

        function openEditPayment(
    id,
    userId,
    classId,
    amount,
    date,
    method,
    status,
    notes
) {

    document.getElementById('edit_payment_id').value = id;

    document.getElementById('edit_user_id').value = userId;

    document.getElementById('edit_class_id').value = classId;

    document.getElementById('edit_amount').value = amount;

    

    document.getElementById('edit_payment_date').value = date;

    document.getElementById('edit_payment_status').value = status;

    document.getElementById('edit_notes').value = notes || '';

    loadStudentsAndClasses(userId, classId);

    window.dispatchEvent(
        new CustomEvent('open-modal', {
            detail: 'edit-payment'
        })
    );
}

        function openDeletePayment(id, studentName, amount) {
            Swal.fire({
                title: 'Delete Payment?',
                html: `Are you sure you want to delete payment from <strong>${studentName}</strong> for <strong>${formatCurrency(amount)}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    deletePayment(id);
                }
            });
        }

        function submitPayment(mode) {

    const form = mode === 'add'
        ? document.getElementById('addPaymentForm')
        : document.getElementById('editPaymentForm');

    const formData = new FormData(form);

    let url = '/admin/payments';

    if (mode === 'edit') {

        const id = document.getElementById('edit_payment_id').value;

        url = '/admin/payments/' + id;

        // FIX LARAVEL
        formData.append('_method', 'PUT');
    }

    Swal.fire({
        title: 'Processing...',
        text: mode === 'add'
            ? 'Adding payment'
            : 'Updating payment',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(async response => {

        const data = await response.json();

        if (!response.ok) {

            let errorMessage = data.message || 'Validation failed';

            if (data.errors) {

                errorMessage = Object.values(data.errors)
                    .flat()
                    .join('\n');
            }

            throw new Error(errorMessage);
        }

        return data;
    })
    .then(data => {

        Swal.fire({
            icon: 'success',
            title: mode === 'add'
                ? 'Payment Added!'
                : 'Payment Updated!',
            text: data.message,
            timer: 2000,
            showConfirmButton: false
        });

        setTimeout(() => {
            window.location.reload();
        }, 1500);

    })
    .catch(error => {

        Swal.fire({
            icon: 'error',
            title: 'Validation Failed',
            text: error.message
        });

        console.error(error);

    });
}

        function deletePayment(id) {

    Swal.fire({
        title: 'Delete Payment?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete'
    }).then((result) => {

        if (result.isConfirmed) {

            const formData = new FormData();

            formData.append('_method', 'DELETE');

            fetch('/admin/payments/' + id, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {

                if (data.success) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                    setTimeout(() => {
                        location.reload();
                    }, 1500);

                }

            });

        }

    });

}
function verifyPayment(id, status) {
    Swal.fire({
        title: 'Verify Payment',
        text: 'Are you sure you want to ' + status + ' this payment?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, ' + status + ' it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/admin/payments/' + id + '/verify', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    type: 'payment',
                    status: status,
                    notes: ''
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error', 'An error occurred during verification.', 'error');
                console.error(error);
            });
        }
    });
}

window.addEventListener('open-modal', function(e) {
    if (e.detail === 'add-payment') {
        loadStudentsAndClasses();
    }
});

function openProofModal(id, imageUrl, studentName, date, amount, status, type = 'payment') {
    document.getElementById('proofModalPaymentId').value = id;
    document.getElementById('proofModalType').value = type;
    document.getElementById('proofModalImage').src = imageUrl;
    document.getElementById('proofModalStudent').textContent = studentName;
    document.getElementById('proofModalDate').textContent = date;
    document.getElementById('proofModalAmount').textContent = 'Rp ' + amount;
    
    const statusEl = document.getElementById('proofModalStatus');
    statusEl.textContent = status.replace('_', ' ');
    statusEl.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium uppercase ' + 
        (status === 'approved' ? 'bg-green-100 text-green-800' : 
        (status === 'rejected' ? 'bg-red-100 text-red-800' : 
        (status === 'pending_verification' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')));
        
    const actionsEl = document.getElementById('proofModalActions');
    if (status === 'pending_verification') {
        actionsEl.style.display = 'block';
    } else {
        actionsEl.style.display = 'none';
    }
    
    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'view-proof' }));
}

function submitModalVerification(status) {
    const id = document.getElementById('proofModalPaymentId').value;
    const type = document.getElementById('proofModalType').value;
    if (type === 'installment') {
        verifyInstallment(id, status);
    } else {
        verifyPayment(id, status);
    }
}

function toggleInstallmentDetail(paymentId) {
    const row = document.getElementById('installment-detail-' + paymentId);
    if (row) {
        row.classList.toggle('hidden');
    }
}

function verifyInstallment(installmentId, status) {
    Swal.fire({
        title: 'Verify Installment',
        text: 'Are you sure you want to ' + status + ' this installment?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, ' + status + ' it!',
        cancelButtonText: 'Cancel',
        confirmButtonColor: status === 'approved' ? '#16a34a' : '#dc2626',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Processing...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            fetch('/admin/installments/' + installmentId + '/verify', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    status: status,
                    notes: ''
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    Swal.fire('Error', data.message || data.error || 'Verification failed', 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error', 'An error occurred during verification.', 'error');
                console.error(error);
            });
        }
    });
}
    </script>
    
@endsection
