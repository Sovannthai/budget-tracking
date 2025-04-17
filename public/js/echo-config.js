// Echo configuration file
(function() {
    const keyEl = document.querySelector('meta[name="reverb-key"]');
    const hostEl = document.querySelector('meta[name="reverb-host"]');
    const portEl = document.querySelector('meta[name="reverb-port"]');
    const schemeEl = document.querySelector('meta[name="reverb-scheme"]');
    const csrfEl = document.querySelector('meta[name="csrf-token"]');

    if (typeof Pusher === 'undefined') {
        console.error('Pusher not loaded - make sure you include pusher.js before echo-config.js');
        return;
    }

    if (typeof Echo === 'undefined') {
        console.error('Echo not loaded - make sure you include echo.iife.js before echo-config.js');
        return;
    }

    // Set CSRF token for axios
    if (window.axios && csrfEl) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfEl.getAttribute('content');
    }

    // Get config values from meta tags
    const key = keyEl ? keyEl.getAttribute('content') : null;
    const host = hostEl ? hostEl.getAttribute('content') : 'localhost';
    const port = portEl ? portEl.getAttribute('content') : 6001;
    const scheme = schemeEl ? schemeEl.getAttribute('content') : 'http';
    const forceTLS = scheme === 'https';

    if (!key) {
        console.error('Reverb key not found - make sure you have a meta tag with name="reverb-key"');
        return;
    }

    console.log('Initializing Echo with configuration:', {
        broadcaster: 'pusher',
        key: key,
        wsHost: host,
        wsPort: port,
        forceTLS: forceTLS
    });

    // Create Echo instance
    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: key,
        wsHost: host,
        wsPort: port,
        wssPort: port,
        forceTLS: forceTLS,
        enabledTransports: ['ws', 'wss'],
        disableStats: true,
        encrypted: true,
        cluster: 'mt1',
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': csrfEl ? csrfEl.getAttribute('content') : '',
            },
        }
    });

    // Add connection event handlers for debugging
    const pusher = window.Echo.connector.pusher;
    
    pusher.connection.bind('connected', () => {
        console.log('Successfully connected to Pusher/Echo');
    });
    
    pusher.connection.bind('error', error => {
        console.error('Pusher connection error:', error);
    });

    console.log('Echo initialized with:', { 
        broadcaster: 'pusher',
        key: key,
        wsHost: host,
        wsPort: port,
        forceTLS: forceTLS
    });
})(); 