// Shared with the global `getRarityColor` mixin (see app.js), which is all a
// template can reach; script code outside a template needs the plain import.
export function getRarityColor(rarity) {
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
