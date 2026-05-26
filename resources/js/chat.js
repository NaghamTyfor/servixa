// resources/js/chat.js
// يتم تحميله فقط في صفحة المحادثة

document.addEventListener('DOMContentLoaded', () => {
    // التحقق من وجود CHAT_CONFIG قبل البدء
    if (typeof window.CHAT_CONFIG === 'undefined') {
        console.error('[Chat] CHAT_CONFIG غير معرف. تأكد من وجوده في الـ Blade.');
        return;
    }

    const config = window.CHAT_CONFIG;
    if (!config.conversationId || config.conversationId === 0) {
        console.error('[Chat] conversationId غير صالح:', config.conversationId);
        return;
    }

    initEcho();
    initSendButton();
    scrollToBottom();
});

function initEcho() {
    if (!window.Echo) {
        console.error('[Chat] Echo غير متاح. تأكد من تحميل laravel-echo و pusher-js.');
        setStatus('disconnected');
        return;
    }

    const conversationId = window.CHAT_CONFIG.conversationId;
    const currentUserId = window.CHAT_CONFIG.currentUserId;

    try {
        const channel = window.Echo.private(`conversation.${conversationId}`);

        channel.listen('.message.sent', (data) => {
            if (data.sender_id !== currentUserId) {
                appendMessage(data, false);
            }
        });

        channel.error((error) => {
            console.error('[Chat] فشل الاشتراك في القناة الخاصة:', error);
            setStatus('disconnected');
        });

        // مراقبة حالة الاتصال (Pusher)
        if (window.Echo.connector && window.Echo.connector.pusher) {
            const pusher = window.Echo.connector.pusher;
            pusher.connection.bind('connected', () => setStatus('connected'));
            pusher.connection.bind('connecting', () => setStatus('connecting'));
            pusher.connection.bind('disconnected', () => setStatus('disconnected'));
            pusher.connection.bind('failed', () => setStatus('disconnected'));
            // إذا كان متصلاً بالفعل
            if (pusher.connection.state === 'connected') setStatus('connected');
            else if (pusher.connection.state === 'connecting') setStatus('connecting');
            else setStatus('disconnected');
        } else {
            console.warn('[Chat] لا يمكن مراقبة حالة Pusher');
        }
    } catch (err) {
        console.error('[Chat] خطأ في initEcho:', err);
        setStatus('disconnected');
    }
}

function initSendButton() {
    const sendBtn = document.getElementById('sendBtn');
    const msgInput = document.getElementById('messageInput');
    if (!sendBtn || !msgInput) {
        console.error('[Chat] عناصر الإرسال غير موجودة');
        return;
    }

    async function sendMessage() {
        const body = msgInput.value.trim();
        if (!body) return;

        // تعطيل الزر ومنع الإرسال المتكرر
        sendBtn.disabled = true;
        const originalValue = msgInput.value;
        msgInput.value = '';
        autoResize(msgInput);

        // إضافة الرسالة بشكل متفائل (optimistic)
        appendMessage({
            body: body,
            sender_id: window.CHAT_CONFIG.currentUserId,
            sender_name: window.CHAT_CONFIG.currentUserName,
            created_at: new Date().toISOString(),
            read_at: null
        }, true);

        try {
            const response = await fetch(window.CHAT_CONFIG.sendUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ body })
            });

            if (!response.ok) {
                const errorText = await response.text();
                console.error('[Chat] فشل الإرسال:', response.status, errorText);
                // يمكن إظهار رسالة للمستخدم
                msgInput.value = originalValue;
                autoResize(msgInput);
                alert('فشل إرسال الرسالة. حاول مرة أخرى.');
            }
        } catch (err) {
            console.error('[Chat] خطأ في الشبكة:', err);
            msgInput.value = originalValue;
            autoResize(msgInput);
            alert('حدث خطأ في الاتصال. لم يتم إرسال الرسالة.');
        } finally {
            sendBtn.disabled = false;
            msgInput.focus();
        }
    }

    msgInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    sendBtn.addEventListener('click', sendMessage);
    msgInput.addEventListener('input', () => autoResize(msgInput));
}

function appendMessage(data, isMe) {
    const area = document.getElementById('messagesArea');
    if (!area) return;

    // إزالة رسالة "لا توجد رسائل" إن وجدت
    const emptyDiv = document.getElementById('emptyState');
    if (emptyDiv) emptyDiv.remove();

    const senderName = data.sender_name || (isMe ? window.CHAT_CONFIG.currentUserName : 'الطرف الآخر');
    const initial = senderName.charAt(0).toUpperCase();
    const timeStr = formatTime(data.created_at);
    const readMark = isMe ? `<span class="read-tick">${data.read_at ? '✓✓' : '✓'}</span>` : '';

    const otherAvatar = `<div class="msg-avatar other-av">${escapeHtml(initial)}</div>`;
    const meAvatar = `<div class="msg-avatar me-av">${escapeHtml(window.CHAT_CONFIG.currentUserInitial || '?')}</div>`;

    const html = `
        <div class="msg-row ${isMe ? 'me' : 'other'}">
            ${!isMe ? otherAvatar : ''}
            <div class="msg-col">
                <div class="msg-bubble">${escapeHtml(data.body)}</div>
                <div class="msg-meta">${timeStr}${readMark}</div>
            </div>
            ${isMe ? meAvatar : ''}
        </div>
    `;

    area.insertAdjacentHTML('beforeend', html);
    scrollToBottom();
}

function scrollToBottom() {
    const area = document.getElementById('messagesArea');
    if (area) {
        area.scrollTop = area.scrollHeight;
    }
}

function formatTime(dateStr) {
    try {
        const date = new Date(dateStr);
        if (isNaN(date.getTime())) return '';
        return date.toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit' });
    } catch (e) {
        return '';
    }
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

function autoResize(el) {
    if (!el) return;
    el.style.height = 'auto';
    el.style.height = Math.min(el.scrollHeight, 100) + 'px';
}

function setStatus(state) {
    const dot = document.getElementById('statusDot');
    const textEl = document.getElementById('statusText');
    if (!dot || !textEl) return;

    const states = {
        'connecting': { class: '', text: 'جاري الاتصال...' },
        'connected': { class: 'connected', text: 'متصل' },
        'disconnected': { class: 'disconnected', text: 'غير متصل' }
    };
    const s = states[state] || states['disconnected'];
    dot.className = `status-dot ${s.class}`;
    textEl.textContent = s.text;
}
