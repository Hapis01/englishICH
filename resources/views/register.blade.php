<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - English Club ICH Medan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logoich.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'emerald-deep': '#0B4637',
                        'mint-vibrant': '#10B981',
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slideUp {
            animation: slideUp 0.45s ease both;
        }
        .gradient-primary {
            background: linear-gradient(135deg, #0B4637 0%, #10B981 100%);
        }
        .glassmorphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="font-sans antialiased bg-white min-h-screen overflow-x-hidden">

    <!-- 50/50 Split Screen Layout -->
    <div class="flex flex-col lg:flex-row min-h-screen">
        
        <!-- LEFT SIDE - Branding/Marketing (50%) -->
        <div class="hidden lg:flex lg:w-1/2 bg-emerald-deep text-white p-12 flex-col justify-between relative overflow-hidden">
            
            <!-- Background Decorative Elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-10">
                <div class="absolute top-20 right-20 w-64 h-64 bg-mint-vibrant rounded-full blur-3xl"></div>
                <div class="absolute bottom-20 left-20 w-64 h-64 bg-mint-vibrant rounded-full blur-3xl"></div>
            </div>

            <!-- Top Section: Logo & Badge -->
            <div class="relative z-10">
                <div class="flex items-center space-x-3 mb-6">
                    <img src="{{ asset('images/logoich.png') }}" class="w-12 h-12 object-contain" alt="ICH Logo">
                    <div>
                        <h1 class="font-bold text-lg">English Club ICH</h1>
                        <p class="text-xs text-emerald-200">Medan</p>
                    </div>
                </div>
                
                <div class="inline-block bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full text-xs font-semibold border border-white/20 mb-8">
                    # GRAND LAUNCHING - BATCH 1 - 2026
                </div>

                <!-- Main Headline -->
                <h2 class="text-4xl lg:text-5xl font-bold leading-tight mb-4">
                    Become Part of the<br/>
                    <span class="text-mint-vibrant">First Generation</span><br/>
                    of English Club ICH Medan.
                </h2>
            </div>

            <!-- Middle Section: Benefit Cards -->
            <div class="relative z-10 space-y-4">
                <!-- Benefit Card 1 -->
                <div class="glassmorphism rounded-xl p-4 flex items-start space-x-4">
                    <div class="w-10 h-10 bg-mint-vibrant/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-mint-vibrant" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-sm mb-1">Lifetime E-Learning</h3>
                        <p class="text-xs text-emerald-200">Access to all materials forever</p>
                    </div>
                </div>

                <!-- Benefit Card 2 -->
                <div class="glassmorphism rounded-xl p-4 flex items-start space-x-4">
                    <div class="w-10 h-10 bg-mint-vibrant/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-mint-vibrant" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-sm mb-1">Live Google Meet</h3>
                        <p class="text-xs text-emerald-200">Interactive online classes</p>
                    </div>
                </div>

                <!-- Benefit Card 3 -->
                <div class="glassmorphism rounded-xl p-4 flex items-start space-x-4">
                    <div class="w-10 h-10 bg-mint-vibrant/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-mint-vibrant" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-sm mb-1">Automated Digital Certificate</h3>
                        <p class="text-xs text-emerald-200">Instant certification upon completion</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Section: Stats & Testimonial -->
            <div class="relative z-10">
                <div class="flex items-center space-x-8 mb-6">
                    <div>
                        <div class="text-3xl font-bold text-mint-vibrant">Batch 1</div>
                        <div class="text-xs text-emerald-200">Official Opening</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-mint-vibrant">Limited</div>
                        <div class="text-xs text-emerald-200">Seats Available</div>
                    </div>
                </div>

                <!-- Testimonial Card -->
                <div class="glassmorphism rounded-xl p-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 bg-mint-vibrant rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-emerald-deep font-bold text-sm">AS</span>
                        </div>
                        <div>
<p class="text-sm mb-2">
    "English Club ICH hadir untuk membantu generasi muda Medan meningkatkan kemampuan bahasa Inggris dengan metode belajar modern, interaktif, dan nyaman."
</p>

<p class="text-xs text-emerald-200">
    - English Club ICH Team
</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE - Registration Form (50%) -->
<div class="w-full lg:w-1/2 relative overflow-hidden flex flex-col justify-center min-h-screen p-5 sm:p-8 lg:p-12">

    <!-- Background Image -->
    <div class="absolute inset-0">
        <img 
            src="{{ asset('images/gambar1.jpg') }}" 
            alt="Background"
            class="w-full h-full object-cover scale-110 blur-sm"
        >

        <!-- Green Overlay -->
        <div class="absolute inset-0 bg-[#0B4637]/40 backdrop-blur-[2px]"></div>

        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-white/80 via-white/70 to-[#10B981]/20"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 animate-slideUp">
            <div class="max-w-md mx-auto w-full bg-white/85 lg:bg-transparent backdrop-blur-md lg:backdrop-blur-0 rounded-3xl lg:rounded-none shadow-2xl lg:shadow-none p-5 sm:p-0">
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 mb-6 text-sm font-semibold text-emerald-deep hover:text-mint-vibrant transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali
                </a>
            

                @if (session('error'))
                    <div class="mb-5 rounded-2xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 rounded-2xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Form Header -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Daftar Sekarang</h2>
                    <p class="text-gray-600">Mulai perjalanan bahasa Inggris Anda bersama kami</p>
                </div>

                <!-- Registration Form -->
                <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Full Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <input 
                                id="name" 
                                name="name" 
                                type="text" 
                                required 
                                value="{{ old('name') }}"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-deep focus:border-transparent"
                                placeholder="Masukkan nama lengkap Anda"
                            >
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address <span class="text-red-600">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                required 
                                value="{{ old('email') }}"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-deep focus:border-transparent"
                                placeholder="nama.anda@ich.com"
                            >
                        </div>
                        <p class="mt-1 text-xs text-red-600 font-medium">
                            <svg class="inline w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Wajib menggunakan domain @ich.com
                        </p>
                    </div>

                    <!-- WhatsApp Number Field -->
                    <div>
                        <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor WhatsApp
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <input 
                                id="whatsapp" 
                                name="whatsapp" 
                                type="tel" 
                                required 
                                value="{{ old('whatsapp') }}"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-deep focus:border-transparent"
                                placeholder="+62 812-3456-7890"
                            >
                        </div>
                    </div>

                    <!-- Security Question Dropdown -->
                    <div>
                        <label for="security_question" class="block text-sm font-medium text-gray-700 mb-2">
                            Pertanyaan Keamanan
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <select 
                                id="security_question" 
                                name="security_question" 
                                required 
                                class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-deep focus:border-transparent appearance-none bg-white"
                            >
                                <option value="">Pilih pertanyaan keamanan</option>
                                <option value="mother_maiden_name" {{ old('security_question') == 'mother_maiden_name' ? 'selected' : '' }}>Nama gadis ibu kandung Anda?</option>
                                <option value="pet_name" {{ old('security_question') == 'pet_name' ? 'selected' : '' }}>Nama hewan peliharaan pertama Anda?</option>
                                <option value="birth_city" {{ old('security_question') == 'birth_city' ? 'selected' : '' }}>Kota tempat Anda dilahirkan?</option>
                                <option value="elementary_school" {{ old('security_question') == 'elementary_school' ? 'selected' : '' }}>Nama sekolah dasar Anda?</option>
                                <option value="favorite_teacher" {{ old('security_question') == 'favorite_teacher' ? 'selected' : '' }}>Nama guru favorit Anda?</option>
                                <option value="childhood_friend" {{ old('security_question') == 'childhood_friend' ? 'selected' : '' }}>Nama teman masa kecil terbaik Anda?</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Security Answer Field -->
                    <div>
                        <label for="security_answer" class="block text-sm font-medium text-gray-700 mb-2">
                            Jawaban Keamanan
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <input 
                                id="security_answer" 
                                name="security_answer" 
                                type="text" 
                                required 
                                value="{{ old('security_answer') }}"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-deep focus:border-transparent"
                                placeholder="Masukkan jawaban Anda"
                            >
                        </div>
                    </div>

                    <!-- Password Field with Eye Icon -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input 
                                id="password" 
                                name="password" 
                                type="password" 
                                required 
                                minlength="8"
                                class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-deep focus:border-transparent"
                                placeholder="Minimal 8 karakter"
                            >
                            <button type="button" onclick="togglePassword('password', 'eye-icon')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg id="eye-icon" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        <p class="mt-1 text-xs text-red-600 font-medium">
                            <svg class="inline w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Password minimal 8 karakter
                        </p>
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                type="password" 
                                required 
                                class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-deep focus:border-transparent"
                                placeholder="Ulangi password Anda"
                            >
                            <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon-confirm')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg id="eye-icon-confirm" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Terms and Conditions (Hidden checkbox for validation) -->
                    <input type="checkbox" id="terms" name="terms" value="1" class="hidden">

                    <!-- Next Button (Step 1) -->
                    <div id="step1-button">
                        <button 
                            type="button"
                            onclick="validateStep1()"
                            class="w-full gradient-primary text-white py-3.5 px-4 rounded-lg font-semibold text-base hover:shadow-lg transition-all duration-300 flex items-center justify-center space-x-2"
                        >
                            <span>Selanjutnya</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Submit Button (Step 2 - Hidden initially) -->
                    <div id="step2-button" style="display: none;">
                        <button 
                            type="submit" 
                            class="w-full gradient-primary text-white py-3.5 px-4 rounded-lg font-semibold text-base hover:shadow-lg transition-all duration-300 flex items-center justify-center space-x-2"
                        >
                            <span>Buat Akun</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Sudah punya akun? 
                        <a href="/login" class="font-semibold text-emerald-deep hover:text-mint-vibrant transition-colors">
                            Masuk di sini
                        </a>
                    </p>
                </div>

                <!-- Security Badges -->
                <div class="mt-8 flex items-center justify-center space-x-6">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-xs text-gray-600 font-medium">SSL Secured</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-xs text-gray-600 font-medium">Data Terenkripsi</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-xs text-gray-600 font-medium">Verified</span>
                    </div>
                </div>

                        </div>
        </div>

    </div>
</div>

    <!-- Terms & Conditions Modal -->
    <div id="termsModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" onclick="closeTermsModal()"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-emerald-deep to-mint-vibrant px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white" id="modal-title">
                            Syarat & Ketentuan serta Kebijakan Privasi
                        </h3>
                        <button type="button" onclick="closeTermsModal()" class="text-white hover:text-gray-200 transition-colors">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body with scrollable content -->
                <div class="bg-white px-6 py-4 max-h-96 overflow-y-auto">
                    <div class="space-y-4 text-sm text-gray-700">
                        <section>
                            <h4 class="font-bold text-emerald-deep mb-2">1. Ketentuan Umum</h4>
                            <p class="mb-2">Dengan mendaftar di English Club ICH Medan, Anda menyetujui untuk:</p>
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Memberikan informasi yang akurat dan lengkap</li>
                                <li>Menjaga kerahasiaan akun dan password Anda</li>
                                <li>Bertanggung jawab atas semua aktivitas yang terjadi di akun Anda</li>
                                <li>Menggunakan platform ini hanya untuk tujuan pembelajaran</li>
                            </ul>
                        </section>

                        <section>
                            <h4 class="font-bold text-emerald-deep mb-2">2. Hak dan Kewajiban Pengguna</h4>
                            <p class="mb-2">Sebagai pengguna, Anda berhak:</p>
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Mengakses materi pembelajaran sesuai program yang dipilih</li>
                                <li>Mendapatkan dukungan dari instruktur selama masa belajar</li>
                                <li>Menerima sertifikat digital setelah menyelesaikan program</li>
                            </ul>
                            <p class="mt-2 mb-2">Sebagai pengguna, Anda wajib:</p>
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Mengikuti jadwal kelas yang telah ditentukan</li>
                                <li>Menyelesaikan tugas dan ujian tepat waktu</li>
                                <li>Berperilaku sopan dalam interaksi dengan instruktur dan siswa lain</li>
                                <li>Tidak menyebarkan materi pembelajaran tanpa izin</li>
                            </ul>
                        </section>

                        <section>
                            <h4 class="font-bold text-emerald-deep mb-2">3. Kebijakan Privasi</h4>
                            <p class="mb-2">Kami menghargai privasi Anda. Data pribadi yang kami kumpulkan:</p>
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Nama lengkap, email, dan nomor WhatsApp untuk komunikasi</li>
                                <li>Data pembelajaran untuk evaluasi progress</li>
                                <li>Informasi pembayaran untuk verifikasi transaksi</li>
                            </ul>
                            <p class="mt-2">Data Anda tidak akan dibagikan kepada pihak ketiga tanpa persetujuan Anda, kecuali diwajibkan oleh hukum.</p>
                        </section>

                        <section>
                            <h4 class="font-bold text-emerald-deep mb-2">4. Pembayaran dan Pengembalian Dana</h4>
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Pembayaran dilakukan sesuai dengan metode yang tersedia</li>
                                <li>Akses ke materi pembelajaran diberikan setelah pembayaran terverifikasi</li>
                                <li>Pengembalian dana dapat diajukan dalam 7 hari pertama jika tidak puas</li>
                                <li>Setelah 7 hari, tidak ada pengembalian dana</li>
                            </ul>
                        </section>

                        <section>
                            <h4 class="font-bold text-emerald-deep mb-2">5. Hak Kekayaan Intelektual</h4>
                            <p>Semua materi pembelajaran, termasuk video, dokumen, dan konten lainnya adalah hak milik English Club ICH Medan. Dilarang menyalin, mendistribusikan, atau menggunakan untuk kepentingan komersial tanpa izin tertulis.</p>
                        </section>

                        <section>
                            <h4 class="font-bold text-emerald-deep mb-2">6. Perubahan Ketentuan</h4>
                            <p>Kami berhak mengubah syarat dan ketentuan ini sewaktu-waktu. Perubahan akan diberitahukan melalui email atau notifikasi di platform. Dengan tetap menggunakan layanan setelah perubahan, Anda dianggap menyetujui ketentuan baru.</p>
                        </section>

                        <section>
                            <h4 class="font-bold text-emerald-deep mb-2">7. Kontak</h4>
                            <p>Jika Anda memiliki pertanyaan tentang syarat dan ketentuan ini, silakan hubungi kami melalui:</p>
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Email: info@englishclub-ich.com</li>
                                <li>WhatsApp: +62 812-3456-7890</li>
                            </ul>
                        </section>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-4">
                    <div class="flex items-start mb-4">
                        <div class="flex items-center h-5">
                            <input 
                                id="modal-terms-checkbox" 
                                type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded text-emerald-deep focus:ring-emerald-deep"
                            >
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="modal-terms-checkbox" class="font-medium text-gray-700">
                                Saya telah membaca dan menyetujui semua Syarat & Ketentuan serta Kebijakan Privasi di atas
                            </label>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <button 
                            type="button" 
                            onclick="closeTermsModal()"
                            class="flex-1 bg-gray-200 text-gray-700 py-3 px-4 rounded-lg font-semibold hover:bg-gray-300 transition-all duration-300"
                        >
                            Batal
                        </button>
                        <button 
                            type="button" 
                            onclick="acceptTerms()"
                            id="accept-terms-btn"
                            disabled
                            class="flex-1 gradient-primary text-white py-3 px-4 rounded-lg font-semibold hover:shadow-lg transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            Setuju & Buat Akun
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword(fieldId, iconId) {
            const passwordInput = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        }

        // Validate Step 1 fields
        function validateStep1() {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const whatsapp = document.getElementById('whatsapp').value.trim();
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            const securityQuestion = document.getElementById('security_question').value;
            const securityAnswer = document.getElementById('security_answer').value.trim();

            // Validate all fields are filled
            if (!name) {
                alert('Silakan masukkan nama lengkap Anda');
                document.getElementById('name').focus();
                return false;
            }

            if (!email) {
                alert('Silakan masukkan alamat email Anda');
                document.getElementById('email').focus();
                return false;
            }

            // Basic email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Silakan masukkan alamat email yang valid');
                document.getElementById('email').focus();
                return false;
            }

            if (!whatsapp) {
                alert('Silakan masukkan nomor WhatsApp Anda');
                document.getElementById('whatsapp').focus();
                return false;
            }

            if (!password) {
                alert('Silakan masukkan password Anda');
                document.getElementById('password').focus();
                return false;
            }

            if (password.length < 8) {
                alert('Password minimal 8 karakter');
                document.getElementById('password').focus();
                return false;
            }

            if (!passwordConfirmation) {
                alert('Silakan konfirmasi password Anda');
                document.getElementById('password_confirmation').focus();
                return false;
            }

            if (password !== passwordConfirmation) {
                alert('Password dan konfirmasi password tidak cocok');
                document.getElementById('password_confirmation').focus();
                return false;
            }

            if (!securityQuestion) {
                alert('Silakan pilih pertanyaan keamanan');
                document.getElementById('security_question').focus();
                return false;
            }

            if (!securityAnswer) {
                alert('Silakan masukkan jawaban keamanan');
                document.getElementById('security_answer').focus();
                return false;
            }

            // All validations passed, show Terms & Conditions modal
            openTermsModal();
        }

        // Open Terms & Conditions Modal
        function openTermsModal() {
            document.getElementById('termsModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        // Close Terms & Conditions Modal
        function closeTermsModal() {
            document.getElementById('termsModal').classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore scrolling
            // Reset modal checkbox
            document.getElementById('modal-terms-checkbox').checked = false;
            document.getElementById('accept-terms-btn').disabled = true;
        }

        // Enable/disable accept button based on checkbox
        document.addEventListener('DOMContentLoaded', function() {
            const modalCheckbox = document.getElementById('modal-terms-checkbox');
            const acceptBtn = document.getElementById('accept-terms-btn');

            if (modalCheckbox && acceptBtn) {
                modalCheckbox.addEventListener('change', function() {
                    acceptBtn.disabled = !this.checked;
                });
            }
        });

        // Accept Terms and submit form
        function acceptTerms() {
            const modalCheckbox = document.getElementById('modal-terms-checkbox');
            
            if (!modalCheckbox.checked) {
                alert('Silakan centang persetujuan terlebih dahulu');
                return false;
            }

            // Check the hidden terms checkbox in the form
            document.getElementById('terms').checked = true;

            // Close modal
            closeTermsModal();

            // Submit the form
            document.querySelector('form').submit();
        }

        // Prevent modal close on backdrop click for better UX
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('termsModal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    // Only close if clicking the backdrop directly, not the modal content
                    if (e.target === modal || e.target.classList.contains('bg-opacity-75')) {
                        closeTermsModal();
                    }
                });
            }
        });
    </script>

</body>
</html>
