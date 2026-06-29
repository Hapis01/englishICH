<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Teacher Dashboard') - English Club ICH Medan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logoich.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .sidebar-collapsed {
            width: 80px;
        }
        .sidebar-expanded {
            width: 280px;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Notification Component -->
    <x-notification />
    
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        <!-- Mobile sidebar backdrop -->
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-gray-900 bg-opacity-50 md:hidden" @click="sidebarOpen = false" x-cloak></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar-expanded bg-gradient-to-b from-[#0B4637] to-[#064030] text-white transition-transform duration-300 flex flex-col fixed inset-y-0 left-0 z-50 md:relative transform md:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <!-- Logo Section -->
            <div class="p-6 border-b border-emerald-700">
                <div class="flex items-center justify-between">
                    <div id="logo-text" class="flex items-center space-x-3">
                        <img src="{{ asset('images/logoich.png') }}" class="w-10 h-10 object-contain rounded-lg" alt="ICH Logo">
                        <div>
                            <h1 class="font-bold text-lg">English Club</h1>
                            <p class="text-xs text-emerald-300">Teacher Portal</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('teacher.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-emerald-700 transition {{ request()->routeIs('teacher.dashboard') ? 'bg-emerald-700' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="menu-text font-medium">Dashboard</span>
                </a>

                <a href="{{ route('teacher.analytics') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-emerald-700 transition {{ request()->routeIs('teacher.analytics') ? 'bg-emerald-700' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="menu-text font-medium">Analytics</span>
                </a>

                <a href="{{ route('teacher.classes') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-emerald-700 transition {{ request()->routeIs('teacher.classes') ? 'bg-emerald-700' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span class="menu-text font-medium">My Classes</span>
                </a>

                <a href="{{ route('teacher.students.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-emerald-700 transition {{ request()->routeIs('teacher.students.*') ? 'bg-emerald-700' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="menu-text font-medium">Students</span>
                </a>

                <a href="{{ route('teacher.meetings.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-emerald-700 transition {{ request()->routeIs('teacher.meetings.*') ? 'bg-emerald-700' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    <span class="menu-text font-medium">Online Meetings</span>
                </a>

                <a href="{{ route('teacher.attendance.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-emerald-700 transition {{ request()->routeIs('teacher.attendance.*') ? 'bg-emerald-700' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    <span class="menu-text font-medium">Student Attendance</span>
                </a>

                <a href="{{ route('teacher.teacher-attendance.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-emerald-700 transition {{ request()->routeIs('teacher.teacher-attendance.*') ? 'bg-emerald-700' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="menu-text font-medium">Teacher Attendance</span>
                </a>

                <a href="{{ route('teacher.assessments.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-emerald-700 transition {{ request()->routeIs('teacher.assessments.*') ? 'bg-emerald-700' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="menu-text font-medium">Assessments</span>
                </a>

                <a href="{{ route('teacher.chat') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-emerald-700 transition {{ request()->routeIs('teacher.chat') ? 'bg-emerald-700' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <span class="menu-text font-medium">Chat</span>
                    @if(isset($unreadMessages) && $unreadMessages > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $unreadMessages }}</span>
                    @endif
                </a>

                <a href="{{ route('teacher.settings') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-emerald-700 transition {{ request()->routeIs('teacher.settings') ? 'bg-emerald-700' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="menu-text font-medium">Settings</span>
                </a>
            </nav>

            <!-- Sign Out Button -->
            <div class="p-4 border-t border-emerald-700">
                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                    @csrf
                    <button type="button" onclick="confirmLogout()" class="w-full flex items-center justify-center space-x-2 px-4 py-3 rounded-lg hover:bg-red-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span class="menu-text font-medium">Sign Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white border-b border-gray-200 px-4 md:px-8 py-4">
                <div class="flex items-center justify-between">
                    <!-- Mobile Hamburger -->
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden mr-3 text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <!-- Page Title -->
                    <div class="flex-1 min-w-0">
                        <h2 class="text-xl md:text-2xl font-bold text-gray-800 truncate">@yield('page-title', 'Dashboard')</h2>
                        <p class="text-xs md:text-sm text-gray-500 truncate">@yield('page-subtitle', 'Welcome back, Teacher')</p>
                    </div>

                    <!-- Right Section: Notifications & Profile -->
                    <div class="flex items-center space-x-2 md:space-x-6 ml-4">
                        <!-- Date & Time -->
                        <span class="text-sm text-gray-600 hidden md:block">{{ now()->format('l, F d, Y H:i') }} WIB</span>

                        <!-- Notifications Dropdown -->
                        <x-dashboard-notifications :notifications="$dashboardNotifications ?? collect()" />

                        <!-- Profile Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-3 p-2 hover:bg-gray-100 rounded-lg transition">
                                <div class="w-10 h-10 bg-[#10B981] rounded-full flex items-center justify-center text-white font-semibold overflow-hidden">
                                    @if(Auth::user()->profile_photo)
                                        <img src="{{ asset(Str::startsWith(Auth::user()->profile_photo, 'profile/') ? Auth::user()->profile_photo : 'profile/' . Auth::user()->profile_photo) }}" alt="Profile" class="w-full h-full object-cover">
                                    @else
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    @endif
                                </div>
                                <div class="text-left hidden md:block">
                                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">Teacher</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Profile Dropdown Menu -->
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 z-50"
                                 style="display: none;">
                                
                                <a href="{{ route('teacher.settings') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>My Profile</span>
                                    </div>
                                </a>
                                <a href="{{ route('teacher.settings') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>Settings</span>
                                    </div>
                                </a>
                                <div class="border-t border-gray-200"></div>
                                <button onclick="confirmLogout()" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-gray-50">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        <span>Sign Out</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-4 md:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Logout confirmation
        function confirmLogout() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out from your account",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0B4637',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, logout',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        }

        // Show success/error messages
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#10B981',
                timer: 3000
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#EF4444',
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: '<ul class="text-left">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                confirmButtonColor: '#EF4444',
            });
        @endif
    </script>

    @stack('scripts')
</body>
</html>
