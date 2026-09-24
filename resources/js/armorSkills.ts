// `bonus_set_armor` is kept at its generated type here rather than narrowed to
// `number[]`: a `Pick` only stays safe, meaning a real `App.Models.Armor`
// keeps satisfying `ArmorLike`, while it leaves each field's declared type
// alone. Every real caller (`hunter.equipped_armors` in Hunter/Show.vue and
// ActiveSkills.vue) holds a full `Armor`, and narrowing this field here would
// make that assignment fail.
type SkillLike = Pick<App.Models.ArmorSkill, 'id' | 'bonus_set' | 'bonus_set_armor'>;

type ArmorLike = Pick<App.Models.Armor, 'id' | 'type_value'> & {skills?: Array<SkillLike>};

/**
 * What a set of worn pieces actually grants. A piece carries at most one skill,
 * and a set bonus only counts once every piece of its monster is on, so an
 * incomplete one comes back marked rather than left out.
 *
 * The tab's panel and the line in the sheet's header both ask, so the rule for
 * what counts as active lives in one place.
 */
export function equippedSkills(
    armors?: Record<string, ArmorLike> | Array<ArmorLike> | null,
): Array<{skill: SkillLike, slot: string | undefined, active: boolean}> {
    const worn = Object.values(armors ?? {});
    const ids = worn.map((armor) => armor.id);

    return worn.flatMap((armor) => (armor.skills ?? []).map((skill) => {
        // ArmorsSeeder.php:75 writes armour ids here (`$bonusSet[] =
        // $armor->id`); tests/Feature/Seeders/ArmorSetBonusTest.php pins that
        // the column holds ids, not names, which is what commit 9c6b7d9 fixed
        // after ArmorSkillsSeeder briefly wrote armour names into it instead.
        // `bonus_set_armor` is `unknown[] | null` only because it is a JSON
        // column the generator cannot see inside of, so the cast is safe.
        const bonusSetArmor = (skill.bonus_set_armor ?? []) as number[];

        return {
            skill,
            slot: armor.type_value,
            active: ! skill.bonus_set || bonusSetArmor.every((id) => ids.includes(id)),
        };
    }));
}
