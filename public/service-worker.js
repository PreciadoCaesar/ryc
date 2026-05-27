self.addEventListener('install', function(event) {
    self.skipWaiting();
});

self.addEventListener('activate', function(event) {
    event.waitUntil(clients.claim());
});

self.addEventListener('push', function(event) {
    if (!event.data) return;
    try {
        var data = event.data.json();
        var title = data.title || 'Nuevo Lead';
        var options = {
            body: data.body || 'Alguien solicitó información',
            icon: data.icon || '/ryc/img/og-default.svg',
            badge: '/ryc/img/og-default.svg',
            vibrate: [200, 100, 200],
            data: { url: data.url || '/ryc/admin/leads' }
        };
        event.waitUntil(self.registration.showNotification(title, options));
    } catch (e) {
        console.error('Push error:', e);
    }
});

self.addEventListener('notificationclick', function(event) {
    event.notification.close();
    var url = event.notification.data?.url || '/ryc/admin/leads';
    event.waitUntil(clients.openWindow(url));
});
