@extends('layouts.student')

@section('title', 'Pilih Kelas - English Club ICH')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-emerald-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-block bg-emerald-100 text-emerald-800 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                Langkah 1: Pilih Kelas Anda
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Pilih Kelas yang Sesuai untuk Anda
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Pilih paket kelas yang sesuai dengan kebutuhan dan tingkat kemampuan bahasa Inggris Anda. Setelah memilih, Anda dapat memilih metode pembayaran.
            </p>
        </div>

        <!-- Pricing Cards -->
        @if(!$isRegistrationClosed)
        <div class="flex md:grid md:grid-cols-3 gap-6 max-w-6xl mx-auto overflow-x-auto md:overflow-visible snap-x snap-mandatory scroll-smooth pb-4 no-scrollbar">
            
            @forelse($courses as $course)
                @if($course->is_featured)
                    <!-- Premium/Featured Plan -->
                    <div class="min-w-[90%] sm:min-w-[80%] md:min-w-0 snap-center bg-gradient-to-br from-[#0B4637] to-[#10B981] rounded-2xl p-8 text-white relative hover:shadow-2xl transition-all duration-300 transform md:scale-105 flex flex-col h-full">
                        <div class="absolute top-0 right-0 bg-[#10B981] text-white px-4 py-1 rounded-bl-lg rounded-tr-2xl text-sm font-semibold">
                            Paling Populer
                        </div>
                        <div class="text-center mb-4 mt-4">
                            <div class="mb-2 text-center">
                                <h3 class="text-2xl font-bold">
                                    {{ $course->name }}
                                </h3>
                            </div>
                            <p class="text-emerald-100 text-sm mb-3">{{ $course->subtitle ?? 'Tingkatkan kemampuan bahasa Inggris Anda' }}</p>
                            @if($course->suitable_for)
                            <div class="inline-block bg-white/20 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $course->suitable_for }}
                            </div>
                            @endif
                        </div>
                        <div class="text-center mb-6">
                            @if($course->original_price)
                            <div class="text-emerald-200 line-through text-lg">Rp {{ number_format($course->original_price, 0, ',', '.') }}</div>
                            @endif
                            <div class="text-2xl sm:text-4xl font-bold">Rp {{ number_format($course->price, 0, ',', '.') }}</div>
                            <div class="text-emerald-100 text-sm mt-2">Selama {{ $course->duration }} Bulan</div>
                        </div>
                        <ul class="space-y-3 mb-8 flex-grow">
                            @if($course->features && is_array($course->features))
                                @foreach($course->features as $feature)
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-yellow-400 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ $feature }}</span>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                        <form action="{{ route('student.select.class.confirm') }}" method="POST" class="mt-auto">
                            @csrf
                            @php $availableClasses = $classes->get($course->level); @endphp
                            @if($availableClasses && $availableClasses->count() > 0)
                                <div class="mb-4 text-left">
                                    <label class="block text-sm font-semibold text-emerald-100 mb-2">Pilih Jadwal & Metode:</label>
                                    <select name="class_id" required class="w-full border-transparent rounded-lg shadow-sm focus:border-white focus:ring-white text-sm py-2 px-3 bg-white/10 text-white placeholder-emerald-200">
                                        <option value="" disabled selected class="text-gray-900">-- Pilih Jadwal --</option>
                                        @foreach($availableClasses as $class)
                                            <option value="{{ $class->id }}" class="text-gray-900">
                                                {{ ucfirst($class->learning_method) }} | {{ $class->schedule }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="w-full bg-white text-[#0B4637] py-3 rounded-xl font-semibold hover:bg-emerald-50 transition-all duration-300 shadow-lg hover:shadow-xl">
                                    Lanjut ke Pembayaran
                                </button>
                            @else
                                <button type="button" disabled class="w-full bg-white/50 text-white py-3 rounded-xl font-semibold cursor-not-allowed">
                                    Kelas Tidak Tersedia
                                </button>
                            @endif
                        </form>
                    </div>
                @else
                    <!-- Basic/Normal Plan -->
                    <div class="min-w-[90%] sm:min-w-[80%] md:min-w-0 snap-center bg-white rounded-2xl p-8 border border-gray-200 hover:shadow-xl transition-all duration-300 flex flex-col h-full">
                        <div class="text-center mb-4">
                            <div class="mb-2 text-center">
                                <h3 class="text-2xl font-bold text-[#0B4637]">
                                    {{ $course->name }}
                                </h3>
                            </div>
                            <p class="text-gray-600 text-sm mb-3">
                                {{ $course->subtitle ?? 'Pilihan terbaik untuk Anda' }}
                            </p>
                            @if($course->suitable_for)
                            <div class="inline-block bg-[#0B4637]/10 text-[#0B4637] px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $course->suitable_for }}
                            </div>
                            @endif
                        </div>

                        <div class="text-center mb-6">
                            @if($course->original_price)
                            <div class="text-gray-400 line-through text-lg">Rp {{ number_format($course->original_price, 0, ',', '.') }}</div>
                            @endif
                            <div class="text-2xl sm:text-4xl font-bold text-[#10B981]">Rp {{ number_format($course->price, 0, ',', '.') }}</div>
                            <div class="text-gray-600 text-sm mt-2">Selama {{ $course->duration }} Bulan</div>
                        </div>
                        <ul class="space-y-3 mb-8 flex-grow">
                            @if($course->features && is_array($course->features))
                                @foreach($course->features as $feature)
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-[#10B981] mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-gray-600">{{ $feature }}</span>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                        <form action="{{ route('student.select.class.confirm') }}" method="POST" class="mt-auto">
                            @csrf
                            @php $availableClasses = $classes->get($course->level); @endphp
                            @if($availableClasses && $availableClasses->count() > 0)
                                <div class="mb-4 text-left">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Jadwal & Metode:</label>
                                    <select name="class_id" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#0B4637] focus:ring-[#0B4637] text-sm py-2 px-3 bg-gray-50">
                                        <option value="" disabled selected>-- Pilih Jadwal --</option>
                                        @foreach($availableClasses as $class)
                                            <option value="{{ $class->id }}">
                                                {{ ucfirst($class->learning_method) }} | {{ $class->schedule }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="w-full bg-[#0B4637] text-white py-3 rounded-xl font-semibold hover:bg-[#0B4637]/90 transition-all duration-300 shadow-lg hover:shadow-xl">
                                    Lanjut ke Pembayaran
                                </button>
                            @else
                                <button type="button" disabled class="w-full bg-gray-300 text-gray-500 py-3 rounded-xl font-semibold cursor-not-allowed">
                                    Kelas Tidak Tersedia
                                </button>
                            @endif
                        </form>
                    </div>
                @endif
            @empty
                <div class="col-span-3 text-center text-gray-500 py-10">
                    Belum ada paket kelas yang tersedia saat ini.
                </div>
            @endforelse
        </div>
        @else
        <div class="max-w-3xl mx-auto bg-red-50 border-l-4 border-red-500 rounded-r-xl p-8 shadow-sm text-center">
            <svg class="w-16 h-16 text-red-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <h2 class="text-2xl font-bold text-red-800 mb-2">Batch 1 Telah Berakhir</h2>
            <p class="text-lg text-red-700">
                Maaf pendaftaran telah ditutup. Terima kasih atas antusiasme Anda. Silakan nantikan Batch selanjutnya!
            </p>
        </div>
        @endif

        <!-- Additional Info -->
        <div class="mt-12 bg-white rounded-2xl p-8 shadow-lg max-w-4xl mx-auto">
            <div class="grid md:grid-cols-3 gap-6 text-center">
                <div>
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-emerald-100 rounded-full mb-4">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Pembayaran Fleksibel</h4>
                    <p class="text-sm text-gray-600">Bayar penuh atau cicilan sesuai kebutuhan Anda</p>
                </div>
                <div>
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-emerald-100 rounded-full mb-4">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Akses Selamanya</h4>
                    <p class="text-sm text-gray-600">Materi e-learning dapat diakses kapan saja</p>
                </div>
                <div>
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-emerald-100 rounded-full mb-4">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Sertifikat Resmi</h4>
                    <p class="text-sm text-gray-600">Dapatkan sertifikat digital setelah selesai</p>
                </div>
            </div>
        </div>

        <!-- Help Text -->
        <div class="mt-8 text-center">
            <p class="text-gray-600">
                Butuh bantuan memilih kelas yang tepat? 
                <a href="https://wa.me/6281234567890" target="_blank" class="text-emerald-600 hover:text-emerald-700 font-semibold">
                    Hubungi kami via WhatsApp
                </a>
            </p>
        </div>

    </div>
</div>
@endsection
