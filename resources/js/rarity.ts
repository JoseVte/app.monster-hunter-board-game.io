// Shared with the global `getRarityColor` mixin (see app.js), which is all a
// template can reach; script code outside a template needs the plain import.
//
// `rarity` is `App.Models.Weapon['rarity']` / `App.Models.Armor['rarity']`
// (both plain `number`), made optional here because a caller reaches for this
// before checking whether it has a weapon or armour to ask at all (see the
// slot lookups in ArmorBranchGrid.vue and ListArmorType.vue).
export function getRarityColor(rarity?: number): string {
    switch (rarity) {
    case 1:
        return 'text-gray-400 dark:text-gray-300';
    case 2:
        return 'text-lime-600';
    case 3:
        return 'text-green-600';
    case 4:
        return 'text-blue-500';
    case 5:
        return 'text-orange-500';
    default:
        return 'text-black dark:text-white';
    }
}
