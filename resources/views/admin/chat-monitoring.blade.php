@extends('layouts.admin')

@section('title', 'Chat Monitoring')

@section('page-title', 'Chat Monitoring')

@section('page-subtitle', 'Monitor all student-teacher conversations')

@section('content')
    <div class="flex flex-col lg:grid lg:grid-cols-4 gap-0 h-[80vh] md:h-[85vh] -mt-2 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div id="conversationListCol" class="lg:col-span-1 bg-white border-r border-gray-200 flex flex-col rounded-none h-full min-h-0">
            <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-[#0B4637] to-[#10B981]">
                <h3 class="text-white font-bold text-lg">Messages</h3>
                <p class="text-emerald-100 text-sm">Monitor student-teacher conversations</p>
            </div>

            <div class="p-4 border-b border-gray-200">
                <input type="text" id="conversationSearch" placeholder="Search conversations..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent text-sm">
            </div>

            <div class="flex-1 overflow-y-auto min-h-0" id="conversationsList">
                @forelse($conversations as $conversation)
                    @php($lastMessage = $conversation->messages->first())
                    <div class="conversation-item p-3 border-b border-gray-100 hover:bg-emerald-50 cursor-pointer transition"
                         data-conversation-id="{{ $conversation->id }}"
                         data-student="{{ $conversation->student->name }}"
                         data-teacher="{{ $conversation->teacher->name }}"
                         onclick="selectConversation('{{ $conversation->id }}', '{{ addslashes($conversation->student->name) }}', '{{ addslashes($conversation->teacher->name) }}')">
                        <div class="flex items-start space-x-3">
                            @if($conversation->student->profile_photo)
                                <img src="{{ asset(Str::startsWith($conversation->student->profile_photo, 'profile/') ? $conversation->student->profile_photo : 'profile/' . $conversation->student->profile_photo) }}" alt="{{ $conversation->student->name }}" class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                            @else
                                <div class="w-10 h-10 bg-[#10B981] rounded-full flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                                    {{ substr($conversation->student->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1 min-w-0">
                                    <p class="font-semibold text-gray-900 text-sm truncate">{{ $conversation->student->name }}</p>
                                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded">Student</span>
                                </div>
                                <p class="text-xs text-gray-600 truncate">Teacher: {{ $conversation->teacher->name }}</p>
                                @if($lastMessage)
                                    <p class="text-xs text-gray-500 truncate">{{ Str::limit($lastMessage->message ?: '[Attachment]', 40) }}</p>
                                    <p class="text-xs text-gray-400">{{ optional($conversation->last_message_at)->format('d M H:i') }}</p>
                                @else
                                    <p class="text-xs text-gray-400 italic">No messages yet</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">
                        <p class="text-sm">No conversations yet</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($conversations->hasPages())
            <div class="p-3 border-t border-gray-200 flex justify-between items-center bg-gray-50">
                @if ($conversations->onFirstPage())
                    <button disabled class="text-gray-400 px-3 py-1 text-sm rounded bg-gray-100 cursor-not-allowed">&laquo; Prev</button>
                @else
                    <a href="{{ $conversations->previousPageUrl() }}" class="text-emerald-600 hover:bg-emerald-100 px-3 py-1 rounded text-sm font-medium transition bg-white border border-emerald-200">&laquo; Prev</a>
                @endif
                
                <span class="text-xs text-gray-500 font-medium">Page {{ $conversations->currentPage() }}</span>

                @if ($conversations->hasMorePages())
                    <a href="{{ $conversations->nextPageUrl() }}" class="text-emerald-600 hover:bg-emerald-100 px-3 py-1 rounded text-sm font-medium transition bg-white border border-emerald-200">Next &raquo;</a>
                @else
                    <button disabled class="text-gray-400 px-3 py-1 text-sm rounded bg-gray-100 cursor-not-allowed">Next &raquo;</button>
                @endif
            </div>
            @endif
        </div>

        <div id="chatAreaCol" class="lg:col-span-3 bg-white flex-col rounded-none hidden lg:flex h-full min-h-0">
            <div id="chatHeader" class="p-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 hidden">
                <div class="flex items-center space-x-3">
                    <button onclick="backToMonitoringList()" class="lg:hidden p-2 -ml-2 text-gray-600 hover:bg-gray-200 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <div class="flex-1 flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-gray-900" id="chatTitle">Select a conversation</h3>
                            <p class="text-sm text-gray-600" id="chatSubtitle"></p>
                        </div>
                        <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full hidden sm:inline-block">Read Only - Admin Monitoring</span>
                    </div>
                </div>
            </div>

            <div id="emptyState" class="flex-1 flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No conversation selected</h3>
                    <p class="text-gray-600">Choose a conversation from the list</p>
                </div>
            </div>

            <div id="messagesContainer" class="flex-1 overflow-y-auto p-6 space-y-4 hidden min-h-0">
                <div id="messagesList" class="space-y-4"></div>
            </div>
        </div>
    </div>

    <script>
        let currentConversationId = null;

        function selectConversation(conversationId, studentName, teacherName) {
            currentConversationId = conversationId;

            // Update header
            document.getElementById('chatTitle').textContent = `${studentName} ↔ ${teacherName}`;
            document.getElementById('chatSubtitle').textContent = `Student: ${studentName} | Teacher: ${teacherName}`;
            document.getElementById('chatHeader').classList.remove('hidden');
            document.getElementById('emptyState').classList.add('hidden');
            document.getElementById('messagesContainer').classList.remove('hidden');

            // Mobile logic
            if (window.innerWidth < 1024) {
                document.getElementById('conversationListCol').classList.add('hidden');
                document.getElementById('conversationListCol').classList.remove('flex');
                document.getElementById('chatAreaCol').classList.remove('hidden');
                document.getElementById('chatAreaCol').classList.add('flex');
            }

            // Highlight selected conversation
            document.querySelectorAll('.conversation-item').forEach(item => {
                item.classList.remove('bg-blue-50', 'border-[#10B981]');
            });
            document.querySelector(`[data-conversation-id="${conversationId}"]`).classList.add('bg-blue-50', 'border-[#10B981]');

            loadMessages(conversationId);
        }

        function backToMonitoringList() {
            document.getElementById('chatAreaCol').classList.remove('flex');
            document.getElementById('chatAreaCol').classList.add('hidden');
            document.getElementById('conversationListCol').classList.remove('hidden');
            document.getElementById('conversationListCol').classList.add('flex');
            
            // Optionally pause auto-refresh if going back to list
            currentConversationId = null;
        }

        async function loadMessages(conversationId) {
            try {
                const response = await fetch(`/admin/chat-monitoring/${conversationId}/messages`);
                const data = await response.json();

                if (!data.success) {
                    alert('Error loading messages');
                    return;
                }

                const messagesList = document.getElementById('messagesList');
                
                if (data.messages.length === 0) {
                    messagesList.innerHTML = '<div class="text-center text-gray-500 text-sm py-8">No messages yet</div>';
                    return;
                }

                messagesList.innerHTML = data.messages.map(msg => {
                    const isStudent = msg.sender_id === data.student.id;
                    const bubble = isStudent ? 'bg-gray-200 text-gray-900' : 'bg-[#10B981] text-white';
                    const align = isStudent ? 'justify-start' : 'justify-end';
                    const reverse = isStudent ? '' : 'flex-row-reverse space-x-reverse';
                    const avatarBg = isStudent ? 'bg-gray-300' : 'bg-[#10B981]';
                    const attachment = renderAttachment(msg.attachment, !isStudent);

                    const getAvatarUrl = (photo) => {
                        if (!photo) return '';
                        return photo.startsWith('profile/') ? `/${photo}` : `/profile/${photo}`;
                    };
                    const avatarUrl = getAvatarUrl(msg.sender.profile_photo);

                    return `
                        <div class="flex ${align}">
                            <div class="flex items-end space-x-2 max-w-xs ${reverse}">
                                ${avatarUrl ? `<img src="${avatarUrl}" alt="${msg.sender.name}" class="w-8 h-8 rounded-full object-cover flex-shrink-0">` : `<div class="w-8 h-8 ${avatarBg} rounded-full flex items-center justify-center text-white text-xs flex-shrink-0">${msg.sender.name.charAt(0)}</div>`}
                                <div>
                                    <div class="px-4 py-2 rounded-2xl ${bubble}">
                                        ${msg.message ? `<p class="text-sm">${escapeHtml(msg.message)}</p>` : ''}
                                        ${attachment}
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1 ${isStudent ? 'text-left' : 'text-right'}">${new Date(msg.created_at).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}</p>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');

                // Scroll to bottom
                const container = document.getElementById('messagesContainer');
                setTimeout(() => {
                    container.scrollTop = container.scrollHeight;
                }, 100);
            } catch (error) {
                console.error('Error loading messages:', error);
                alert('Error loading messages');
            }
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function isImageFile(filename) {
            if (!filename) return false;
            const imageExtensions = ['.jpg', '.jpeg', '.png'];
            return imageExtensions.some(ext => filename.toLowerCase().endsWith(ext));
        }

        function isPdfFile(filename) {
            return !!filename && filename.toLowerCase().endsWith('.pdf');
        }

        function attachmentUrl(path) {
            if (!path) return '#';
            return path.startsWith('images/') ? `/${path}` : `/storage/${path}`;
        }

        function getFileName(filepath) {
            if (!filepath) return 'Attachment';
            return filepath.split('/').pop();
        }

        function renderAttachment(path, mine) {
            if (!path) return '';
            const url = attachmentUrl(path);
            const fileName = getFileName(path);

            if (isImageFile(path)) {
                return `<div class="mt-2"><a href="${url}" target="_blank"><img src="${url}" alt="Attachment" class="max-w-xs rounded mt-2"></a></div>`;
            }

            if (isPdfFile(path)) {
                return `
                    <div class="mt-2 p-2 rounded-lg ${mine ? 'bg-emerald-600' : 'bg-gray-100'}">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs ${mine ? 'text-emerald-50' : 'text-gray-700'}">📄 ${fileName}</span>
                            <div class="flex gap-2">
                                <a href="${url}" target="_blank" class="text-xs px-2 py-1 rounded ${mine ? 'bg-emerald-500 text-white' : 'bg-white text-blue-600 border'}">Open</a>
                                <a href="${url}" download class="text-xs px-2 py-1 rounded ${mine ? 'bg-emerald-500 text-white' : 'bg-white text-blue-600 border'}">Download</a>
                            </div>
                        </div>
                    </div>
                `;
            }

            return `<div class="mt-2"><a href="${url}" target="_blank" class="text-xs underline ${mine ? 'text-emerald-100' : 'text-blue-600'}">📎 ${fileName}</a></div>`;
        }

        // Search functionality
        document.getElementById('conversationSearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('.conversation-item').forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Auto-refresh messages every 5 seconds
        setInterval(() => {
            if (currentConversationId) {
                loadMessages(currentConversationId);
            }
        }, 5000);
    </script>

@endsection
