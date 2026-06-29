<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - English Club ICH Medan</title>
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
        @keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.25s ease;
}
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
                        <h1 class="font-bold text-lg">English Club</h1>
                        <p class="text-xs text-emerald-200">Medan</p>
                    </div>
                </div>
                
                <div class="inline-block bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full text-xs font-semibold border border-white/20 mb-8">
                    # GRAND LAUNCHING - BATCH 1 - 2026
                </div>

                <!-- Main Headline -->
                <h2 class="text-4xl lg:text-5xl font-bold leading-tight mb-4">
                    Be Part of the<br/>
                    <span class="text-mint-vibrant">First Generation of</span><br/>
                    English Club ICH Medan.
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
                            <p class="text-sm mb-2">"English Club ICH hadir untuk membantu generasi muda Medan meningkatkan kemampuan bahasa Inggris dengan metode belajar modern, interaktif, dan nyaman."</p>
                            <p class="text-xs text-emerald-200">- English Club ICH Team</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE - Login Form (50%) -->
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
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang Kembali</h2>
                    <p class="text-gray-600">Masuk ke akun Anda untuk melanjutkan belajar</p>
                </div>

                <!-- Login Form -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
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
                                placeholder="contoh@email.com"
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
                                placeholder="Masukkan password Anda"
                            >
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center">
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

                    <!-- Remember Me and Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input 
                                id="remember" 
                                name="remember" 
                                type="checkbox"
                                value="1"
                                {{ old('remember') ? 'checked' : '' }}
                                class="w-4 h-4 border-gray-300 rounded text-emerald-deep focus:ring-emerald-deep"
                            >
                            <label for="remember" class="ml-2 block text-sm text-gray-600">
                                Ingat saya
                            </label>
                        </div>

                        <div class="text-sm">
                            <button 
    type="button"
    onclick="openForgotPasswordModal()"
    class="font-semibold text-emerald-deep hover:text-mint-vibrant transition-colors"
>
    Lupa password?
</button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button 
                            type="submit" 
                            class="w-full gradient-primary text-white py-3.5 px-4 rounded-lg font-semibold text-base hover:shadow-lg transition-all duration-300 flex items-center justify-center space-x-2"
                        >
                            <span>Masuk Sekarang</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Belum punya akun? 
                        <a href="/register" class="font-semibold text-emerald-deep hover:text-mint-vibrant transition-colors">
                            Daftar sekarang
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

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        }
    </script>
    <script>

function openForgotPasswordModal() {
    const modal = document.getElementById('forgotPasswordModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    resetForgotPasswordModal();
}

function closeForgotPasswordModal() {
    const modal = document.getElementById('forgotPasswordModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Close modal when click outside
window.addEventListener('click', function(e) {
    const modal = document.getElementById('forgotPasswordModal');
    if(e.target === modal) {
        closeForgotPasswordModal();
    }
});

let forgotPasswordEmail = '';

function resetForgotPasswordModal() {
    document.getElementById('fp-step-1').classList.remove('hidden');
    document.getElementById('fp-step-2').classList.add('hidden');
    document.getElementById('fp-step-3').classList.add('hidden');
    document.getElementById('fp-step-success').classList.add('hidden');
    
    document.getElementById('fp-email').value = '';
    document.getElementById('fp-security-answer').value = '';
    document.getElementById('fp-whatsapp').value = '';
    
    document.getElementById('fp-error-msg').classList.add('hidden');
    document.getElementById('fp-error-msg').innerText = '';
    forgotPasswordEmail = '';
}

function showFpError(msg) {
    const errorEl = document.getElementById('fp-error-msg');
    errorEl.innerText = msg;
    errorEl.classList.remove('hidden');
}

function hideFpError() {
    document.getElementById('fp-error-msg').classList.add('hidden');
}

function submitFpStep1() {
    const email = document.getElementById('fp-email').value.trim();
    if (!email) {
        showFpError('Silakan masukkan email Anda.');
        return;
    }
    
    hideFpError();
    const btn = document.getElementById('btn-fp-1');
    btn.innerText = 'Memeriksa...';
    btn.disabled = true;

    fetch('{{ route("forgot-password.check-email") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(data => {
        btn.innerText = 'Lanjut';
        btn.disabled = false;
        
        if (data.success) {
            forgotPasswordEmail = email;
            document.getElementById('fp-security-question-text').innerText = data.question_text;
            document.getElementById('fp-step-1').classList.add('hidden');
            document.getElementById('fp-step-2').classList.remove('hidden');
        } else {
            showFpError(data.message || 'Email tidak ditemukan, coba lagi');
        }
    })
    .catch(err => {
        btn.innerText = 'Lanjut';
        btn.disabled = false;
        showFpError('Terjadi kesalahan sistem.');
    });
}

function submitFpStep2() {
    const answer = document.getElementById('fp-security-answer').value.trim();
    if (!answer) {
        showFpError('Silakan masukkan jawaban Anda.');
        return;
    }
    
    hideFpError();
    const btn = document.getElementById('btn-fp-2');
    btn.innerText = 'Memeriksa...';
    btn.disabled = true;

    fetch('{{ route("forgot-password.verify-answer") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ email: forgotPasswordEmail, security_answer: answer })
    })
    .then(response => response.json())
    .then(data => {
        btn.innerText = 'Lanjut';
        btn.disabled = false;
        
        if (data.success) {
            document.getElementById('fp-step-2').classList.add('hidden');
            document.getElementById('fp-step-3').classList.remove('hidden');
        } else {
            showFpError(data.message || 'Jawaban salah.');
        }
    })
    .catch(err => {
        btn.innerText = 'Lanjut';
        btn.disabled = false;
        showFpError('Terjadi kesalahan sistem.');
    });
}

function submitFpStep3() {
    const whatsapp = document.getElementById('fp-whatsapp').value.trim();
    if (!whatsapp) {
        showFpError('Silakan masukkan nomor WhatsApp Anda.');
        return;
    }
    
    hideFpError();
    const btn = document.getElementById('btn-fp-3');
    btn.innerText = 'Memproses...';
    btn.disabled = true;

    fetch('{{ route("forgot-password.reset") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ email: forgotPasswordEmail, whatsapp: whatsapp })
    })
    .then(response => response.json())
    .then(data => {
        btn.innerText = 'Reset Password';
        btn.disabled = false;
        
        if (data.success) {
            document.getElementById('fp-step-3').classList.add('hidden');
            document.getElementById('fp-step-success').classList.remove('hidden');
        } else {
            showFpError(data.message || 'Nomor WhatsApp salah.');
        }
    })
    .catch(err => {
        btn.innerText = 'Reset Password';
        btn.disabled = false;
        showFpError('Terjadi kesalahan sistem.');
    });
}

</script>

<!-- FORGOT PASSWORD MODAL -->
<div 
    id="forgotPasswordModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm px-4"
>

    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden animate-fadeIn">

        <!-- Header -->
        <div class="gradient-primary px-6 py-5 text-white relative">

            <button 
                onclick="closeForgotPasswordModal()"
                class="absolute top-4 right-4 text-white/80 hover:text-white transition"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path 
                        stroke-linecap="round" 
                        stroke-linejoin="round" 
                        stroke-width="2" 
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>

            <div class="flex items-center space-x-3">

                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path 
                            stroke-linecap="round" 
                            stroke-linejoin="round" 
                            stroke-width="2" 
                            d="M12 11c0 .552-.448 1-1 1s-1-.448-1-1 .448-1 1-1 1 .448 1 1zm0 0v2m0 4h.01M5.938 17h12.124c1.54 0 2.502-1.667 1.732-3L13.732 3c-.77-1.333-2.694-1.333-3.464 0L4.206 14c-.77 1.333.192 3 1.732 3z"
                        />
                    </svg>
                </div>

                <div>
                    <h2 class="text-xl font-bold">
                        Lupa Password?
                    </h2>

                    <p class="text-sm text-white/80">
                        Reset password akun Anda
                    </p>
                </div>

            </div>

        </div>

        <!-- Content -->
        <div class="p-6">

            <div id="fp-error-msg" class="hidden mb-4 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700"></div>

            <!-- STEP 1: Email -->
            <div id="fp-step-1">
                <p class="text-gray-600 text-sm leading-relaxed mb-5">
                    Langkah 1: Masukkan email akun Anda untuk memulai proses reset password.
                </p>
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8"/>
                            </svg>
                        </div>
                        <input 
                            id="fp-email"
                            type="email"
                            placeholder="contoh@email.com"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-deep"
                        >
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" onclick="closeForgotPasswordModal()" class="w-1/2 py-3 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-gray-100 transition">Batal</button>
                    <button type="button" id="btn-fp-1" onclick="submitFpStep1()" class="w-1/2 gradient-primary text-white py-3 rounded-xl font-semibold hover:shadow-lg transition">Lanjut</button>
                </div>
            </div>

            <!-- STEP 2: Security Question -->
            <div id="fp-step-2" class="hidden">
                <p class="text-gray-600 text-sm leading-relaxed mb-5">
                    Langkah 2: Jawab pertanyaan keamanan berikut sesuai dengan saat Anda mendaftar.
                </p>
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Pertanyaan Keamanan
                    </label>
                    <p id="fp-security-question-text" class="mb-3 font-semibold text-emerald-deep bg-emerald-50 p-3 rounded-lg"></p>
                    
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jawaban Anda
                    </label>
                    <div class="relative">
                        <input 
                            id="fp-security-answer"
                            type="text"
                            placeholder="Masukkan jawaban"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-deep"
                        >
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" onclick="resetForgotPasswordModal()" class="w-1/2 py-3 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-gray-100 transition">Kembali</button>
                    <button type="button" id="btn-fp-2" onclick="submitFpStep2()" class="w-1/2 gradient-primary text-white py-3 rounded-xl font-semibold hover:shadow-lg transition">Lanjut</button>
                </div>
            </div>

            <!-- STEP 3: WhatsApp Number -->
            <div id="fp-step-3" class="hidden">
                <p class="text-gray-600 text-sm leading-relaxed mb-5">
                    Langkah 3: Masukkan nomor WhatsApp yang terdaftar pada akun Anda.
                </p>
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor WhatsApp
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <input 
                            id="fp-whatsapp"
                            type="text"
                            placeholder="+62 812-3456-7890"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-deep"
                        >
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" onclick="document.getElementById('fp-step-3').classList.add('hidden'); document.getElementById('fp-step-2').classList.remove('hidden');" class="w-1/2 py-3 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-gray-100 transition">Kembali</button>
                    <button type="button" id="btn-fp-3" onclick="submitFpStep3()" class="w-1/2 gradient-primary text-white py-3 rounded-xl font-semibold hover:shadow-lg transition">Reset Password</button>
                </div>
            </div>

            <!-- SUCCESS MESSAGE -->
            <div id="fp-step-success" class="hidden text-center py-4">
                <div class="w-16 h-16 bg-mint-vibrant/20 text-mint-vibrant rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Password Direset</h3>
                <p class="text-gray-600 mb-6">Password Anda telah berhasil direset menjadi: <span class="font-bold text-emerald-deep">123456</span></p>
                <button type="button" onclick="closeForgotPasswordModal()" class="w-full gradient-primary text-white py-3 rounded-xl font-semibold hover:shadow-lg transition">Tutup & Login</button>
            </div>

        </div>

    </div>

</div>
</body>
</html>

    <!-- Background Decorative Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-mint-vibrant rounded-full opacity-10 blur-3xl"></div>
        <div class="absolute top-1/2 -left-40 w-80 h-80 bg-emerald-deep rounded-full opacity-10 blur-3xl"></div>
        <div class="absolute -bottom-40 right-1/4 w-80 h-80 bg-mint-vibrant rounded-full opacity-10 blur-3xl"></div>
    </div>


</body>
</html>
