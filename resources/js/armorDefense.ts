export const DEFENSE_ELEMENTS = ['fire', 'water', 'thunder', 'ice', 'dragon'] as const;

// `field` is caller supplied (`defense`, `defense_fire`, ...), so a piece here
// only needs to be indexable; `Number()` already tolerates `unknown`, since it
// takes `any`, so nothing narrower is needed and a real `App.Models.Armor`
// (which has no index signature of its own) stays assignable to this.
type ArmorFields = Record<string, unknown>;

/**
 * What a set of pieces adds up to for one field. The tab's totals row and the
 * line in the sheet's header both ask, so the sum lives in one place.
 */
export function totalDefense(armors?: Record<string, ArmorFields> | Array<ArmorFields> | null, field: string = 'defense'): number {
    return Object.values(armors ?? {})
        .reduce((sum, armor) => sum + (Number(armor?.[field]) || 0), 0);
}

export const ARMOR_SLOTS = ['head', 'body', 'leg'] as const;

// `weaponDefense` only reads a worn piece's slot, a safe `Pick` since it
// leaves `type_value`'s declared type untouched.
type ArmorPiece = Pick<App.Models.Armor, 'type_value'>;

type DefaultArmorGrants = Partial<Record<typeof ARMOR_SLOTS[number], number>>;

/**
 * What the weapon in hand is worth as armour. Each type grants a point in one
 * slot, and only while nothing of the hunter's own is worn there, so a piece
 * put on replaces it rather than stacking with it.
 */
export function weaponDefense(
    armors?: Record<string, ArmorPiece> | Array<ArmorPiece> | null,
    defaultArmor?: DefaultArmorGrants | App.Models.WeaponType['default_armor'],
): number {
    if (! defaultArmor) {
        return 0;
    }

    // `WeaponType.default_armor` is a JSON column the generator can only see
    // as `unknown[] | null`; WeaponsSeeder.php:61-63 actually builds it with
    // `array_combine(['head', 'body', 'leg'], ...)`, so at runtime it is the
    // slot-keyed object on the left of the parameter's union, never really an
    // array. The generated type stays in the union rather than replacing it,
    // so a real `WeaponType` is still accepted without a cast on the caller's
    // side; this function narrows it back on the way in instead.
    const grants = defaultArmor as DefaultArmorGrants;

    const worn = new Set(Object.values(armors ?? {}).map((armor) => armor?.type_value));

    return ARMOR_SLOTS.reduce(
        (sum, slot) => sum + (worn.has(slot) ? 0 : (Number(grants[slot]) || 0)),
        0,
    );
}
