import { onUnmounted, readonly, ref } from 'vue';
import type { Ref } from 'vue';

/**
 * Both armour layouts hold a card for every piece, and a card holds a craft
 * modal, so switching between them with `hidden md:grid` rendered the whole set
 * twice: 2300 of the sheet's 5800 nodes and 51 modals existed only to be hidden.
 * This lets a component render one of the two.
 *
 * Without a window, which is the server, the answer is the wide layout: it is
 * the canonical one, and the client corrects it on hydration.
 *
 * The return type is written out because the two branches build their ref from
 * two different literals (a bare `true`, `media.matches`) and, without an
 * explicit annotation, TypeScript infers a return type per branch and only
 * unions them at the call site, so a caller that does not need both would still
 * see one. Both are `Readonly<Ref<boolean>>` already; naming it here pins that
 * rather than leaving it to agree by accident.
 */
export function useMediaQuery(query: string): Readonly<Ref<boolean>> {
    if (typeof window === 'undefined' || ! window.matchMedia) {
        return readonly(ref(true));
    }

    const media = window.matchMedia(query);
    const matches = ref(media.matches);
    const update = (event: MediaQueryListEvent) => {
        matches.value = event.matches;
    };

    media.addEventListener('change', update);
    onUnmounted(() => media.removeEventListener('change', update));

    return readonly(matches);
}
