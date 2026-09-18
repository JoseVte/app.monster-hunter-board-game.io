import { router } from '@inertiajs/vue3';

const tagId = import.meta.env.VITE_GOOGLE_ANALYTICS_KEY;

// Long enough to outlast the fetch of a page chunk on a slow connection. It only
// ever elapses when two consecutive pages share a title, in which case the title
// on the document is already the right one to report.
const headSettleTimeout = 2000;

let pendingObserver = null;
let pendingTimeout = null;

function gtag() {
    window.dataLayer.push(arguments);
}

function sendPageview() {
    stopWaiting();

    gtag('event', 'page_view', {
        page_title: document.title,
        page_location: window.location.href,
    });
}

function stopWaiting() {
    pendingObserver?.disconnect();
    clearTimeout(pendingTimeout);

    pendingObserver = null;
    pendingTimeout = null;
}

// Inertia writes the new title from a debounced callback scheduled during render,
// so it lands after the navigate event and after the page chunk has been fetched.
// Any fixed delay loses that race and reports the previous page's title, and it
// skips the write altogether when the new title equals the old one, which is what
// the timeout covers.
function sendPageviewOnceTitleSettles() {
    stopWaiting();

    pendingObserver = new MutationObserver((mutations) => {
        const touchedTitle = mutations.some((mutation) => [
            ...mutation.addedNodes,
            mutation.target,
        ].some((node) => node.nodeName === 'TITLE' || node.parentNode?.nodeName === 'TITLE'));

        if (touchedTitle) {
            sendPageview();
        }
    });

    pendingObserver.observe(document.head, {
        childList: true,
        subtree: true,
        characterData: true,
    });

    pendingTimeout = setTimeout(sendPageview, headSettleTimeout);
}

// Inertia never reloads the document, so the tag would only ever see the first
// page. Sending the view by hand on every visit is why send_page_view is off.
// The navigate event covers the first visit too, so there is nothing to send up
// front.
export function startAnalytics() {
    if (! tagId || ! import.meta.env.PROD) {
        return;
    }

    window.dataLayer = window.dataLayer || [];

    const script = document.createElement('script');
    script.async = true;
    script.src = `https://www.googletagmanager.com/gtag/js?id=${tagId}`;
    document.head.append(script);

    gtag('js', new Date());
    gtag('config', tagId, {
        anonymize_ip: true,
        send_page_view: false,
    });

    router.on('navigate', sendPageviewOnceTitleSettles);
}
