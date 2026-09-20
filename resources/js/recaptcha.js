import { onUnmounted } from 'vue';
import { load } from 'recaptcha-v3';

/**
 * reCAPTCHA, loaded when a form asks for it rather than on every page.
 *
 * The vue-recaptcha-v3 plugin was installed on the app in app.js, and its
 * install() calls load() straight away, so Google's script and its _GRECAPTCHA
 * cookie arrived on the wiki, the dashboard and the public page alike. Only the
 * login and register forms verify a token, and a cookie set for an anti-fraud
 * purpose is only arguably exempt from consent while it stays on the pages that
 * need it.
 *
 * The promise is kept at module scope so that going from login to register and
 * back loads the script once.
 */
let loading = null;

export function useRecaptcha(siteKey) {
    let instance = null;

    loading ??= load(siteKey, { autoHideBadge: true });

    // Showing the badge is not decoration: Google requires either the badge or
    // a visible attribution on any page that runs this. autoHideBadge keeps it
    // out of the way everywhere else.
    loading.then((recaptcha) => {
        instance = recaptcha;
        recaptcha.showBadge();
    });

    onUnmounted(() => instance?.hideBadge());

    return {
        execute: async (action) => (await loading).execute(action),
    };
}
