/**
 * What a set of worn pieces actually grants. A piece carries at most one skill,
 * and a set bonus only counts once every piece of its monster is on, so an
 * incomplete one comes back marked rather than left out.
 *
 * The tab's panel and the line in the sheet's header both ask, so the rule for
 * what counts as active lives in one place.
 */
export function equippedSkills(armors) {
    const worn = Object.values(armors ?? {});
    const ids = worn.map((armor) => armor.id);

    return worn.flatMap((armor) => (armor.skills ?? []).map((skill) => ({
        skill,
        slot: armor.type_value,
        active: ! skill.bonus_set || (skill.bonus_set_armor ?? []).every((id) => ids.includes(id)),
    })));
}
