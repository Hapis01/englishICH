@extends('layouts.student')

@section('title', 'Opsi Pembayaran - English Club ICH')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-emerald-50 py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-block bg-emerald-100 text-emerald-800 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                Langkah 2: Pilih Metode Pembayaran
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Pilih Metode Pembayaran
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Pilih antara pembayaran penuh atau cicilan sesuai dengan kemampuan finansial Anda
            </p>
        </div>

        <!-- Selected Class Info -->
        <div class="bg-white rounded-2xl p-6 shadow-lg mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Kelas yang Dipilih</h3>
                    <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $class->course->name }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $class->name }} • {{ $class->schedule }}</p>
                    <p class="text-sm text-gray-600">Instruktur: {{ $class->teacher->name }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Total Harga</p>
                    <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($fullPrice, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-600">Durasi: {{ $class->course->duration }} Bulan</p>
                </div>
            </div>
        </div>

        <!-- Payment Options -->
        <div class="grid md:grid-cols-2 gap-6">
            
            <!-- Full Payment Option -->
            <div class="bg-white rounded-2xl p-8 border-2 border-emerald-500 shadow-xl relative">
                <div class="absolute top-0 right-0 bg-emerald-500 text-white px-4 py-1 rounded-bl-lg rounded-tr-2xl text-xs font-semibold">
                    Hemat Lebih Banyak
                </div>

                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Bayar Penuh</h3>
                    <p class="text-sm text-gray-600">Bayar sekaligus dan mulai belajar</p>
                </div>

                <div class="text-center mb-6">
                    <div class="text-4xl font-bold text-emerald-600 mb-2">
                        Rp {{ number_format($fullPrice, 0, ',', '.') }}
                    </div>
                    <p class="text-sm text-gray-600">Pembayaran Sekali</p>
                </div>

                <ul class="space-y-3 mb-8">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-emerald-500 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm text-gray-700">Langsung aktif setelah verifikasi</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-emerald-500 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm text-gray-700">Tidak ada biaya tambahan</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-emerald-500 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm text-gray-700">Proses lebih cepat dan mudah</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-emerald-500 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm text-gray-700">Bebas dari kewajiban bulanan</span>
                    </li>
                </ul>

                <form action="{{ route('student.payment.process', $class->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_type" value="full">
                    <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-700 hover:to-emerald-600 text-white py-3 px-6 rounded-lg font-semibold transition-all duration-300 shadow-lg hover:shadow-xl">
                        Pilih Bayar Penuh
                    </button>
                </form>
            </div>

            <!-- Installment Payment Option -->
            <div class="bg-white rounded-2xl p-8 border-2 border-gray-200 shadow-lg">
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Bayar Cicilan</h3>
                    <p class="text-sm text-gray-600">Bayar bertahap setiap bulan</p>
                </div>

                <div class="text-center mb-6">
                    <div class="text-4xl font-bold text-blue-600 mb-2">
                        Rp {{ number_format($installmentAmount, 0, ',', '.') }}
                    </div>
                    <p class="text-sm text-gray-600">4x Cicilan</p>
                    <p class="text-xs text-gray-500 mt-2">Total: Rp {{ number_format($fullPrice, 0, ',', '.') }}</p>
                </div>

                <ul class="space-y-3 mb-8">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm text-gray-700">Pembayaran lebih ringan setiap bulan</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm text-gray-700">Cicilan otomatis setiap bulan</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm text-gray-700">Fleksibel sesuai budget</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm text-gray-700">Tetap dapat akses penuh</span>
                    </li>
                </ul>

                <form action="{{ route('student.payment.process', $class->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_type" value="installment">
                    <button type="submit" class="w-full bg-gray-800 hover:bg-gray-900 text-white py-3 px-6 rounded-lg font-semibold transition-all duration-300 shadow-lg hover:shadow-xl">
                        Pilih Bayar Cicilan
                    </button>
                </form>
            </div>

        </div>

        <!-- Payment Info -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold mb-2">Informasi Penting:</p>
                    <ul class="space-y-1 list-disc list-inside">
                        <li>Setelah memilih metode pembayaran, Anda akan diarahkan ke halaman pembayaran</li>
                        <li>Batas waktu pembayaran adalah 7 hari setelah invoice dibuat</li>
                        <li>Akses kelas akan aktif setelah pembayaran pertama diverifikasi</li>
                        <li>Untuk cicilan, pembayaran berikutnya jatuh tempo setiap bulan</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('student.select.class') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Pilihan Kelas
            </a>
        </div>

    </div>
</div>
@endsection
