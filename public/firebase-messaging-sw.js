importScripts('https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: "AIzaSyBC7YLGTbcgg-p0IfyOhpqzNX63ZF5yopQ",
    authDomain: "servixa-a1660.firebaseapp.com",
    projectId: "servixa-a1660",
    storageBucket: "servixa-a1660.firebasestorage.app",
    messagingSenderId: "876400172141",
    appId: "1:876400172141:web:72f441934ddaed00ab3364"
});

const messaging = firebase.messaging();

self.addEventListener('push', function(event) {
    event.preventDefault();

    let payload = {};
    if (event.data) {
        payload = event.data.json();
    }

    const title = payload.notification?.title || payload.data?.title || 'إشعار جديد';
    const body  = payload.notification?.body  || payload.data?.body  || '';

    event.waitUntil(
        self.registration.showNotification(title, {
            body: body,
            icon: '/logo.png',
            badge: '/logo.png',
            data: payload.data || {}
        })
    );
});

messaging.onBackgroundMessage(() => {
});

self.addEventListener('notificationclick', event => {
    event.notification.close();
    const url = event.notification.data?.url || '/';
    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(clientList => {
            for (const client of clientList) {
                if (client.url === url && 'focus' in client) {
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        })
    );
});
