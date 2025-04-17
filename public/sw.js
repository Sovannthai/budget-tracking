self.addEventListener('install', event => {
  self.skipWaiting();
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          return caches.delete(cacheName);
        })
      );
    }).then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', event => {
  // Only process GET requests and ignore non-HTTP requests
  if (event.request.method !== 'GET' || !event.request.url.startsWith('http')) {
    return;
  }

  event.respondWith(
    // Create a new Request object to avoid reusing the original request
    fetch(new Request(event.request.url, {
      method: event.request.method,
      headers: new Headers(event.request.headers),
      mode: event.request.mode === 'navigate' ? 'cors' : event.request.mode,
      credentials: event.request.credentials,
      redirect: event.request.redirect
    }))
    .then(response => {
      return response;
    })
    .catch(error => {
      console.error('Fetch error:', error);
      return new Response('Network error', {
        status: 503,
        statusText: 'Service Unavailable'
      });
    })
  );
}); 