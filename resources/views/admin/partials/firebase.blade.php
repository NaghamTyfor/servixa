<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.0/firebase-app.js";
    import { getMessaging, getToken } from "https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging.js";

    const firebaseConfig = {
        apiKey: "AIzaSyBC7YLGTbcgg-p0IfyOhpqzNX63ZF5yopQ",
        authDomain: "servixa-a1660.firebaseapp.com",
        projectId: "servixa-a1660",
        storageBucket: "servixa-a1660.firebasestorage.app",
        messagingSenderId: "876400172141",
        appId: "1:876400172141:web:72f441934ddaed00ab3364"
    };

    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);

    Notification.requestPermission().then(permission => {
        if (permission === 'granted') {
            getToken(messaging, {
                vapidKey: "BHs8hpmiWfL3hjbzyx_uAhsOOBoi4wnW6CREfPmiOYRssQWZHILmRhTocqtScA0H9rYUqRfZZtGJX3hM83Kx-d0"
            }).then(token => {
                fetch('{{ route("admin.fcm.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ token })
                }).then(res => res.json())
                  .then(data => console.log('FCM token stored', data))
                  .catch(err => console.error('FCM store error', err));
            }).catch(err => console.error('getToken error', err));
        }
    });

    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/firebase-messaging-sw.js')
            .then(reg => console.log('SW registered', reg))
            .catch(err => console.error('SW registration failed', err));
    }
</script>
