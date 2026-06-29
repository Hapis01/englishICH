<!-- Notification Component -->
<div x-data="notificationHandler()" 
     @notify.window="show($event.detail)"
     class="fixed top-4 right-4 z-50 space-y-3"
     style="max-width: 400px;">
    
    <template x-for="notification in notifications" :key="notification.id">
        <div x-show="notification.visible"
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-x-full opacity-0"
             x-transition:enter-end="translate-x-0 opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             :class="{
                 'bg-green-50 border-green-500': notification.type === 'success',
                 'bg-red-50 border-red-500': notification.type === 'error',
                 'bg-blue-50 border-blue-500': notification.type === 'info',
                 'bg-yellow-50 border-yellow-500': notification.type === 'warning'
             }"
             class="flex items-start p-4 rounded-lg shadow-lg border-l-4">
            
            <!-- Icon -->
            <div class="flex-shrink-0">
                <!-- Success Icon -->
                <svg x-show="notification.type === 'success'" class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <!-- Error Icon -->
                <svg x-show="notification.type === 'error'" class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <!-- Info Icon -->
                <svg x-show="notification.type === 'info'" class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <!-- Warning Icon -->
                <svg x-show="notification.type === 'warning'" class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>

            <!-- Content -->
            <div class="ml-3 flex-1">
                <p x-text="notification.title" 
                   :class="{
                       'text-green-800': notification.type === 'success',
                       'text-red-800': notification.type === 'error',
                       'text-blue-800': notification.type === 'info',
                       'text-yellow-800': notification.type === 'warning'
                   }"
                   class="text-sm font-semibold"></p>
                <p x-show="notification.message" 
                   x-text="notification.message"
                   :class="{
                       'text-green-700': notification.type === 'success',
                       'text-red-700': notification.type === 'error',
                       'text-blue-700': notification.type === 'info',
                       'text-yellow-700': notification.type === 'warning'
                   }"
                   class="text-sm mt-1"></p>
            </div>

            <!-- Close Button -->
            <button @click="remove(notification.id)" class="ml-3 flex-shrink-0">
                <svg class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </template>
</div>

<script>
function notificationHandler() {
    return {
        notifications: [],
        show(data) {
            const id = Date.now();
            this.notifications.push({
                id: id,
                type: data.type || 'info',
                title: data.title || 'Notification',
                message: data.message || '',
                visible: true
            });
            
            setTimeout(() => {
                this.remove(id);
            }, data.duration || 5000);
        },
        remove(id) {
            const index = this.notifications.findIndex(n => n.id === id);
            if (index > -1) {
                this.notifications[index].visible = false;
                setTimeout(() => {
                    this.notifications.splice(index, 1);
                }, 300);
            }
        }
    }
}
</script>
