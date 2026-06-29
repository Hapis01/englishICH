@extends('layouts.student')

@section('title', 'Chat')
@section('page-title', 'Messages')
@section('page-subtitle', 'Communicate with your teachers')

@section('content')
<div class="flex flex-col md:grid md:grid-cols-4 gap-0 h-[80vh] md:h-[85vh] -mt-2 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <!-- Conversations List -->
    <div class="col-span-1 bg-white border-r border-gray-200 flex-col rounded-none {{ $selectedConversation ? 'hidden md:flex' : 'flex' }} h-full min-h-0">
        <!-- Header -->
        <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-[#0B4637] to-[#10B981]">
            <h3 class="text-white font-bold text-lg">Messages</h3>
            <p class="text-emerald-100 text-sm">Select teacher to chat</p>
        </div>

        <!-- Search -->
        <div class="p-4 border-b border-gray-200">
            <input type="text" id="conversationSearch" placeholder="Search teachers..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent text-sm">
        </div>

        <!-- Add Teacher Button -->
        <div class="p-4 border-b border-gray-200">
            <button onclick="openAddTeacherModal()" 
                    class="w-full px-4 py-2 bg-[#10B981] text-white rounded-lg hover:bg-[#0B4637] transition font-medium text-sm">
                + Start New Conversation
            </button>
        </div>

        <!-- Conversations List -->
        <div class="flex-1 overflow-y-auto min-h-0" id="conversationsList">
            @forelse($chatTeachers as $item)
                @php
                    $conversation = $item['conversation'];
                    $teacher = $item['teacher'];
                @endphp
                <div class="conversation-item p-3 border-b border-gray-100 hover:bg-emerald-50 cursor-pointer transition {{ $selectedConversation && $conversation && $selectedConversation->id == $conversation->id ? 'bg-emerald-100 border-l-4 border-[#10B981]' : '' }}"
                     onclick="{{ $conversation ? 'viewConversation(' . $conversation->id . ')' : 'startTeacherConversation(' . $teacher->id . ')' }}">
                    <div class="flex items-start space-x-3">
                        @if($teacher->profile_photo)
                            <img src="{{ asset($teacher->profile_photo) }}" alt="{{ $teacher->name }}" 
                                 class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                        @else
                            <div class="w-10 h-10 bg-[#10B981] rounded-full flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                                {{ substr($teacher->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <div class="flex items-center gap-2 min-w-0">
                                    <p class="font-semibold text-gray-900 text-sm truncate">{{ $teacher->name }}</p>
                                    <span class="text-xs bg-purple-100 text-purple-700 px-2 py-0.5 rounded">Teacher</span>
                                </div>
                                @if($item['unreadCount'] > 0)
                                    <span class="bg-[#10B981] text-white text-xs font-bold px-2 py-1 rounded-full">
                                        {{ $item['unreadCount'] }}
                                    </span>
                                @endif
                            </div>
                            @if($item['lastMessage'])
                                <p class="text-xs text-gray-500 truncate">{{ Str::limit($item['lastMessage']->message, 40) }}</p>
                            @else
                                <p class="text-xs text-gray-400 italic">No messages yet</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <p class="text-sm">No teachers available</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($chatTeachers->hasPages())
        <div class="p-3 border-t border-gray-200 flex justify-between items-center bg-gray-50">
            @if ($chatTeachers->onFirstPage())
                <button disabled class="text-gray-400 px-3 py-1 text-sm rounded bg-gray-100 cursor-not-allowed">&laquo; Prev</button>
            @else
                <a href="{{ $chatTeachers->previousPageUrl() }}" class="text-emerald-600 hover:bg-emerald-100 px-3 py-1 rounded text-sm font-medium transition bg-white border border-emerald-200">&laquo; Prev</a>
            @endif
            
            <span class="text-xs text-gray-500 font-medium">Page {{ $chatTeachers->currentPage() }}</span>

            @if ($chatTeachers->hasMorePages())
                <a href="{{ $chatTeachers->nextPageUrl() }}" class="text-emerald-600 hover:bg-emerald-100 px-3 py-1 rounded text-sm font-medium transition bg-white border border-emerald-200">Next &raquo;</a>
            @else
                <button disabled class="text-gray-400 px-3 py-1 text-sm rounded bg-gray-100 cursor-not-allowed">Next &raquo;</button>
            @endif
        </div>
        @endif
    </div>

    <!-- Chat Area -->
    <div class="col-span-3 bg-white flex-col rounded-none {{ $selectedConversation ? 'flex' : 'hidden md:flex' }} h-full min-h-0">
        @if($selectedConversation)
            <!-- Chat Header -->
            <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('student.chat') }}" class="md:hidden p-2 -ml-2 text-gray-600 hover:bg-gray-200 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </a>
                    @if($selectedConversation->teacher->profile_photo)
                        <img src="{{ asset($selectedConversation->teacher->profile_photo) }}" 
                             alt="{{ $selectedConversation->teacher->name }}" 
                             class="w-12 h-12 rounded-full object-cover">
                    @else
                        <div class="w-12 h-12 bg-[#10B981] rounded-full flex items-center justify-center text-white font-semibold">
                            {{ substr($selectedConversation->teacher->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h3 class="font-bold text-gray-900">{{ $selectedConversation->teacher->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $selectedConversation->teacher->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Messages -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4 min-h-0" id="messagesContainer">
                @forelse($messages as $msg)
                    <div class="flex {{ $msg->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="flex items-end space-x-2 max-w-xs {{ $msg->sender_id == auth()->id() ? 'flex-row-reverse space-x-reverse' : '' }}">
                            @if($msg->sender_id == auth()->id())
                                @if(auth()->user()->profile_photo)
                                    <img src="{{ asset(auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}" 
                                         class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                                @else
                                    <div class="w-8 h-8 bg-[#10B981] rounded-full flex items-center justify-center text-white text-xs flex-shrink-0">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                            @else
                                @if($msg->sender->profile_photo)
                                    <img src="{{ asset($msg->sender->profile_photo) }}" alt="{{ $msg->sender->name }}" 
                                         class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                                @else
                                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-white text-xs flex-shrink-0">
                                        {{ substr($msg->sender->name, 0, 1) }}
                                    </div>
                                @endif
                            @endif
                            
                            <div>
                                <div class="px-4 py-2 rounded-2xl {{ $msg->sender_id == auth()->id() ? 'bg-[#10B981] text-white' : 'bg-gray-200 text-gray-900' }}">
                                    <p class="text-sm">{{ $msg->message }}</p>
                                    @if($msg->attachment)
                                        <div class="mt-2">
                                            @if(in_array(strtolower(pathinfo($msg->attachment, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png']))
                                                <img src="{{ Str::startsWith($msg->attachment, 'images/') ? asset($msg->attachment) : asset('storage/' . $msg->attachment) }}" alt="Attachment" 
                                                     class="max-w-xs rounded mt-2">
                                            @else
                                                <a href="{{ Str::startsWith($msg->attachment, 'images/') ? asset($msg->attachment) : asset('storage/' . $msg->attachment) }}" target="_blank" 
                                                   class="text-xs underline {{ $msg->sender_id == auth()->id() ? 'text-emerald-100' : 'text-blue-600' }}">
                                                    📎 {{ basename($msg->attachment) }}
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 mt-1 {{ $msg->sender_id == auth()->id() ? 'text-right' : 'text-left' }}">
                                    {{ $msg->created_at->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-500">
                        <p class="text-sm">No messages yet. Start the conversation!</p>
                    </div>
                @endforelse
            </div>

            <!-- Message Input -->
            <div class="p-4 border-t border-gray-200 bg-gray-50">
                <form id="messageForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex items-end space-x-2">
                        <div class="flex-1">
                            <textarea name="message" id="messageInput" rows="2" placeholder="Type your message..." 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent resize-none text-sm"
                                      required></textarea>
                        </div>
                        <label for="attachmentInput" class="p-2 text-gray-600 hover:bg-gray-200 rounded-lg cursor-pointer transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                            </svg>
                        </label>
                           <input type="file" name="attachment" id="attachmentInput" class="hidden" 
                               accept=".jpg,.jpeg,.png,.pdf">
                        <button type="button" onclick="sendMessage({{ $selectedConversation->id }})" 
                                class="px-4 py-2 bg-[#10B981] text-white rounded-lg hover:bg-[#0B4637] transition font-medium text-sm">
                            Send
                        </button>
                    </div>
                    <p class="text-xs text-gray-600 mt-2" id="fileName"></p>
                </form>
            </div>
        @else
            <!-- No Conversation Selected -->
            <div class="flex-1 flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No conversation selected</h3>
                    <p class="text-gray-600 mb-6">Choose a teacher from the list or start a new conversation</p>
                    <button onclick="openAddTeacherModal()" 
                            class="px-6 py-2 bg-[#10B981] text-white rounded-lg hover:bg-[#0B4637] transition font-medium">
                        Start New Conversation
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Add Teacher Modal -->
<div id="addTeacherModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 max-h-96 flex flex-col">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Start New Conversation</h3>
            <button onclick="closeAddTeacherModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <input type="text" id="teacherSearchInput" placeholder="Search teachers..." 
               class="mx-6 mt-4 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent text-sm">
        
        <div class="flex-1 overflow-y-auto p-6 space-y-2" id="teachersList">
            <p class="text-center text-gray-500 text-sm py-8">Loading teachers...</p>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
            <button onclick="closeAddTeacherModal()" 
                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium text-sm">
                Close
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openAddTeacherModal() {
    document.getElementById('addTeacherModal').classList.remove('hidden');
    loadAvailableTeachers();
}

function closeAddTeacherModal() {
    document.getElementById('addTeacherModal').classList.add('hidden');
}

function loadAvailableTeachers() {
    fetch('{{ route("student.chat.available-teachers") }}')
        .then(response => response.json())
        .then(data => {
            const teachersList = document.getElementById('teachersList');
            if (data.success && data.data.length > 0) {
                teachersList.innerHTML = data.data.map(teacher => `
                    <div class="p-3 border border-gray-200 rounded-lg hover:bg-emerald-50 cursor-pointer transition"
                         onclick="startTeacherConversation(${teacher.id})">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full flex-shrink-0 ${teacher.profile_photo ? 'overflow-hidden' : 'bg-[#10B981] flex items-center justify-center text-white font-semibold text-sm'}">
                                ${teacher.profile_photo ? `<img src="/storage/${teacher.profile_photo}" alt="${teacher.name}" class="w-full h-full object-cover">` : teacher.name.charAt(0)}
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 text-sm">${teacher.name}</p>
                                <p class="text-xs text-gray-600">${teacher.email}</p>
                            </div>
                        </div>
                    </div>
                `).join('');
            } else {
                teachersList.innerHTML = '<p class="text-center text-gray-500 text-sm py-8">No teachers available</p>';
            }
        })
        .catch(error => console.error('Error loading teachers:', error));
}

function startTeacherConversation(teacherId) {
    fetch('{{ route("student.chat.start") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ teacher_id: teacherId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeAddTeacherModal();
            window.location.href = data.redirect;
        } else {
            alert('Error: ' + (data.error || 'Failed to start conversation'));
        }
    })
    .catch(error => console.error('Error:', error));
}

function viewConversation(conversationId) {
    window.location.href = `/student/chat/${conversationId}/view`;
}

function sendMessage(conversationId) {
    const form = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    const attachmentInput = document.getElementById('attachmentInput');
    
    if (!messageInput.value.trim() && !attachmentInput.files.length) {
        alert('Please enter a message or attach a file');
        return;
    }

    const formData = new FormData();
    formData.append('message', messageInput.value);
    if (attachmentInput.files.length > 0) {
        formData.append('attachment', attachmentInput.files[0]);
    }

    fetch(`/student/chat/${conversationId}/send`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageInput.value = '';
            attachmentInput.value = '';
            document.getElementById('fileName').textContent = '';
            loadConversationMessages(conversationId);
        } else {
            alert('Error sending message: ' + (data.error || 'Unknown error'));
        }
    })
    .catch(error => console.error('Error:', error));
}

// Attachment file name display
document.getElementById('attachmentInput')?.addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || '';
    document.getElementById('fileName').textContent = fileName ? `📎 ${fileName}` : '';
});

// Search conversations
document.getElementById('conversationSearch')?.addEventListener('input', function(e) {
    const term = e.target.value.toLowerCase();
    document.querySelectorAll('.conversation-item').forEach(item => {
        const name = item.textContent.toLowerCase();
        item.style.display = name.includes(term) ? '' : 'none';
    });
});

// Search teachers in modal
document.getElementById('teacherSearchInput')?.addEventListener('input', function(e) {
    const term = e.target.value.toLowerCase();
    document.querySelectorAll('#teachersList > div').forEach(item => {
        const name = item.textContent.toLowerCase();
        item.style.display = name.includes(term) ? '' : 'none';
    });
});

async function loadConversationMessages(conversationId) {
    try {
        const response = await fetch(`/student/chat/${conversationId}/messages`);
        const data = await response.json();

        if (!data.success) return;

        const container = document.getElementById('messagesContainer');
        if (!container) return;

        container.innerHTML = data.messages.map(msg => {
            const mine = msg.sender_id === {{ auth()->id() }};
            const attachmentUrl = msg.attachment ? (msg.attachment.startsWith('images/') ? `/${msg.attachment}` : `/storage/${msg.attachment}`) : '';
            const ext = msg.attachment ? msg.attachment.split('.').pop().toLowerCase() : '';
            const isImage = ['jpg','jpeg','png'].includes(ext);
            const avatar = msg.sender?.profile_photo ? `/${msg.sender.profile_photo}` : '';
            const initial = (msg.sender?.name || '?').charAt(0);

            return `
                <div class="flex ${mine ? 'justify-end' : 'justify-start'}">
                    <div class="flex items-end space-x-2 max-w-xs ${mine ? 'flex-row-reverse space-x-reverse' : ''}">
                        ${avatar ? `<img src="${avatar}" class="w-8 h-8 rounded-full object-cover flex-shrink-0">` : `<div class="w-8 h-8 ${mine ? 'bg-[#10B981]' : 'bg-gray-300'} rounded-full flex items-center justify-center text-white text-xs flex-shrink-0">${initial}</div>`}
                        <div>
                            <div class="px-4 py-2 rounded-2xl ${mine ? 'bg-[#10B981] text-white' : 'bg-gray-200 text-gray-900'}">
                                ${msg.message ? `<p class="text-sm">${escapeHtml(msg.message)}</p>` : ''}
                                ${msg.attachment ? `<div class="mt-2">${isImage ? `<img src="${attachmentUrl}" class="max-w-xs rounded mt-2">` : `<a href="${attachmentUrl}" target="_blank" class="text-xs underline ${mine ? 'text-emerald-100' : 'text-blue-600'}">📎 ${msg.attachment.split('/').pop()}</a>`}</div>` : ''}
                            </div>
                            <p class="text-xs text-gray-500 mt-1 ${mine ? 'text-right' : 'text-left'}">${new Date(msg.created_at).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}</p>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        container.scrollTop = container.scrollHeight;
    } catch (e) {
        console.error(e);
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

@if($selectedConversation)
setInterval(() => loadConversationMessages({{ $selectedConversation->id }}), 5000);
window.addEventListener('load', () => {
    const c = document.getElementById('messagesContainer');
    if (c) c.scrollTop = c.scrollHeight;
});
@endif
</script>
@endpush