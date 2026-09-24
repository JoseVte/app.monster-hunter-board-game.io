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

export function useRecaptcha(siteKey: string) {
    loading ??= load(siteKey, { autoHideBadge: true });

    // Captured in a local so `execute` closes over a value TypeScript knows is
    // non-null. `loading` itself is a mutable module-scope `let`; control flow
    // analysis does not carry the narrowing from the `??=` above into a closure
    // that reads the outer variable directly, since another call to this
    // function could reassign it before `execute` runs. A fresh `const` has no
    // such future reassignment to guard against, so the narrowing holds.
    const instance = loading;

    return {
        execute: async (action: string) => (await instance).execute(action),
    };
}
