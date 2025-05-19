self.addEventListener('install', e => {
    e.waitUntil(
        caches.open('inventory-cache').then(cache => {
            return cache.addAll([
                '/public/index.php',
                '/public/add_edit.php',
                '/public/log.php'
            ]);
        })
    );
});

self.addEventListener('fetch', e => {
    e.respondWith(
        caches.match(e.request).then(res => res || fetch(e.request))
    );
});