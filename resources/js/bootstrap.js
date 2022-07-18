import _ from 'lodash';
window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    wsHost: window.location.hostname,
    wsPort: import.meta.env.VITE_APP_ENV === 'local' ? 6001 : 2053,
    wssPort: import.meta.env.VITE_APP_ENV === 'local' ? 6001 : 2053,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: import.meta.env.VITE_APP_ENV !== 'local',
    enabledTransports: ['ws'],
});

let firstConnection = false;

window.Echo.connector.pusher.connection.bind('connected', () => {
    if (firstConnection === false) {
        firstConnection = true;
        return;
    }

    window.Echo.connector.pusher.connection.emit('reconnected')
})
