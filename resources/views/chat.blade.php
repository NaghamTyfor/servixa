@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">

<style>
    * {
        font-family: 'Tajawal', sans-serif;
    }

    body {
        background: linear-gradient(145deg, #e0eafc 0%, #cfdef3 100%);
        margin: 0;
        padding: 10px;
        min-height: 100vh;
        direction: rtl;
    }

    .chat-container {
        max-width: 900px;
        margin: 0 auto;
        background: #ffffff;
        border-radius: 28px;
        box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        height: calc(100vh - 80px);
        overflow: hidden;
        animation: containerFadeIn 0.6s ease-out forwards;
    }

    @keyframes containerFadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .chat-header {
        padding: 12px 20px;
        background: #ffffff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .chat-header .avatar {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #2b3b6e, #1e2a4a);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        transition: transform 0.3s ease;
    }

    .chat-header:hover .avatar {
        transform: rotate(15deg) scale(1.05);
    }

    .chat-header .user-info {
        flex: 1;
    }

    .chat-header .user-info h3 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 700;
        color: #1f2a48;
    }

    .chat-header .user-info p {
        margin: 4px 0 0;
        font-size: 0.75rem;
        color: #6c7a8e;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .online-pulse {
        width: 8px;
        height: 8px;
        background-color: #6c7a8e; /* افتراضي غير متصل */
        border-radius: 50%;
        display: inline-block;
        transition: all 0.3s ease;
    }

    /* حالة المتصل الحقيقية */
    .online-pulse.active {
        background-color: #2ec4b6;
        box-shadow: 0 0 0 0 rgba(46, 196, 182, 0.7);
        animation: pulseGreen 1.6s infinite;
    }

    @keyframes pulseGreen {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(46, 196, 182, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(46, 196, 182, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(46, 196, 182, 0); }
    }

    .typing-indicator {
        font-size: 0.75rem;
        color: #2ec4b6;
        font-weight: 500;
        display: none;
        align-items: center;
        gap: 4px;
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 16px 20px;
        background-color: #efeae2;
        background-image: url('https://www.transparenttextures.com/patterns/beige-paper.png');
        background-repeat: repeat;
        display: flex;
        flex-direction: column;
        gap: 12px;
        scroll-behavior: smooth;
    }

    .message {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        max-width: 80%;
        animation: messageAppear 0.3s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        opacity: 0;
        transform-origin: bottom;
    }

    @keyframes messageAppear {
        0% { opacity: 0; transform: translateY(15px) scale(0.97); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    .message.me { flex-direction: row-reverse; align-self: flex-end; }
    .message.other { align-self: flex-start; }

    .message-avatar {
        width: 28px;
        height: 28px;
        background: #eef2ff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        color: #2c3e66;
        flex-shrink: 0;
    }

    .message.me .message-avatar { display: none; }

    .bubble {
        padding: 8px 14px;
        border-radius: 18px;
        font-size: 0.9rem;
        line-height: 1.4;
        word-wrap: break-word;
        box-shadow: 0 1px 0.5px rgba(0, 0, 0, 0.08);
    }

    .me .bubble {
        background: linear-gradient(135deg, #e9d5ff, #d8b4fe);
        color: #2e1065;
        border-bottom-left-radius: 4px;
    }

    .other .bubble {
        background: #ffffff;
        color: #111b21;
        border-bottom-right-radius: 4px;
    }

    .time {
        font-size: 0.6rem;
        margin-top: 2px;
        margin-inline: 6px;
        color: #667781;
        display: flex;
        gap: 6px;
        align-items: center;
    }

    .message.me .time { justify-content: flex-end; }
    .message.other .time { justify-content: flex-start; direction: ltr; }

    .typing-bubble-container { display: none; align-self: flex-start; }
    .typing-bubble { display: flex; align-items: center; gap: 4px; padding: 12px 16px; background: #ffffff; border-radius: 18px; border-bottom-right-radius: 4px; box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05); }
    .typing-dot { width: 6px; height: 6px; background-color: #6e7f97; border-radius: 50%; animation: messengerBounce 1.4s infinite ease-in-out both; }
    .typing-dot:nth-child(1) { animation-delay: -0.32s; }
    .typing-dot:nth-child(2) { animation-delay: -0.16s; }

    @keyframes messengerBounce { 0%, 80%, 100% { transform: scale(0); } 40% { transform: scale(1); } }

    .empty-messages { text-align: center; color: #5e6f8d; margin: auto; padding: 30px 20px; background: rgba(255,255,240,0.7); border-radius: 48px; font-size: 0.85rem; }

    .chat-input { display: flex; align-items: center; gap: 10px; padding: 10px 20px; background: white; border-top: 1px solid #edf2f7; }
    .chat-input input { flex: 1; border: 1px solid #e2e8f0; border-radius: 28px; padding: 10px 18px; font-size: 0.9rem; outline: none; height: 40px; box-sizing: border-box; }
    .chat-input button { background: #2d3e6e; border: none; border-radius: 50%; width: 40px; height: 40px; color: white; cursor: pointer; display: flex; align-items: center; justify-content: center; }

    .status { font-size: 0.7rem; padding: 6px 12px; background: #f1f5f9; border-top: 1px solid #e4e9f0; text-align: center; color: #475569; display: flex; align-items: center; justify-content: center; gap: 6px; }
</style>
@endsection

@section('content')
<div class="chat-container">
    <div class="chat-header">
        <div class="avatar"><i class="fas fa-user-astronaut"></i></div>
        <div class="user-info">
            <h3>{{ $otherUser->full_name }}</h3>
            <!-- جعل الحالة الافتراضية غير متصل حتى يتم التحقق من الـ Presence Channel -->
            <p id="userStatusText">
                <span id="statusIndicator" class="online-pulse"></span> <span id="statusLabel">غير متصل</span>
            </p>
            <span class="typing-indicator" id="typingIndicator">
                <i class="fas fa-pen-fancy fa-bounce"></i> يكتب الآن...
            </span>
        </div>
        <div><i class="fas fa-ellipsis-v" style="color: #a0b3d9; cursor: pointer;"></i></div>
    </div>

    <div class="chat-messages" id="messagesContainer">
        @forelse($messages as $msg)
            @php $isMe = ($msg->sender_id == $currentUser->id); @endphp
            <div class="message {{ $isMe ? 'me' : 'other' }}">
                @if(!$isMe)
                <div class="message-avatar"><i class="fas fa-user-circle"></i></div>
                @endif
                <div class="message-content">
                    <div class="bubble">{{ e($msg->body) }}</div>
                    <div class="time">
                        {{ $msg->created_at->format('H:i') }}
                        @if($isMe)
                            <i class="fas fa-check" title="تم الإرسال"></i>
                        @endif
                    </div>
                </div>
                @if($isMe)
                <div class="message-avatar" style="visibility: hidden;"></div>
                @endif
            </div>
        @empty
            <div class="empty-messages" id="emptyMessages">
                <i class="fas fa-comment-dots" style="font-size: 2rem; opacity: 0.5; margin-bottom: 12px; display: block;"></i>
                ✨ لا توجد رسائل بعد، ابدأ المحادثة ✨
            </div>
        @endforelse

        <div class="message other typing-bubble-container" id="messengerTypingBubble">
            <div class="message-avatar"><i class="fas fa-user-circle"></i></div>
            <div class="message-content">
                <div class="typing-bubble">
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="chat-input">
        <input type="text" id="messageInput" placeholder="مراسلة">
        <button id="sendButton"><i class="fas fa-paper-plane"></i></button>
    </div>
    <div class="status" id="connectionStatus">
        <i class="fas fa-wifi"></i> جاري الاتصال...
    </div>
</div>

<script src="https://js.pusher.com/8.5.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.0/dist/echo.iife.js"></script>

<script>
    (function() {
        const CONFIG = {
            conversationId: {{ $conversation->id }},
            currentUserId: {{ $currentUser->id }},
            otherUserId: {{ $otherUser->id }},
            sendUrl: @json(route('chat.send.web', $conversation->id)),
            csrfToken: '{{ csrf_token() }}'
        };

        const messagesContainer = document.getElementById('messagesContainer');
        const messageInput = document.getElementById('messageInput');
        const sendButton = document.getElementById('sendButton');
        const statusSpan = document.getElementById('connectionStatus');
        const userStatusText = document.getElementById('userStatusText');
        const typingIndicator = document.getElementById('typingIndicator');
        const messengerTypingBubble = document.getElementById('messengerTypingBubble');

        // عناصر مؤشر الحالة المباشر الجديد
        const statusIndicator = document.getElementById('statusIndicator');
        const statusLabel = document.getElementById('statusLabel');

        window.Pusher = Pusher;
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env('PUSHER_APP_KEY') }}',
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            forceTLS: true,
            authEndpoint: '/broadcasting/auth',
            auth: { headers: { 'X-CSRF-TOKEN': CONFIG.csrfToken } }
        });

        function scrollToBottom() {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function setOtherUserOnline(isOnline) {
            if (isOnline) {
                statusIndicator.classList.add('active');
                statusLabel.textContent = 'متصل الآن';
            } else {
                statusIndicator.classList.remove('active');
                statusLabel.textContent = 'غير متصل';
            }
        }

        function addMessageToUI(body, senderId, createdAt, isMe) {
            const emptyDiv = document.getElementById('emptyMessages');
            if (emptyDiv) emptyDiv.remove();

            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${isMe ? 'me' : 'other'}`;

            if (!isMe) {
                const avatar = document.createElement('div');
                avatar.className = 'message-avatar';
                avatar.innerHTML = '<i class="fas fa-user-circle"></i>';
                messageDiv.appendChild(avatar);
            }

            const contentDiv = document.createElement('div');
            contentDiv.className = 'message-content';

            let timeFormatted = '';
            try {
                timeFormatted = new Date(createdAt).toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit', hour12: false });
            } catch(e) {}

            contentDiv.innerHTML = `
                <div class="bubble">${body.replace(/[&<>]/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;'})[m])}</div>
                <div class="time">${timeFormatted} ${isMe ? '<i class="fas fa-check"></i>' : ''}</div>
            `;
            messageDiv.appendChild(contentDiv);

            messagesContainer.insertBefore(messageDiv, messengerTypingBubble);
            scrollToBottom();
        }

        async function sendMessage() {
            const text = messageInput.value.trim();
            if (!text) return;

            sendButton.disabled = true;
            messageInput.value = '';

            addMessageToUI(text, CONFIG.currentUserId, new Date().toISOString(), true);

            try {
                await fetch(CONFIG.sendUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CONFIG.csrfToken },
                    body: JSON.stringify({ body: text })
                });
            } catch (err) {
                alert('فشل إرسال الرسالة');
            } finally {
                sendButton.disabled = false;
                messageInput.focus();
            }
        }

        function initPusher() {
            if (!window.Echo) return null;

            // استخدام d.join() بدلاً من .private() لتفعيل ميزة الـ Presence Channel
            const channel = window.Echo.join(`conversation.${CONFIG.conversationId}`);

            channel.here((users) => {
                statusSpan.innerHTML = '<i class="fas fa-wifi"></i> متصل بالغرفة';
                // فحص إذا كان المستخدم الآخر موجوداً بالفعل عند دخولنا للمحادثة
                const isOtherPresent = users.some(u => u.id == CONFIG.otherUserId);
                setOtherUserOnline(isOtherPresent);
            })
            .joining((user) => {
                // إذا دخل الشخص الآخر إلى الشات الآن
                if (user.id == CONFIG.otherUserId) {
                    setOtherUserOnline(true);
                }
            })
            .leaving((user) => {
                // إذا خرج الشخص الآخر أو أغلق الصفحة
                if (user.id == CONFIG.otherUserId) {
                    setOtherUserOnline(false);
                    messengerTypingBubble.style.display = 'none';
                    typingIndicator.style.display = 'none';
                    userStatusText.style.display = 'flex';
                }
            });

            channel.listen('.message.sent', (data) => {
                if (data.sender_id != CONFIG.currentUserId) {
                    addMessageToUI(data.body, data.sender_id, data.created_at, false);
                    messengerTypingBubble.style.display = 'none';
                    typingIndicator.style.display = 'none';
                    userStatusText.style.display = 'flex';
                }
            });

            let typingTimer = null;
            channel.listenForWhisper('typing', (e) => {
                userStatusText.style.display = 'none';
                typingIndicator.style.display = 'flex';
                messengerTypingBubble.style.display = 'flex';
                scrollToBottom();

                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => {
                    messengerTypingBubble.style.display = 'none';
                    typingIndicator.style.display = 'none';
                    userStatusText.style.display = 'flex';
                }, 2000);
            });

            return channel;
        }

        function bindEvents(channel) {
            sendButton.addEventListener('click', sendMessage);
            messageInput.addEventListener('keydown', (e) => { if (e.key === 'Enter') sendMessage(); });

            if (channel) {
                let lastWhisperTime = 0;
                messageInput.addEventListener('input', () => {
                    const now = Date.now();
                    if (now - lastWhisperTime > 300) {
                        channel.whisper('typing', { userID: CONFIG.currentUserId });
                        lastWhisperTime = now;
                    }
                });
            }
        }

        const channel = initPusher();
        bindEvents(channel);
        scrollToBottom();
    })();
</script>
@endsection
