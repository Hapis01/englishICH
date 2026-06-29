<?php
if (session()->has('locale')) {
    app()->setLocale(session('locale'));
}
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>English Club ICH Medan - {{ __('landing.hero.badge') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logoich.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
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
        html {
            scroll-behavior: smooth;
        }

        @keyframes floatSoft {
            0%, 100% {
                transform: translate3d(0, 0, 0) scale(1);
            }

            50% {
                transform: translate3d(0, -18px, 0) scale(1.04);
            }
        }

        @keyframes pulseGlow {
            0%, 100% {
                opacity: .28;
                transform: scale(1);
            }

            50% {
                opacity: .5;
                transform: scale(1.12);
            }
        }

        .decor-blob {
            position: absolute;
            border-radius: 9999px;
            filter: blur(42px);
            pointer-events: none;
            animation: floatSoft 7s ease-in-out infinite;
        }

        .decor-grid {
            position: absolute;
            inset: 0;
            pointer-events: none;
            background-image: radial-gradient(rgba(16, 185, 129, .16) 1px, transparent 1px);
            background-size: 28px 28px;
            mask-image: linear-gradient(to bottom, black, transparent 75%);
        }

        .reveal {
            opacity: 0;
            transform: translateY(32px) scale(.98);
            transition: opacity .75s ease, transform .75s ease;
            transition-delay: var(--delay, 0ms);
            will-change: opacity, transform;
        }

        .reveal.reveal-visible {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .hover-lift {
            transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease;
        }

        .hover-lift:hover {
            transform: translateY(-10px);
            box-shadow: 0 24px 60px rgba(11, 70, 55, .16);
            border-color: rgba(16, 185, 129, .35);
        }

        .shine-card {
            position: relative;
            overflow: hidden;
        }

        .shine-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -120%;
            width: 70%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255,255,255,.28), transparent);
            transform: skewX(-18deg);
            transition: left .8s ease;
        }

        .shine-card:hover::before {
            left: 130%;
        }

        .glow-orb {
            animation: pulseGlow 5s ease-in-out infinite;
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            .decor-blob,
            .glow-orb,
            .reveal {
                animation: none;
                transition: none;
            }

            .reveal {
                opacity: 1;
                transform: none;
            }
        }

        @media (max-width:768px){
            .mobile-card-track::-webkit-scrollbar,
            .no-scrollbar::-webkit-scrollbar{
                display:none;
            }

            .mobile-card-track,
            .no-scrollbar{
                scrollbar-width:none;
                -ms-overflow-style:none;
            }
        }
        .gradient-primary {
            background: linear-gradient(135deg, #0B4637 0%, #10B981 100%);
        }
        .gradient-text {
            background: linear-gradient(135deg, #0B4637 0%, #10B981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .mobile-card-track {
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }
    </style>
</head>
<body class="font-sans antialiased bg-white text-slate-800">

    <!-- Sticky Navbar -->
     
    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn"
        class="relative z-[9999] md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors duration-300 order-1">
                    <svg class="w-7 h-7 text-gray-700 scale-x-[-1]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M8 12h12M12 18h8"></path>
                    </svg>
                </button>
                <!-- Logo -->
                <div class="flex items-center space-x-3 order-2 md:order-1">
                    <img src="{{ asset('images/logoich.png') }}" class="w-12 h-12 object-contain" alt="ICH Logo">
                    <div>
                        <h1 class="font-bold text-lg text-emerald-deep">English Club ICH</h1>
                        <p class="text-xs text-gray-500">Medan</p>
                    </div>
                </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-6 order-2">

                <a href="#home" class="text-gray-700 hover:text-emerald-deep transition-colors duration-300 font-medium">{{ __('landing.nav.home') }}</a>
                <a href="#about" class="text-gray-700 hover:text-emerald-deep transition-colors duration-300 font-medium">{{ __('landing.nav.about') }}</a>
                <a href="#facilities" class="text-gray-700 hover:text-emerald-deep transition-colors duration-300 font-medium">{{ __('landing.nav.facilities') }}</a>
                <a href="#tutors" class="text-gray-700 hover:text-emerald-deep transition-colors duration-300 font-medium">{{ __('landing.nav.tutors') }}</a>
                <a href="#pricing" class="text-gray-700 hover:text-emerald-deep transition-colors duration-300 font-medium">{{ __('landing.nav.pricing') }}</a>
                <a href="{{ route('login') }}" class="gradient-primary text-white px-5 py-2.5 rounded-full font-semibold shadow-md hover:shadow-lg transition-all duration-300">Login</a>

                <!-- Language Switcher -->
                <div class="flex items-center border-l border-gray-200 pl-6">

                    <div class="bg-white border border-gray-200 rounded-full p-1 flex items-center shadow-sm">

                        <a href="{{ route('locale.switch', 'id') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-300
                        {{ app()->getLocale() == 'id'
                        ? 'bg-white shadow text-emerald-deep'
                        : 'text-gray-600 hover:text-emerald-deep' }}">

                            <img src="https://flagcdn.com/w20/id.png" class="w-6 h-4 rounded-sm object-cover">
                            <span>ID</span>
                        </a>

                        <a href="{{ route('locale.switch', 'en') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-300
                        {{ app()->getLocale() == 'en'
                        ? 'bg-white shadow text-emerald-deep'
                        : 'text-gray-600 hover:text-emerald-deep' }}">

                            <img src="https://flagcdn.com/w20/gb.png" class="w-6 h-4 rounded-sm object-cover">
                            <span>EN</span>

                        </a>

                    </div>

                </div>

            </div>

                <div class="w-11 md:hidden order-3"></div>
            </div>
        </div>
        
        <!-- Mobile Menu Dropdown -->
        <div id="mobileMenu"
     class="hidden md:hidden absolute top-full left-0 w-full bg-white border-t border-gray-100 shadow-xl rounded-b-3xl z-[9998]">
            <div class="px-4 py-4 space-y-3">
                <a href="#home" class="block py-2 text-gray-700 hover:text-emerald-deep font-medium">{{ __('landing.nav.home') }}</a>
                <a href="#about" class="block py-2 text-gray-700 hover:text-emerald-deep font-medium">{{ __('landing.nav.about') }}</a>
                <a href="#facilities" class="block py-2 text-gray-700 hover:text-emerald-deep font-medium">{{ __('landing.nav.facilities') }}</a>
                <a href="#tutors" class="block py-2 text-gray-700 hover:text-emerald-deep font-medium">{{ __('landing.nav.tutors') }}</a>
                <a href="#pricing" class="block py-2 text-gray-700 hover:text-emerald-deep font-medium">{{ __('landing.nav.pricing') }}</a>
                <div class="pt-2">
                    <a href="{{ route('login') }}" class="block gradient-primary text-white px-6 py-3 rounded-xl font-semibold text-center">
                        Login
                    </a>
                </div>
                <!-- Language Switcher Mobile -->
                <div class="pt-4 border-t border-gray-200">

    <p class="text-sm text-gray-500 mb-3">
        Language
    </p>

    <div class="grid grid-cols-2 gap-3">

        <a href="{{ route('locale.switch', 'id') }}"
           class="flex items-center justify-center gap-2 py-3 rounded-xl border transition-all duration-300
           {{ app()->getLocale() == 'id'
           ? 'bg-emerald-50 border-emerald-500 text-emerald-700'
           : 'bg-white border-gray-200 text-gray-600' }}">

            <img src="https://flagcdn.com/w20/id.png"
                 class="w-6 h-4 rounded-sm object-cover">

            <span class="font-medium">
                Indonesia
            </span>

        </a>

        <a href="{{ route('locale.switch', 'en') }}"
           class="flex items-center justify-center gap-2 py-3 rounded-xl border transition-all duration-300
           {{ app()->getLocale() == 'en'
           ? 'bg-emerald-50 border-emerald-500 text-emerald-700'
           : 'bg-white border-gray-200 text-gray-600' }}">

            <img src="https://flagcdn.com/w20/gb.png"
                 class="w-6 h-4 rounded-sm object-cover">

            <span class="font-medium">
                English
            </span>

        </a>

    </div>

</div>
                
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="relative overflow-hidden bg-gradient-to-br from-slate-50 via-white to-emerald-50 pt-6 py-10 lg:py-20">
        <div class="decor-grid"></div>
        <div class="decor-blob glow-orb w-72 h-72 bg-emerald-200/70 -top-24 -left-20"></div>
        <div class="decor-blob w-96 h-96 bg-mint-vibrant/20 bottom-0 right-0" style="animation-delay: 1.2s;"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="space-y-8 order-2 lg:order-1 relative z-10">
                    <div class="inline-block reveal">
                        <span class="gradient-primary text-white px-4 py-2 rounded-full text-sm font-semibold">
                            {{ __('landing.hero.badge') }}
                        </span>
                    </div>
                    
                    <h1 class="reveal text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight" style="--delay: 100ms;">
                        {{ __('landing.hero.title') }}
                        <span class="gradient-text block mt-2">{{ __('landing.hero.title_highlight') }}</span>
                    </h1>
                    
                    <p class="reveal text-lg text-gray-600 leading-relaxed" style="--delay: 200ms;">
                        {{ __('landing.hero.description') }}
                    </p>
                    <div class="lg:hidden mt-6 reveal" style="--delay: 300ms;">
                        <div class="relative rounded-3xl overflow-hidden shadow-xl">

                <div id="heroSliderMobile"
     class="relative aspect-[16/10] rounded-2xl overflow-hidden">

                    <img src="{{ asset('images/slides/slide1.jpg') }}"
                        class="mobile-slider absolute inset-0 w-full h-full object-cover">

                    <img src="{{ asset('images/slides/slide2.jpg') }}"
                        class="mobile-slider absolute inset-0 w-full h-full object-cover hidden">

                </div>

            </div>
        </div>

                    <!-- Countdown Timer -->
                    <div class="reveal bg-white/90 backdrop-blur rounded-2xl shadow-xl p-6 border border-emerald-100" style="--delay: 350ms;">
                        <p class="text-sm font-semibold text-gray-500 mb-4 text-center">{{ __('landing.hero.countdown_title') }}</p>
                        <div class="grid grid-cols-4 gap-2 sm:gap-4 text-center">
                            <div>
                                <div class="text-2xl sm:text-3xl font-bold gradient-text" id="days">15</div>
                                <div class="text-xs text-gray-500 mt-1">{{ __('landing.hero.days') }}</div>
                            </div>
                            <div>
                                <div class="text-2xl sm:text-3xl font-bold gradient-text" id="hours">08</div>
                                <div class="text-xs text-gray-500 mt-1">{{ __('landing.hero.hours') }}</div>
                            </div>
                            <div>
                                <div class="text-2xl sm:text-3xl font-bold gradient-text" id="minutes">32</div>
                                <div class="text-xs text-gray-500 mt-1">{{ __('landing.hero.minutes') }}</div>
                            </div>
                            <div>
                                <div class="text-2xl sm:text-3xl font-bold gradient-text" id="seconds">45</div>
                                <div class="text-xs text-gray-500 mt-1">{{ __('landing.hero.seconds') }}</div>
                            </div>
                        </div>
                    </div>


                </div>
                
                

                <!-- Right Content - Image/Video Placeholder -->
                <div class="hidden lg:block relative order-1 lg:order-2 reveal" style="--delay: 250ms;">
                    <div class="relative rounded-[2rem] overflow-hidden shadow-2xl ring-1 ring-emerald-100 scale-105 xl:scale-110">

    <div id="heroSlider" class="relative aspect-[4/3] xl:aspect-[19/10] rounded-2xl">

        <img src="{{ asset('images/slides/slide1.jpg') }}"
             class="slider-image absolute inset-0 w-full h-full object-cover">

        <img src="{{ asset('images/slides/slide2.jpg') }}"
             class="slider-image absolute inset-0 w-full h-full object-cover hidden">

    </div>

    <!-- Prev -->
    <button id="prevSlide"
        class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 backdrop-blur rounded-full p-3 shadow-lg hover:bg-white">
        ❮
    </button>

    <!-- Next -->
    <button id="nextSlide"
        class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 backdrop-blur rounded-full p-3 shadow-lg hover:bg-white">
        ❯
    </button>

    <!-- Dots -->
    <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex gap-2">
        <span class="dot w-3 h-3 rounded-full bg-white"></span>
        <span class="dot w-3 h-3 rounded-full bg-white/50"></span>
    </div>

</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission Section -->
    <section id="about" class="relative py-20 bg-white overflow-hidden">
        <div class="decor-blob w-72 h-72 bg-emerald-100/80 top-16 right-0"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <h2 class="text-2xl sm:text-4xl font-bold mb-4">
                    {{ __('landing.about.title') }} <span class="gradient-text">{{ __('landing.about.title_highlight') }}</span>
                </h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    {{ __('landing.about.subtitle') }}
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 relative z-10">
                <!-- Vision Card -->
                <div class="reveal hover-lift shine-card bg-gradient-to-br from-emerald-50 to-white rounded-2xl p-8 border border-emerald-100" style="--delay: 100ms;">
                    <div class="w-16 h-16 gradient-primary rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-emerald-deep">{{ __('landing.about.vision_title') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ __('landing.about.vision_text') }}
                    </p>
                </div>

                <!-- Mission Card -->
                <div class="reveal hover-lift shine-card bg-gradient-to-br from-mint-50 to-white rounded-2xl p-8 border border-emerald-100" style="--delay: 220ms;">
                    <div class="w-16 h-16 gradient-primary rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-emerald-deep">{{ __('landing.about.mission_title') }}</h3>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-start">
                            <span class="text-mint-vibrant mr-2">✓</span>
                            <span>{{ __('landing.about.mission_1') }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-mint-vibrant mr-2">✓</span>
                            <span>{{ __('landing.about.mission_2') }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-mint-vibrant mr-2">✓</span>
                            <span>{{ __('landing.about.mission_3') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Facilities Section -->
    <section id="facilities" class="relative py-20 bg-slate-50 overflow-hidden">
        <div class="decor-grid opacity-60"></div>
        <div class="decor-blob w-80 h-80 bg-mint-vibrant/20 -left-24 top-40"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <h2 class="text-2xl sm:text-4xl font-bold mb-4">
                    {{ __('landing.facilities.title') }} <span class="gradient-text">{{ __('landing.facilities.title_highlight') }}</span>
                </h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    {{ __('landing.facilities.subtitle') }}
                </p>
            </div>

            <div class="relative z-10 reveal" style="--delay: 100ms;">
                <button type="button" data-slider-prev="facilitiesSlider" class="md:hidden absolute left-0 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white shadow-lg text-emerald-deep font-bold">‹</button>
                <button type="button" data-slider-next="facilitiesSlider" class="md:hidden absolute right-0 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white shadow-lg text-emerald-deep font-bold">›</button>
            <div id="facilitiesSlider" class="mobile-card-track flex md:grid md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar px-1 md:px-0 pb-4 md:pb-0">
                <!-- Facility 1 -->
                <div class="min-w-[86%] sm:min-w-[70%] md:min-w-0 snap-center bg-white rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="w-14 h-14 gradient-primary rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-emerald-deep">{{ __('landing.facilities.modern_classrooms') }}</h3>
                    <p class="text-gray-600">
                        {{ __('landing.facilities.modern_classrooms_desc') }}
                    </p>
                </div>

                <!-- Facility 2 -->
                <div class="min-w-[86%] sm:min-w-[70%] md:min-w-0 snap-center bg-white rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="w-14 h-14 gradient-primary rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-emerald-deep">{{ __('landing.facilities.digital_learning') }}</h3>
                    <p class="text-gray-600">
                        {{ __('landing.facilities.digital_learning_desc') }}
                    </p>
                </div>

                <!-- Facility 3 -->
                <div class="min-w-[86%] sm:min-w-[70%] md:min-w-0 snap-center bg-white rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="w-14 h-14 gradient-primary rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-emerald-deep">{{ __('landing.facilities.expert_tutors') }}</h3>
                    <p class="text-gray-600">
                        {{ __('landing.facilities.expert_tutors_desc') }}
                    </p>
                </div>

                <!-- Facility 4 -->
                <div class="min-w-[86%] sm:min-w-[70%] md:min-w-0 snap-center bg-white rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="w-14 h-14 gradient-primary rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-emerald-deep">{{ __('landing.facilities.interactive_learning') }}</h3>
                    <p class="text-gray-600">
                        {{ __('landing.facilities.interactive_learning_desc') }}
                    </p>
                </div>

                <!-- Facility 5 -->
                <div class="min-w-[86%] sm:min-w-[70%] md:min-w-0 snap-center bg-white rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="w-14 h-14 gradient-primary rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-emerald-deep">{{ __('landing.facilities.flexible_schedule') }}</h3>
                    <p class="text-gray-600">
                        {{ __('landing.facilities.flexible_schedule_desc') }}
                    </p>
                </div>

                <!-- Facility 6 -->
                <div class="min-w-[86%] sm:min-w-[70%] md:min-w-0 snap-center bg-white rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="w-14 h-14 gradient-primary rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-emerald-deep">{{ __('landing.facilities.certified_programs') }}</h3>
                    <p class="text-gray-600">
                        {{ __('landing.facilities.certified_programs_desc') }}
                    </p>
                </div>
            </div>
            </div>
        </div>
    </section>

    <!-- Tutors Section -->
    <section id="tutors" class="relative py-20 bg-white overflow-hidden">
        <div class="decor-blob w-72 h-72 bg-emerald-100/70 right-10 top-24"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <h2 class="text-2xl sm:text-4xl font-bold mb-4">
                    {{ __('landing.tutors.title') }} <span class="gradient-text">{{ __('landing.tutors.title_highlight') }}</span>
                </h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    {{ __('landing.tutors.subtitle') }}
                </p>
            </div>

            <div class="relative z-10 reveal" style="--delay: 100ms;">
                <button type="button" data-slider-prev="tutorsSlider" class="md:hidden absolute left-0 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white shadow-lg text-emerald-deep font-bold">‹</button>
                <button type="button" data-slider-next="tutorsSlider" class="md:hidden absolute right-0 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white shadow-lg text-emerald-deep font-bold">›</button>
            <div id="tutorsSlider" class="mobile-card-track flex md:grid md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar px-1 md:px-0 pb-4 md:pb-0">
                <!-- Tutor 1 -->
                <div class="group min-w-[86%] sm:min-w-[70%] md:min-w-0 snap-center">
                    <div class="bg-gradient-to-br from-emerald-50 to-white rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-emerald-100">
                        <div class="aspect-square rounded-2xl mb-4 overflow-hidden">
                            <img src="{{ asset('images/teacherlanding/teacher1.jpg') }}" alt="Tutor" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-xl font-bold text-emerald-deep mb-1">{{ __('landing.tutors.tutor_1_name') }}</h3>
                        <p class="text-sm text-mint-vibrant font-semibold mb-2">{{ __('landing.tutors.tutor_1_role') }}</p>
                        <p class="text-gray-600 text-sm">
                            {{ __('landing.tutors.tutor_1_desc') }}
                        </p>
                    </div>
                </div>

                <!-- Tutor 2 -->
                <div class="group min-w-[86%] sm:min-w-[70%] md:min-w-0 snap-center">
                    <div class="bg-gradient-to-br from-emerald-50 to-white rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-emerald-100">
                        <div class="aspect-square rounded-2xl mb-4 overflow-hidden">
                            <img src="{{ asset('images/teacherlanding/teacher2.jpg') }}" alt="Tutor" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-xl font-bold text-emerald-deep mb-1">{{ __('landing.tutors.tutor_2_name') }}</h3>
                        <p class="text-sm text-mint-vibrant font-semibold mb-2">{{ __('landing.tutors.tutor_2_role') }}</p>
                        <p class="text-gray-600 text-sm">
                            {{ __('landing.tutors.tutor_2_desc') }}
                        </p>
                    </div>
                </div>

                <!-- Tutor 3 -->
                <div class="group min-w-[86%] sm:min-w-[70%] md:min-w-0 snap-center">
                    <div class="bg-gradient-to-br from-emerald-50 to-white rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-emerald-100">
                        <div class="aspect-square rounded-2xl mb-4 overflow-hidden">
                            <img src="{{ asset('images/teacherlanding/teacher4.jpg') }}" alt="Tutor" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-xl font-bold text-emerald-deep mb-1">{{ __('landing.tutors.tutor_3_name') }}</h3>
                        <p class="text-sm text-mint-vibrant font-semibold mb-2">{{ __('landing.tutors.tutor_3_role') }}</p>
                        <p class="text-gray-600 text-sm">
                            {{ __('landing.tutors.tutor_3_desc') }}
                        </p>
                    </div>
                </div>

                <!-- Tutor 4 -->
                <div class="group min-w-[86%] sm:min-w-[70%] md:min-w-0 snap-center">
                    <div class="bg-gradient-to-br from-emerald-50 to-white rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-emerald-100">
                        <div class="aspect-square rounded-2xl mb-4 overflow-hidden">
                            <img src="{{ asset('images/teacherlanding/teacher3.jpg') }}" alt="Tutor" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-xl font-bold text-emerald-deep mb-1">{{ __('landing.tutors.tutor_4_name') }}</h3>
                        <p class="text-sm text-mint-vibrant font-semibold mb-2">{{ __('landing.tutors.tutor_4_role') }}</p>
                        <p class="text-gray-600 text-sm">
                            {{ __('landing.tutors.tutor_4_desc') }}
                        </p>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="relative py-20 bg-slate-50 overflow-hidden">
        <div class="decor-grid opacity-50"></div>
        <div class="decor-blob w-96 h-96 bg-emerald-200/60 -right-32 top-28"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <h2 class="text-2xl sm:text-4xl font-bold mb-4">
                    {{ __('landing.pricing.title') }} <span class="gradient-text">{{ __('landing.pricing.title_highlight') }}</span>
                </h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    {{ __('landing.pricing.subtitle') }}
                </p>
            </div>

            <div class="relative z-10 reveal" style="--delay: 100ms;">
                <button type="button" data-slider-prev="pricingSlider" class="md:hidden absolute left-0 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white shadow-lg text-emerald-deep font-bold">‹</button>
                <button type="button" data-slider-next="pricingSlider" class="md:hidden absolute right-0 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white shadow-lg text-emerald-deep font-bold">›</button>

                <div id="pricingSlider" class="flex md:grid md:grid-cols-3 gap-6 md:gap-8 overflow-x-auto md:overflow-visible snap-x snap-mandatory scroll-smooth pb-8 pt-4 px-4 -mx-4 md:px-0 md:mx-0 no-scrollbar">
                    
                    @forelse($courses as $course)
                        @if($course->is_featured)
                            <!-- Premium/Featured Plan -->
                            <div class="min-w-[85%] sm:min-w-[70%] md:min-w-0 snap-center">
                                <div class="bg-gradient-to-br from-emerald-deep to-mint-vibrant rounded-3xl p-8 text-white relative shadow-2xl transform md:scale-105 h-full flex flex-col z-10 border border-emerald-500/30">
                                    <div class="absolute -top-4 inset-x-0 flex justify-center">
                                        <span class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-yellow-900 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider shadow-lg">
                                            Paling Populer
                                        </span>
                                    </div>
                                    <div class="text-center mb-6 pt-4">
                                        <h3 class="text-2xl font-bold mb-2">{{ $course->name }}</h3>
                                        <p class="text-emerald-100 text-sm mb-3">{{ $course->subtitle ?? 'Tingkatkan kemampuan bahasa Inggris Anda' }}</p>
                                        @if($course->suitable_for)
                                        <div class="inline-block bg-white/20 px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm shadow-sm mb-4">
                                            {{ $course->suitable_for }}
                                        </div>
                                        @endif
                                        @if($course->description)
                                        <div class="bg-black/10 rounded-xl p-3 mb-2 border border-white/10 backdrop-blur-sm">
                                            <p class="text-emerald-50 text-sm italic leading-relaxed line-clamp-3">"{{ $course->description }}"</p>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="text-center mb-6">
                                        @if($course->original_price)
                                        <div class="text-emerald-200/80 line-through text-sm sm:text-base font-medium mb-1">Rp {{ number_format($course->original_price, 0, ',', '.') }}</div>
                                        @endif
                                        <div class="flex justify-center items-start mt-1">
                                            <span class="text-lg font-semibold text-emerald-200 mt-1 mr-1">Rp</span>
                                            <span class="text-3xl sm:text-4xl font-extrabold tracking-tighter drop-shadow-sm">{{ number_format($course->price, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="text-emerald-100/90 mt-2 text-sm font-medium">Selama {{ $course->duration }} Bulan</div>
                                    </div>
                                    <ul class="space-y-4 mb-8 flex-1 text-sm">
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
                                    <a href="{{ route('student.select.class') }}" class="block text-center w-full bg-white text-emerald-deep py-3 rounded-xl font-semibold hover:bg-emerald-50 transition-all duration-300 mt-auto shadow-lg">
                                        Pilih {{ $course->name }}
                                    </a>
                                </div>
                            </div>
                        @else
                            <!-- Basic/Normal Plan -->
                            <div class="min-w-[85%] sm:min-w-[70%] md:min-w-0 snap-center">
                                <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100 hover:border-mint-vibrant/30 hover:shadow-2xl transition-all duration-300 h-full flex flex-col mt-4 md:mt-0">
                                    <div class="text-center mb-6">
                                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $course->name }}</h3>
                                        <p class="text-gray-500 text-sm mb-3">{{ $course->subtitle ?? 'Pilihan terbaik untuk Anda' }}</p>
                                        @if($course->suitable_for)
                                        <div class="inline-block bg-emerald-50 text-mint-vibrant px-3 py-1 rounded-full text-xs font-semibold shadow-sm mb-4">
                                            {{ $course->suitable_for }}
                                        </div>
                                        @endif
                                        @if($course->description)
                                        <div class="bg-gray-50/80 rounded-xl p-3 mb-2 border border-gray-100">
                                            <p class="text-gray-500 text-sm italic leading-relaxed line-clamp-3">"{{ $course->description }}"</p>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="text-center mb-6">
                                        @if($course->original_price)
                                        <div class="text-gray-400/80 line-through text-sm sm:text-base font-medium mb-1">Rp {{ number_format($course->original_price, 0, ',', '.') }}</div>
                                        @endif
                                        <div class="flex justify-center items-start mt-1">
                                            <span class="text-lg font-semibold text-gray-400 mt-1 mr-1">Rp</span>
                                            <span class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tighter">{{ number_format($course->price, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="text-gray-500 mt-2 text-sm font-medium">Selama {{ $course->duration }} Bulan</div>
                                    </div>
                                    <ul class="space-y-4 mb-8 flex-1 text-sm">
                                        @if($course->features && is_array($course->features))
                                            @foreach($course->features as $feature)
                                            <li class="flex items-start">
                                                <svg class="w-5 h-5 text-mint-vibrant mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                <span class="text-gray-600">{{ $feature }}</span>
                                            </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    <a href="{{ route('student.select.class') }}" class="block text-center w-full bg-emerald-50 text-mint-vibrant py-3 rounded-xl font-semibold hover:bg-mint-vibrant hover:text-white transition-all duration-300 mt-auto">
                                        Pilih {{ $course->name }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="col-span-3 text-center py-10">
                            <p class="text-gray-500">Belum ada paket kelas tersedia.</p>
                        </div>
                    @endforelse

                </div>
            </div>

        </div>
        <!-- Mobile Slider Dots -->
<div class="flex md:hidden justify-center gap-2 mt-6">
    <span class="w-2.5 h-2.5 rounded-full bg-emerald-700"></span>
    <span class="w-2.5 h-2.5 rounded-full bg-gray-300"></span>
    <span class="w-2.5 h-2.5 rounded-full bg-gray-300"></span>
</div>
    </section>


    <!-- Footer -->
    <footer class="bg-slate-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <!-- Company Info -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="{{ asset('images/logoich.png') }}" class="w-12 h-12 object-contain" alt="ICH Logo">
                        <div>
                            <h3 class="font-bold text-lg">English Club ICH</h3>
                            <p class="text-sm text-gray-400">Medan</p>
                        </div>
                    </div>
                    <p class="text-gray-400 mb-4 max-w-md">
                        Empowering individuals with world-class English communication skills since 2024.English Club ICH Medan is an English learning platform focused on interactive, modern, and comfortable learning experiences for students. Your gateway to global opportunities.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center hover:bg-emerald-600 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center hover:bg-emerald-600 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center hover:bg-emerald-600 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center hover:bg-emerald-600 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-gray-400 hover:text-mint-vibrant transition-colors duration-300">Home</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-mint-vibrant transition-colors duration-300">About Us</a></li>
                        <li><a href="#facilities" class="text-gray-400 hover:text-mint-vibrant transition-colors duration-300">Facilities</a></li>
                        <li><a href="#tutors" class="text-gray-400 hover:text-mint-vibrant transition-colors duration-300">Our Tutors</a></li>
                        <li><a href="#pricing" class="text-gray-400 hover:text-mint-vibrant transition-colors duration-300">Pricing</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Contact Us</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-mint-vibrant mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Jl. Datuk Kabu Gg. Ridho No. 11 E Deli Serdang</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-mint-vibrant mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>+62 812-3456-7890</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-mint-vibrant mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>ichenglish@gmail.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-slate-800 pt-8 text-center text-gray-400">
                <p>&copy; 2026 English Club ICH Medan. All rights reserved.</p>
            </div>
        </div>
    </footer>
<!-- Floating WhatsApp CS -->
<a href="https://wa.me/6281234567890"
   target="_blank"
   class="fixed bottom-5 left-5 z-50 group">

    <div class="flex items-center space-x-3 bg-[#25D366] hover:bg-[#20ba5a] text-white px-4 py-2 rounded-full shadow-2xl transition-all duration-300 hover:scale-105">

        <!-- WhatsApp Icon -->
        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/>
        </svg>

        <!-- Text -->
        <div class="hidden sm:block">
            <p class="text-sm font-bold leading-none">Need Help?</p>
            <p class="text-xs opacity-90">Chat with Us</p>
        </div>
    </div>
</a>
    <!-- Scroll to Top Button -->
    <button id="scrollTop" class="fixed bottom-8 right-8 w-12 h-12 gradient-primary rounded-full shadow-lg flex items-center justify-center text-white opacity-0 pointer-events-none transition-all duration-300 hover:scale-110">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>

    <script>
        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Scroll to top button
        const scrollTopBtn = document.getElementById('scrollTop');
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollTopBtn.classList.remove('opacity-0', 'pointer-events-none');
            } else {
                scrollTopBtn.classList.add('opacity-0', 'pointer-events-none');
            }
        });

        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Reveal animation on scroll
        const revealElements = document.querySelectorAll('.reveal');

        if ('IntersectionObserver' in window) {
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('reveal-visible');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.16,
                rootMargin: '0px 0px -60px 0px'
            });

            revealElements.forEach((element) => revealObserver.observe(element));
        } else {
            revealElements.forEach((element) => element.classList.add('reveal-visible'));
        }

        // Simple countdown timer (demo)
        function updateCountdown() {
            // Set target date (e.g., 10 days from now, setting it statically to 2026-06-29)
            const targetDate = new Date('2026-07-24T23:59:59').getTime();
            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance < 0) {
                document.getElementById('days').innerText = "00";
                document.getElementById('hours').innerText = "00";
                document.getElementById('minutes').innerText = "00";
                document.getElementById('seconds').innerText = "00";
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if (document.getElementById('days')) {
                document.getElementById('days').innerText = String(days).padStart(2, '0');
                document.getElementById('hours').innerText = String(hours).padStart(2, '0');
                document.getElementById('minutes').innerText = String(minutes).padStart(2, '0');
                document.getElementById('seconds').innerText = String(seconds).padStart(2, '0');
            }
        }
        setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>
<!-- Advertisement Modal -->
<div id="adsModal"
     class="fixed inset-0 bg-black/70 backdrop-blur-sm z-[9999] flex items-center justify-center p-4">

<div id="popupContent"
     class="bg-white rounded-3xl overflow-hidden shadow-2xl max-w-lg w-full relative">
        <button
type="button"
id="closeAds"
class="absolute top-3 right-3 bg-white rounded-full p-2 shadow z-50 cursor-pointer">
            ✕
        </button>

    <img src="{{ asset('images/ads.png') }}"
     class="w-full h-auto">

        <div class="p-6 text-center">

            <h2 class="text-2xl font-bold text-emerald-deep mb-2">
                Batch 1 Registration Open
            </h2>

            <p class="text-gray-600 mb-5">
                Limited Seats Available
            </p>

            <a href="{{ route('register') }}"
               class="gradient-primary text-white px-6 py-3 rounded-xl font-semibold inline-block">
                Register Now
            </a>

        </div>

    </div>

</div>
<script>

document.addEventListener('DOMContentLoaded', function() {

    /* ==========================
       HERO SLIDER
    ========================== */

    const slides = document.querySelectorAll('.slider-image');
const dots = document.querySelectorAll('.dot');

let currentSlide = 0;
showSlide(0);

function showSlide(index){

    slides.forEach(slide=>{
        slide.classList.add('hidden');
    });

    dots.forEach(dot=>{
        dot.classList.remove('bg-white');
        dot.classList.add('bg-white/50');
    });

    slides[index].classList.remove('hidden');

    dots[index].classList.remove('bg-white/50');
    dots[index].classList.add('bg-white');
}

document.getElementById('nextSlide').addEventListener('click',()=>{

    currentSlide++;

    if(currentSlide >= slides.length){
        currentSlide = 0;
    }

    showSlide(currentSlide);
});

document.getElementById('prevSlide').addEventListener('click',()=>{

    currentSlide--;

    if(currentSlide < 0){
        currentSlide = slides.length - 1;
    }

    showSlide(currentSlide);
});

setInterval(()=>{

    currentSlide++;

    if(currentSlide >= slides.length){
        currentSlide = 0;
    }

    showSlide(currentSlide);

},5000);

    /* ==========================
       ADS POPUP
    ========================== */

    const adsModal = document.getElementById('adsModal');
    const closeAds = document.getElementById('closeAds');

    if(adsModal && closeAds){

        closeAds.addEventListener('click', function(){

            adsModal.classList.add('hidden');

        });

        adsModal.addEventListener('click', function(e){

            if(e.target === adsModal){
                adsModal.classList.add('hidden');
            }

        });

        document.addEventListener('keydown', function(e){

            if(e.key === 'Escape'){
                adsModal.classList.add('hidden');
            }

        });

    }

});

</script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    const mobileBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    if (mobileBtn && mobileMenu) {

        mobileBtn.addEventListener('click', function() {

            mobileMenu.classList.toggle('hidden');

        });

    }

});
</script>
<style>
.no-scrollbar::-webkit-scrollbar{
    display:none;
}

.no-scrollbar{
    -ms-overflow-style:none;
    scrollbar-width:none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('[data-slider-prev], [data-slider-next]').forEach((button) => {
        button.addEventListener('click', function () {
            const sliderId = this.dataset.sliderPrev || this.dataset.sliderNext;
            const slider = document.getElementById(sliderId);

            if (!slider) return;

            const direction = this.dataset.sliderNext ? 1 : -1;
            const card = slider.querySelector('.snap-center');
            const distance = card ? card.offsetWidth + 24 : slider.offsetWidth * 0.9;

            slider.scrollBy({
                left: direction * distance,
                behavior: 'smooth'
            });
        });
    });

    if(window.innerWidth >= 768) return;

    const slider = document.getElementById('pricingSlider');

    if(!slider) return;

    let current = 0;

    setInterval(() => {

        const cards = slider.children.length;

        current++;

        if(current >= cards){
            current = 0;
        }

        slider.scrollTo({
            left: current * slider.offsetWidth,
            behavior: 'smooth'
        });

    }, 3500);

});
</script>
</body>
</html>
