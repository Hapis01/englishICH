@extends('layouts.student')

@section('title', 'Settings')
@section('page-title', 'Settings')

@section('content')
    <div x-data="{ tab: 'profile' }" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Settings Navigation -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <nav class="space-y-1">

                    <!-- Profile -->
                    <button
                        @click="tab = 'profile'"
                        :class="tab === 'profile'
                            ? 'bg-blue-600 text-white'
                            : 'text-gray-700 hover:bg-gray-50'"
                        class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg transition">

                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                            </path>
                        </svg>

                        <span class="font-medium">Profile Settings</span>
                    </button>

                    <!-- Security -->
                    <button
                        @click="tab = 'security'"
                        :class="tab === 'security'
                            ? 'bg-blue-600 text-white'
                            : 'text-gray-700 hover:bg-gray-50'"
                        class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg transition">

                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>

                        <span class="font-medium">Security</span>
                    </button>

                </nav>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Settings -->
            <div x-show="tab === 'profile'" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Profile Settings</h3>
                
                <form action="{{ route('student.settings.avatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                    @csrf
                    <div class="flex items-center space-x-6 mb-6">
                        @if($student->profile_photo)
                            <img id="photo_preview" src="{{ asset($student->profile_photo) }}" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-lg">
                        @else
                            <div id="photo_preview_container" class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                                {{ strtoupper(substr($student->name, 0, 1)) }}
                            </div>
                            <img id="photo_preview" src="" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-lg hidden">
                        @endif
                        
                        <div>
                            <input type="file" name="profile_photo" id="avatarInput" class="hidden" accept="image/*" onchange="previewImage(this); document.getElementById('avatarForm').submit()">
                            <button type="button" onclick="document.getElementById('avatarInput').click()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm">
                                Change Photo
                            </button>
                            <p class="text-xs text-gray-500 mt-2">JPG, PNG or GIF. Max size 2MB</p>
                        </div>
                    </div>
                </form>

                <form action="{{ route('student.settings.profile') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $student->name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $student->email) }}" readonly class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed text-gray-500 focus:outline-none">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp</label>
                            <input type="tel" name="whatsapp" value="{{ old('whatsapp', $student->whatsapp) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('whatsapp')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Settings -->
            <div x-show="tab === 'security'" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6" style="display: none;">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Security Settings</h3>
                <form action="{{ route('student.settings.password') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                        <input type="password" name="current_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                        <input type="password" name="new_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('new_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            Update Password
                        </button>
                    </div>
                </form>


            </div>


        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('photo_preview');
                    const container = document.getElementById('photo_preview_container');
                    
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    
                    if (container) {
                        container.classList.add('hidden');
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
