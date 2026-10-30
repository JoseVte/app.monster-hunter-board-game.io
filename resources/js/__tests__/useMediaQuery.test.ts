import {afterEach, describe, expect, it, vi} from 'vitest';
import {defineComponent, h} from 'vue';
import {mount} from '@vue/test-utils';
import {useMediaQuery} from '@/composables/useMediaQuery';

// The armour tab renders one of two layouts from this, so it has to follow the
// screen as it changes and let go of the listener when the tab goes away.

type Listener = (event: MediaQueryListEvent) => void;

const fakeMedia = (matches: boolean) => {
    const listeners = new Set<Listener>();
    const media = {
        matches,
        addEventListener: vi.fn((_: string, listener: Listener) => listeners.add(listener)),
        removeEventListener: vi.fn((_: string, listener: Listener) => listeners.delete(listener)),
        fire: (next: boolean) => listeners.forEach((listener) => listener({matches: next} as MediaQueryListEvent)),
        listeners,
    };

    vi.spyOn(window, 'matchMedia').mockReturnValue(media as unknown as MediaQueryList);

    return media;
};

const host = (query: string) => {
    let result: ReturnType<typeof useMediaQuery> | undefined;
    const wrapper = mount(defineComponent({
        setup() {
            result = useMediaQuery(query);

            return () => h('span', String(result!.value));
        },
    }));

    return {wrapper, result: result!};
};

afterEach(() => {
    vi.restoreAllMocks();
});

describe('useMediaQuery', () => {
    it('starts from what the screen matches now', () => {
        fakeMedia(false);

        expect(host('(min-width: 768px)').result.value).toBe(false);
        expect(window.matchMedia).toHaveBeenCalledWith('(min-width: 768px)');
    });

    it('follows the screen as it changes', async () => {
        const media = fakeMedia(false);
        const {wrapper, result} = host('(min-width: 768px)');

        media.fire(true);
        await wrapper.vm.$nextTick();

        expect(result.value).toBe(true);
        expect(wrapper.text()).toBe('true');
    });

    it('stops listening once the component is gone', () => {
        const media = fakeMedia(true);
        const {wrapper} = host('(min-width: 768px)');

        expect(media.listeners.size).toBe(1);
        wrapper.unmount();

        expect(media.listeners.size).toBe(0);
        expect(media.removeEventListener).toHaveBeenCalledTimes(1);
    });

    it('answers with the wide layout where there is no matchMedia, as on the server', () => {
        const original = window.matchMedia;
        // @ts-expect-error: removed on purpose, the way a server or an old browser has none
        window.matchMedia = undefined;

        try {
            expect(host('(min-width: 768px)').result.value).toBe(true);
        } finally {
            window.matchMedia = original;
        }
    });

    it('cannot be written to from outside', () => {
        fakeMedia(false);
        const warn = vi.spyOn(console, 'warn').mockImplementation(() => undefined);
        const {result} = host('(min-width: 768px)');

        (result as {value: boolean}).value = true;

        expect(result.value).toBe(false);
        expect(warn).toHaveBeenCalled();
    });
});
