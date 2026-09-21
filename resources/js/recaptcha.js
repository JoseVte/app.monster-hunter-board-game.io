import { load } from 'recaptcha-v3';

/**
 * reCAPTCHA, loaded when a form asks for it rather than on every page.
 *
 * The vue-recaptcha-v3 plugin was installed on the app in app.js, and its
 * install() calls load() straight away, so Google's script and its _GRECAPTCHA
 * cookie arrived on the wiki, the dashboard and the public page alike. Only the
 * forms that verify a token need it, and a cookie set for an anti-fraud purpose
 * is only arguably exempt from consent while it stays on the pages that need it.
 *
 * The badge stays hidden. Google asks for the badge *or* a visible attribution,
 * and the forms render RecaptchaNotice instead, so `autoHideBadge` is doing the
 * whole job here and nothing calls showBadge(). Drop that component from a form
 * and this stops holding up its end of Google's terms.
 *
 * The promise is kept at module scope so that moving between two forms loads the
 * script once.
 */
let loading = null;

export function useRecaptcha(siteKey) {
    loading ??= load(siteKey, { autoHideBadge: true });

    return {
        execute: async (action) => (await loading).execute(action),
    };
}
