@props(['notifications' => collect(), 'accent' => 'emerald'])

@php
    $notifications = collect($notifications);
    $colors = [
        'info' => 'bg-blue-500',
        'success' => 'bg-green-500',
        'warning' => 'bg-yellow-500',
        'danger' => 'bg-red-500',
    ];
    $accentText = $accent === 'blue' ? 'text-blue-600 hover:text-blue-800' : 'text-[#10B981] hover:text-[#0B4637]';
@endphp

<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition" aria-label="Notifications">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        @if($notifications->isNotEmpty())
            <span class="absolute -top-1 -right-1 min-w-5 h-5 px-1 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                {{ $notifications->count() }}
            </span>
        @endif
    </button>

    <div x-show="open"
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute -right-2 sm:right-0 mt-2 w-[calc(100vw-2rem)] sm:w-80 max-w-[360px] bg-white rounded-lg shadow-xl border border-gray-200 z-50"
         style="display: none;">
        <div class="px-4 py-3 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                <span class="text-xs text-gray-500">{{ $notifications->count() }} active</span>
            </div>
        </div>

        <div class="max-h-96 overflow-y-auto">
            @forelse($notifications as $notification)
                <a href="{{ $notification['url'] ?? '#' }}" class="block px-4 py-3 hover:bg-gray-50 transition border-b border-gray-100">
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 {{ $colors[$notification['type'] ?? 'info'] ?? 'bg-blue-500' }} rounded-full mt-2 flex-shrink-0"></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">{{ $notification['title'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $notification['message'] }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ optional($notification['date'])->diffForHumans() }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="px-4 py-8 text-center">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <p class="text-sm text-gray-500">No active notifications</p>
                </div>
            @endforelse
        </div>

        <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
            <span class="text-xs {{ $accentText }} font-medium">Updated from current system data</span>
        </div>
    </div>
</div>
