/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo subscribes to the channels Laravel broadcasts on. Reverb speaks the
 * Pusher protocol, so both connections share this client and only differ in
 * where they point: Reverb at the local Herd server, Pusher at their cloud.
 *
 * VITE_BROADCAST_CONNECTION mirrors BROADCAST_CONNECTION on the server. With
 * neither set, Echo is not started at all, which is the state the app has been
 * in so far: nothing broadcasts yet.
 */

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

const connection = import.meta.env.VITE_BROADCAST_CONNECTION;

if (connection === 'reverb' || connection === 'pusher') {
    window.Pusher = Pusher;

    const reverb = connection === 'reverb';

    window.Echo = new Echo({
        broadcaster: connection,
        key: reverb ? import.meta.env.VITE_REVERB_APP_KEY : import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
        wsHost: reverb
            ? import.meta.env.VITE_REVERB_HOST
            : (import.meta.env.VITE_PUSHER_HOST || `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`),
        wsPort: Number(reverb ? import.meta.env.VITE_REVERB_PORT : import.meta.env.VITE_PUSHER_PORT) || 80,
        wssPort: Number(reverb ? import.meta.env.VITE_REVERB_PORT : import.meta.env.VITE_PUSHER_PORT) || 443,
        forceTLS: (reverb ? import.meta.env.VITE_REVERB_SCHEME : import.meta.env.VITE_PUSHER_SCHEME) === 'https',
        enabledTransports: ['ws', 'wss'],
    });
}
