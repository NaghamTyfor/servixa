{{-- resources/views/layouts/navbar.blade.php --}}
<div class="header-container container-xxl">
    <header class="header navbar navbar-expand-sm expand-header">

        <ul class="navbar-item theme-brand flex-row text-center">
            <li class="nav-item theme-logo">
                <a>
                    <img src="{{ asset('images/logo.png') }}" class="logo-light navbar-logo-g" alt="logo">
                    <img src="{{ asset('images/logo.png') }}" class="logo-dark navbar-logo-g" alt="logo">
                </a>
            </li>
            <li class="nav-item theme-text">
                <a>SERVIXA</a>
            </li>
        </ul>

        <ul class="navbar-item flex-row ms-lg-auto ms-0 action-area">

            {{-- Language --}}
            <li class="nav-item dropdown language-dropdown" style="margin-inline-end: 14px !important;">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="language-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if(session('locale') === 'ar')
                        <img src="{{ asset('images/syria.png') }}" class="flag-width" alt="flag">
                    @else
                        <img src="{{ Vite::asset('resources/images/1x1/us.svg') }}" class="flag-width" alt="flag">
                    @endif
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="language-dropdown">
                    <a class="dropdown-item d-flex" href="{{ route('language.switch', 'en') }}">
                        <img src="{{ Vite::asset('resources/images/1x1/us.svg') }}" class="flag-width" alt="flag">
                        <span class="align-self-center">&nbsp;English</span>
                    </a>
                    <a class="dropdown-item d-flex" href="{{ route('language.switch', 'ar') }}">
                        <img src="{{ asset('images/syria.png') }}" class="flag-width" alt="flag">
                        <span class="align-self-center">&nbsp;العربية</span>
                    </a>
                </div>
            </li>

            {{-- Theme toggle --}}
            <li class="nav-item theme-toggle-item" style="margin-inline-end: 14px !important;">
                <a href="javascript:void(0);" class="nav-link theme-toggle" style="margin-inline-end: 8px !important;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-moon dark-mode">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun light-mode">
                        <circle cx="12" cy="12" r="5"></circle>
                        <line x1="12" y1="1" x2="12" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="23"></line>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                        <line x1="1" y1="12" x2="3" y2="12"></line>
                        <line x1="21" y1="12" x2="23" y2="12"></line>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                    </svg>
                </a>
            </li>

            {{-- Notifications --}}
            <li class="nav-item dropdown notification-dropdown" style="margin-inline-end: 14px !important;">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="badge badge-success notification-badge" style="display: none;">0</span>
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown" style="width: 350px; max-height: 500px;">
                    <div class="drodpown-title message">
                        <h6 class="d-flex justify-content-between">
                            <span class="align-self-center">{{ __('admin_notifications.messages_title') }}</span>
                            <span class="badge badge-primary unread-count-badge">0</span>
                        </h6>
                    </div>
                    <div class="notification-scroll" style="max-height: 350px; overflow-y: auto;">
                        <div class="notifications-list">
                            <div class="text-center p-3 text-muted">{{ __('admin_notifications.loading') }}</div>
                        </div>
                    </div>
                </div>
            </li>

            {{-- User profile --}}
            <li class="nav-item dropdown user-profile-dropdown order-lg-0 order-1">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar-container">
                        <div class="avatar avatar-sm">
                            <span class="avatar-icon rounded-circle"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                    <div class="user-profile-section">
                        <div class="media mx-auto">
                            <div class="emoji me-2">&#x1F44B;</div>
                            <div class="media-body">
                                <h5>{{ auth('admin')->user()->name ?? 'Admin' }}</h5>
                                <p>{{ auth('admin')->user()->roles->pluck('name')->implode(', ') ?: 'No Role' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-item">
                        <a href="#" id="editProfileBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <span>{{ __('admin_notifications.edit_profile') }}</span>
                        </a>
                    </div>
                    <div class="dropdown-item">
                        <a href="#" id="logout-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                            <span>{{ __('admin.logout') ?? 'Log Out' }}</span>
                        </a>
                    </div>
                </div>
            </li>
        </ul>

        {{-- Form for logout with FCM token --}}
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="fcm_token" id="logout-fcm-token">
        </form>
    </header>
</div>

{{-- ========== MODAL EDIT PROFILE ========== --}}
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         style="width: 36px; height: 36px; background: rgba(139,92,246,0.12); flex-shrink: 0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                             fill="none" stroke="#8b5cf6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div>
                        <h6 class="modal-title mb-0" id="editProfileModalLabel">
                            {{ __('admin_notifications.edit_profile') }}
                        </h6>
                        <small class="text-muted" style="font-size: 12px;">
                            {{ __('admin_notifications.update_account_info') }}
                        </small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="profileUpdateForm">
                    @csrf
                    <div class="mb-3">
                        <label for="profile_name" class="form-label fw-semibold" style="font-size: 13px;">
                            {{ __('admin_notifications.name') }}
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                            <input type="text" class="form-control" id="profile_name" name="name"
                                   value="{{ auth('admin')->user()->name }}" required>
                        </div>
                        <div class="invalid-feedback name-error"></div>
                    </div>
                    <div class="d-flex align-items-center gap-2 my-3">
                        <hr class="flex-grow-1 m-0">
                        <small class="text-muted fw-semibold" style="font-size: 11px; white-space: nowrap; text-transform: uppercase; letter-spacing: 0.05em;">
                            {{ __('admin_notifications.change_password') }}
                        </small>
                        <hr class="flex-grow-1 m-0">
                    </div>
                    <div class="mb-3">
                        <label for="current_password" class="form-label" style="font-size: 13px;">
                            {{ __('admin_notifications.current_password') }}
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="5" y="11" width="14" height="10" rx="2" ry="2"></rect>
                                    <circle cx="12" cy="16" r="1"></circle>
                                    <path d="M8 11v-4a4 4 0 0 1 8 0v4"></path>
                                </svg>
                            </span>
                            <input type="password" class="form-control" id="current_password"
                                   name="current_password"
                                   placeholder="{{ __('admin_notifications.enter_current_password') }}">
                        </div>
                        <div class="invalid-feedback current-password-error"></div>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label for="new_password" class="form-label" style="font-size: 13px;">
                                {{ __('admin_notifications.new_password') }}
                                <small class="text-muted">({{ __('admin_notifications.optional') }})</small>
                            </label>
                            <input type="password" class="form-control" id="new_password"
                                   name="password" placeholder="••••••••">
                            <div class="invalid-feedback password-error"></div>
                        </div>
                        <div class="col-6">
                            <label for="password_confirmation" class="form-label" style="font-size: 13px;">
                                {{ __('admin_notifications.confirm_password') }}
                            </label>
                            <input type="password" class="form-control" id="password_confirmation"
                                   name="password_confirmation" placeholder="••••••••">
                        </div>
                    </div>
                    <div id="profileAlert" class="alert mt-3 d-none" role="alert"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">
                    {{ __('admin.cancel') ?? 'إلغاء' }}
                </button>
                <button type="button" class="btn btn-primary" id="saveProfileBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2.5" class="me-1">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    {{ __('admin_notifications.save_changes') }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// ========== ترجمات JavaScript ==========
const translations = {
    loading: '{{ __("admin_notifications.loading") }}',
    no_notifications: '{{ __("admin_notifications.no_notifications") }}',
    error_loading: '{{ __("admin_notifications.error_loading") }}',
    just_now: '{{ __("admin_notifications.just_now") }}',
    minute_ago: '{{ __("admin_notifications.minute_ago") }}',
    minutes_ago: '{{ __("admin_notifications.minutes_ago") }}',
    hour_ago: '{{ __("admin_notifications.hour_ago") }}',
    hours_ago: '{{ __("admin_notifications.hours_ago") }}',
    day_ago: '{{ __("admin_notifications.day_ago") }}',
    days_ago: '{{ __("admin_notifications.days_ago") }}'
};

// ========== Firebase FCM ==========
let _fcmToken = null;

async function initFirebase() {
    try {
        const { initializeApp, getApps } = await import('https://www.gstatic.com/firebasejs/10.7.0/firebase-app.js');
        const { getMessaging, getToken, onMessage } = await import('https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging.js');

        const app = getApps().length
            ? getApps()[0]
            : initializeApp({
                apiKey:            "AIzaSyBC7YLGTbcgg-p0IfyOhpqzNX63ZF5yopQ",
                authDomain:        "servixa-a1660.firebaseapp.com",
                projectId:         "servixa-a1660",
                storageBucket:     "servixa-a1660.firebasestorage.app",
                messagingSenderId: "876400172141",
                appId:             "1:876400172141:web:72f441934ddaed00ab3364"
            });

        const messaging = getMessaging(app);
        window.messaging = messaging;

        if ('serviceWorker' in navigator) {
            const reg = await navigator.serviceWorker.register('/firebase-messaging-sw.js');
            console.log('[FCM] SW registered:', reg.scope);
        }

        const permission = await Notification.requestPermission();
        if (permission !== 'granted') {
            console.warn('[FCM] Permission denied');
            return;
        }

        const token = await getToken(messaging, {
            vapidKey: "BHxGbpoIWoz2NKNaqL6NLEgTtjQ1cmue0sl3QYrCseQs0Yh4Qf2D4Wb_CMnAmDvX5VIH23kP9H3uQpvLrap4PSc",
            serviceWorkerRegistration: await navigator.serviceWorker.ready
        });

        if (!token) {
            console.warn('[FCM] No token received');
            return;
        }

        _fcmToken = token;
        console.log('[FCM] Token received');

        await fetch('{{ route("admin.fcm.store") }}', {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ token })
        });

        onMessage(messaging, payload => {
            console.log('[FCM] Foreground message:', payload);
            updateUnreadCount();
            if (Notification.permission === 'granted') {
                new Notification(payload.notification?.title || 'إشعار جديد', {
                    body: payload.notification?.body || '',
                    icon: '/logo.png'
                });
            }
        });
    } catch (err) {
        console.error('[FCM] Init error:', err);
    }
}

// ========== دوال الإشعارات ==========
function updateUnreadCount() {
    fetch('{{ route("admin.notifications.unread-count") }}', {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        credentials: 'same-origin'
    })
    .then(res => res.json())
    .then(data => {
        const count = data.unread_count || 0;
        const notificationBadge = document.querySelector('.notification-badge');
        const unreadCountBadge = document.querySelector('.unread-count-badge');
        if (notificationBadge) {
            if (count > 0) {
                notificationBadge.textContent = count > 99 ? '99+' : count;
                notificationBadge.style.display = 'inline-block';
                if (unreadCountBadge) unreadCountBadge.textContent = count;
            } else {
                notificationBadge.style.display = 'none';
                if (unreadCountBadge) unreadCountBadge.textContent = '0';
            }
        }
    })
    .catch(console.error);
}

function markAsRead(id) {
    const url = '{{ route("admin.notifications.mark-read", ["id" => "__ID__"]) }}'.replace('__ID__', id);
    return fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    });
}

function markAllAsRead() {
    fetch('{{ route("admin.notifications.mark-all-read") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(res => res.json())
    .then(() => {
        document.querySelectorAll('.notification-item').forEach(item => {
            if (item.dataset.read === 'true') {
                item.classList.remove('bg-light');
                item.dataset.read = 'false';
                const dot = item.querySelector('.unread-dot');
                if (dot) dot.remove();
            }
        });
        updateUnreadCount();
    })
    .catch(console.error);
}

function formatTimeAgo(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffMs = now - date;
    const diffMins = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffMs / 3600000);
    const diffDays = Math.floor(diffMs / 86400000);

    if (diffMins < 1) return translations.just_now;
    if (diffMins < 60) {
        return diffMins === 1 ? `1 ${translations.minute_ago}` : `${diffMins} ${translations.minutes_ago}`;
    }
    if (diffHours < 24) {
        return diffHours === 1 ? `1 ${translations.hour_ago}` : `${diffHours} ${translations.hours_ago}`;
    }
    if (diffDays < 7) {
        return diffDays === 1 ? `1 ${translations.day_ago}` : `${diffDays} ${translations.days_ago}`;
    }
    return date.toLocaleDateString();
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function getNotificationIcon(type) {
    switch (type) {
        case 'business_account_pending':
            return `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>`;
        case 'service_pending':
            return `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>`;
        case 'report_submitted':
            return `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="15" x2="4" y2="21"></line><line x1="20" y1="11" x2="20" y2="21"></line></svg>`;
        default:
            return `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6" y2="6"></line><line x1="6" y1="18" x2="6" y2="18"></line></svg>`;
    }
}

function loadNotifications() {
    const notificationsList = document.querySelector('.notifications-list');
    if (!notificationsList) return;
    notificationsList.innerHTML = `<div class="text-center p-3 text-muted">${translations.loading}</div>`;

    fetch('{{ route("admin.notifications.dropdown") }}', {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        credentials: 'same-origin'
    })
    .then(res => res.json())
    .then(data => {
        const notifications = data.notifications || [];
        if (notifications.length === 0) {
            notificationsList.innerHTML = `<div class="text-center p-3 text-muted">${translations.no_notifications}</div>`;
            return;
        }

        let html = '';
        notifications.forEach(n => {
            const isRead = n.read_at !== null;
            const readClass = isRead ? '' : 'bg-light';
            const url = n.url && n.url !== '#' ? n.url : '#';
            const icon = getNotificationIcon(n.type);

            html += `
                <div class="dropdown-item notification-item ${readClass}" data-id="${n.id}" data-read="${!isRead}" data-url="${url}">
                    <div class="media">
                        <div class="notification-icon me-2">${icon}</div>
                        <div class="media-body">
                            <div class="data-info">
                                <h6 class="mb-1">${escapeHtml(n.title)}</h6>
                                <p class="small text-muted mb-0">${escapeHtml(n.body)}</p>
                                <small class="text-muted time-ago">${formatTimeAgo(n.created_at)}</small>
                            </div>
                        </div>
                        ${!isRead ? '<div class="unread-dot"></div>' : ''}
                    </div>
                </div>
            `;
        });
        notificationsList.innerHTML = html;

        document.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.stopPropagation();
                const url = this.dataset.url;
                const isUnread = this.dataset.read === 'true';
                if (isUnread) {
                    markAsRead(this.dataset.id);
                    this.classList.remove('bg-light');
                    this.dataset.read = 'false';
                    const dot = this.querySelector('.unread-dot');
                    if (dot) dot.remove();
                    updateUnreadCount();
                }
                if (url && url !== '#') window.location.href = url;
            });
        });
    })
    .catch(err => {
        console.error(err);
        notificationsList.innerHTML = `<div class="text-center p-3 text-danger">${translations.error_loading}</div>`;
    });
}

// ========== تشغيل كل شيء عند تحميل الصفحة ==========
document.addEventListener('DOMContentLoaded', function() {
    // بدء Firebase
    initFirebase();

    // ========== الإشعارات ==========
    let isDropdownOpen = false;
    const toggle = document.querySelector('#notificationDropdown');
    if (toggle) {
        const dropdownElement = toggle.closest('.dropdown');
        if (dropdownElement) {
            dropdownElement.addEventListener('hide.bs.dropdown', function () {
                if (isDropdownOpen) markAllAsRead();
            });
        }
        toggle.addEventListener('shown.bs.dropdown', () => {
            if (!isDropdownOpen) {
                isDropdownOpen = true;
                loadNotifications();
            }
        });
        toggle.addEventListener('hidden.bs.dropdown', () => {
            isDropdownOpen = false;
        });
    }

    updateUnreadCount();
    setInterval(() => {
        updateUnreadCount();
        if (isDropdownOpen) loadNotifications();
    }, 60000);

    // ========== تسجيل الخروج ==========
    const logoutLink = document.getElementById('logout-link');
    const logoutForm = document.getElementById('logout-form');
    const fcmTokenInput = document.getElementById('logout-fcm-token');
    if (logoutLink && logoutForm) {
        logoutLink.addEventListener('click', function(e) {
            e.preventDefault();
            if (fcmTokenInput) fcmTokenInput.value = _fcmToken || '';
            logoutForm.submit();
        });
    }

    // ========== تحرير الملف الشخصي (تم التصحيح) ==========
    const editProfileBtn = document.getElementById('editProfileBtn');
    const editProfileModalEl = document.getElementById('editProfileModal');
    if (editProfileBtn && editProfileModalEl) {
        const editProfileModal = new bootstrap.Modal(editProfileModalEl);
        const saveProfileBtn = document.getElementById('saveProfileBtn');
        const profileForm = document.getElementById('profileUpdateForm');
        const profileAlert = document.getElementById('profileAlert');

        editProfileBtn.addEventListener('click', function(e) {
            e.preventDefault();
            profileForm.reset();
            profileAlert.classList.add('d-none');
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

            const currentNameElement = document.querySelector('.user-profile-section .media-body h5');
            const currentName = currentNameElement ? currentNameElement.textContent : '';
            document.getElementById('profile_name').value = currentName;

            editProfileModal.show();
        });

        if (saveProfileBtn) {
            saveProfileBtn.addEventListener('click', function() {
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                profileAlert.classList.add('d-none');

                const formData = new FormData(profileForm);
                formData.append('_method', 'PUT');

                fetch('{{ route("admin.profile.update") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const userNameElement = document.querySelector('.user-profile-section .media-body h5');
                        if (userNameElement) userNameElement.textContent = data.user.name;
                        profileAlert.classList.remove('d-none', 'alert-danger');
                        profileAlert.classList.add('alert-success');
                        profileAlert.textContent = data.message;
                        setTimeout(() => editProfileModal.hide(), 1500);
                    } else {
                        profileAlert.classList.remove('d-none', 'alert-success');
                        profileAlert.classList.add('alert-danger');
                        profileAlert.textContent = data.message || '{{ __("admin_notifications.update_error") }}';
                    }
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        error.response.json().then(errors => {
                            for (let field in errors.errors) {
                                let input = document.querySelector(`[name="${field}"]`);
                                if (input) {
                                    input.classList.add('is-invalid');
                                    let errorDiv = document.querySelector(`.${field}-error`);
                                    if (errorDiv) errorDiv.textContent = errors.errors[field][0];
                                }
                            }
                        });
                    } else {
                        profileAlert.classList.remove('d-none', 'alert-success');
                        profileAlert.classList.add('alert-danger');
                        profileAlert.textContent = '{{ __("admin_notifications.update_error") }}';
                    }
                });
            });
        }
    }
});
</script>

<style>
/* ===== MODAL STYLES ===== */
.modal-content {
    border-radius: 16px !important;
    overflow: hidden;
}

/* ===== LIGHT MODE - ألوان بنفسجية فاتحة ===== */
#editProfileModal .modal-content {
    background-color: #ffffff !important;
    color: #1a1a2e !important;
    border: 1px solid #d9c6f2 !important;
}
#editProfileModal .modal-header {
    background-color: #faf5ff !important;
    border-bottom: 1px solid #e9d5ff !important;
}
#editProfileModal .modal-footer {
    background-color: #faf5ff !important;
    border-top: 1px solid #e9d5ff !important;
}
#editProfileModal .modal-body {
    background-color: #ffffff !important;
}
#editProfileModal .form-control,
#editProfileModal .input-group-text {
    background-color: #ffffff !important;
    border-color: #d9c6f2 !important;
    color: #1a1a2e !important;
}
#editProfileModal .form-control:focus {
    border-color: #a855f7 !important;
    box-shadow: 0 0 0 0.2rem rgba(168, 85, 247, 0.25) !important;
}
#editProfileModal .btn-primary {
    background-color: #8b5cf6 !important;
    border-color: #7c3aed !important;
}
#editProfileModal .btn-primary:hover {
    background-color: #7c3aed !important;
}
#editProfileModal .btn-light-dark {
    background-color: #f3e8ff !important;
    color: #5b21b6 !important;
    border-color: #e9d5ff !important;
}
#editProfileModal .btn-light-dark:hover {
    background-color: #e9d5ff !important;
}
#editProfileModal .modal-title,
#editProfileModal h6,
#editProfileModal label {
    color: #1a1a2e !important;
}
#editProfileModal .btn-close {
    filter: none !important;
}

/* ===== DARK MODE ===== */
.dark #editProfileModal .modal-content,
html.dark #editProfileModal .modal-content,
[data-theme="dark"] #editProfileModal .modal-content,
.dark-mode #editProfileModal .modal-content {
    background-color: #1b2e4b !important;
    color: #e0e6ed !important;
    border: 1px solid #2d3f55 !important;
}
.dark #editProfileModal .modal-header,
.dark #editProfileModal .modal-footer,
html.dark #editProfileModal .modal-header,
html.dark #editProfileModal .modal-footer,
[data-theme="dark"] #editProfileModal .modal-header,
[data-theme="dark"] #editProfileModal .modal-footer,
.dark-mode #editProfileModal .modal-header,
.dark-mode #editProfileModal .modal-footer {
    background-color: #162138 !important;
    border-color: #2d3f55 !important;
}
.dark #editProfileModal .modal-body,
html.dark #editProfileModal .modal-body,
[data-theme="dark"] #editProfileModal .modal-body,
.dark-mode #editProfileModal .modal-body {
    background-color: #1b2e4b !important;
}
.dark #editProfileModal .form-control,
.dark #editProfileModal .input-group-text,
html.dark #editProfileModal .form-control,
html.dark #editProfileModal .input-group-text,
[data-theme="dark"] #editProfileModal .form-control,
[data-theme="dark"] #editProfileModal .input-group-text,
.dark-mode #editProfileModal .form-control,
.dark-mode #editProfileModal .input-group-text {
    background-color: #0e1726 !important;
    border-color: #2d3f55 !important;
    color: #e0e6ed !important;
}
.dark #editProfileModal .form-control::placeholder,
html.dark #editProfileModal .form-control::placeholder,
[data-theme="dark"] #editProfileModal .form-control::placeholder,
.dark-mode #editProfileModal .form-control::placeholder {
    color: #506690 !important;
}
.dark #editProfileModal .modal-title,
.dark #editProfileModal h6,
.dark #editProfileModal label,
html.dark #editProfileModal .modal-title,
html.dark #editProfileModal h6,
html.dark #editProfileModal label,
[data-theme="dark"] #editProfileModal .modal-title,
[data-theme="dark"] #editProfileModal h6,
[data-theme="dark"] #editProfileModal label,
.dark-mode #editProfileModal .modal-title,
.dark-mode #editProfileModal h6,
.dark-mode #editProfileModal label {
    color: #e0e6ed !important;
}
.dark #editProfileModal .text-muted,
html.dark #editProfileModal .text-muted,
[data-theme="dark"] #editProfileModal .text-muted,
.dark-mode #editProfileModal .text-muted {
    color: #888ea8 !important;
}
.dark #editProfileModal hr,
html.dark #editProfileModal hr,
[data-theme="dark"] #editProfileModal hr,
.dark-mode #editProfileModal hr {
    border-color: #2d3f55 !important;
}
.dark #editProfileModal .btn-close,
html.dark #editProfileModal .btn-close,
[data-theme="dark"] #editProfileModal .btn-close,
.dark-mode #editProfileModal .btn-close {
    filter: invert(1) brightness(2) !important;
}

/* ===== NOTIFICATIONS STYLES ===== */
.notification-item {
    cursor: pointer;
    transition: background 0.2s;
}
.notification-item:hover {
    background-color: rgba(0,0,0,0.04);
}
.notification-item .unread-dot {
    width: 8px;
    height: 8px;
    background-color: #0d6efd;
    border-radius: 50%;
    display: inline-block;
    margin-left: 8px;
    align-self: center;
}
.notification-icon svg {
    width: 20px;
    height: 20px;
    color: #6c757d;
}
.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    font-size: 10px;
    padding: 2px 5px;
}
.time-ago {
    font-size: 10px;
}
.notification-scroll::-webkit-scrollbar {
    width: 5px;
}
.notification-scroll::-webkit-scrollbar-track {
    background: transparent;
}
.notification-scroll::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 5px;
}
</style>
