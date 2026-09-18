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

// Pusher is the only broadcaster. Reverb was configured alongside it and never
// used, so it was carrying two code paths and two sets of env vars for one.
//
// Echo is only wired up when a key is configured. Without the guard an
// unconfigured environment opens a socket to an app that does not answer and
// retries for as long as the page is open, filling the console.
const key = import.meta.env.VITE_PUSHER_APP_KEY;

if (key) {
    window.Pusher = Pusher;

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
        forceTLS: import.meta.env.VITE_PUSHER_SCHEME !== 'http',
    });
}
