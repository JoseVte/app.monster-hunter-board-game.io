import { onMounted } from 'vue';
import { load } from 'recaptcha-v3';
import type { ReCaptchaInstance } from 'recaptcha-v3';

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
 * script once. `recaptcha-v3` types `load()` as `Promise<ReCaptchaInstance>`
 * already (dist/ReCaptcha.d.ts); this only has to say what it holds before the
 * first call, since a bare `null` initialiser would otherwise infer the
 * variable's type as `null` forever.
 */
let loading: Promise<ReCaptchaInstance> | null = null;

/**
 * The script is loaded from `onMounted`, never from `setup` itself.
 *
 * `setup` runs on the SSR server too, and there `recaptcha-v3`'s `load()`
 * returns a rejected promise ("This is a library for the browser!"). Nothing
 * awaits it during a render, so it surfaced as an unhandled rejection, and
 * Node's default for those is to exit: the first visit to `/login` with SSR
 * on took the whole SSR process down, and every page after it fell back to
 * client rendering until something restarted it. `onMounted` only ever runs in
 * a browser, which is the only place the script can live anyway.
 *
 * Loading on mount rather than on submit is deliberate: v3 scores how a visitor
 * behaves on the page before the action, so it wants to be there from the
 * start. `execute` loads it itself as well, so a submit can never race a mount
 * that has not happened.
 */
export function useRecaptcha(siteKey: string) {
    const ready = () => (loading ??= load(siteKey, { autoHideBadge: true }));

    onMounted(ready);

    return {
        execute: async (action: string) => (await ready()).execute(action),
    };
}
