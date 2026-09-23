import {describe, expect, it} from 'vitest';
import {replaceIcons} from '@/icons';

describe('replaceIcons', () => {
    it('swaps a known token for an img', () => {
        expect(replaceIcons('deals :fire_icon: damage')).toContain('<img');
    });

    // replaceIcons is not a sanitizer: it only rewrites text that matches
    // `:[a-z0-9_]+:`. Anything else, literal markup included, passes through
    // completely unchanged. The reason a token can never smuggle markup in is
    // that the capture group excludes the quote and angle-bracket characters
    // that would be needed to break out of the attributes it is placed into
    // (`title="${label}"`, `src="${icon.src}"`), not that this function
    // strips or escapes arbitrary HTML in the surrounding text. Safety of the
    // `v-html` sink this feeds depends on markdown stripping raw HTML before
    // this ever runs (`Campaign::getDescriptionParsedHtmlAttribute`).
    it('leaves text that is not a valid token alone, script tags included', () => {
        const input = ':<script>alert(1)</script>:';

        expect(replaceIcons(input)).toBe(input);
    });

    // An unmapped token's name is humanised straight into `title="${label}"`.
    // The capture group restricts a name to [a-z0-9_], so there is no way for
    // it to contain the quote that would be needed to break out of that
    // attribute, whatever the token author writes.
    it('cannot use a token name to break out of the title attribute it lands in', () => {
        const output = replaceIcons(':quote_breaking_attempt_icon:');

        expect(output).toContain('title="Quote breaking attempt icon"');
    });

    // A `*_resistance_icon` token is a lookup into a separate `resistances`
    // map and goes through `resistance()`, not the plain `icons` lookup that
    // the other tests exercise: it renders a pentagon badge (`mh-resistance`
    // classes plus an inline `<svg>`), not a bare `<img>`.
    it('substitutes a resistance token through the resistance badge', () => {
        const output = replaceIcons(':fire_resistance_icon:');

        expect(output).toContain('mh-resistance-fire');
        expect(output).toContain('<svg');
    });

    // Not every token ends in _icon: the data also writes :charged_blade_vial:,
    // :kinsect_icon_1: and :deviation_icon_high:.
    it('matches a token that does not end in _icon', () => {
        expect(replaceIcons(':charged_blade_vial:')).not.toContain(':charged_blade_vial:');
    });

    it('renders a labelled badge rather than raw text for a token with no artwork', () => {
        const output = replaceIcons(':some_unmapped_token:');

        expect(output).not.toContain(':some_unmapped_token:');
        expect(output).toContain('Some unmapped token');
    });

    it('leaves text with no token alone', () => {
        expect(replaceIcons('plain text')).toBe('plain text');
    });

    // typeof text !== 'string' short-circuits to returning the input itself
    // unchanged, not an empty string.
    it('returns a nullish input unchanged rather than an empty string', () => {
        expect(replaceIcons(null)).toBe(null);
    });
});
