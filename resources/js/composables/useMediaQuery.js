import { onUnmounted, readonly, ref } from 'vue';

/**
 * Both armour layouts hold a card for every piece, and a card holds a craft
 * modal, so switching between them with `hidden md:grid` rendered the whole set
 * twice: 2300 of the sheet's 5800 nodes and 51 modals existed only to be hidden.
 * This lets a component render one of the two.
 *
 * Without a window, which is the server, the answer is the wide layout: it is
 * the canonical one, and the client corrects it on hydration.
 */
export function useMediaQuery(query) {
    if (typeof window === 'undefined' || ! window.matchMedia) {
        return readonly(ref(true));
    }

    const media = window.matchMedia(query);
    const matches = ref(media.matches);
    const update = (event) => {
        matches.value = event.matches;
    };

    media.addEventListener('change', update);
    onUnmounted(() => media.removeEventListener('change', update));

    return readonly(matches);
}
