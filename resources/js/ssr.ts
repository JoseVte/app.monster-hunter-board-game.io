import createServer from '@inertiajs/vue3/server';
import {renderPage} from './ssrRender';

// Node exits on an unhandled rejection by default, and this process serves
// every request, so one stray promise in one component (which is exactly what
// `recaptcha-v3` used to leave behind on `/login`) took server rendering away
// from the whole site until something restarted it. Each render is
// independent and holds no state between requests, so logging and carrying on
// is safe here in a way it would not be in a long-lived stateful process.
// Logged to stderr, which is where the supervisor's log picks it up, so the
// fault is still seen rather than swallowed.
process.on('unhandledRejection', (reason) => {
    console.error('[ssr] unhandled rejection, server kept running:', reason);
});

createServer((page) => renderPage(page));
