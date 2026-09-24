<script setup lang="ts">
import {h} from "vue";
import {Link} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import WeaponsIcon from "@/Components/Icons/WeaponsIcon.vue";
import Card from "@/Components/Card.vue";
import WeaponTypeIcon from "@/Components/WeaponTypeIcon.vue";
import CraftWithHunter from "@/Pages/Wiki/Partials/CraftWithHunter.vue";
import WeaponStats from "@/Components/WeaponStats.vue";
import AverageDamage from "@/Components/AverageDamage.vue";
import SongNotes from "@/Components/SongNotes.vue";
import rangeIcon from '~/icons/range-icon.png';
import {getRarityColor} from "@/rarity";

// `WeaponRecipe::items()`, `Weapon::attacksToAdd()` and `Weapon::attacksToRemove()`
// each `withPivot(['number'])`, so every entry Laravel sends through them
// carries a `pivot.number` the generated `Item`/`WeaponAttack` types do not
// declare (a `belongsToMany` pivot is not part of either model's own columns).
// `Pick<App.Models.Pivot.CountItemWeapon, 'number'>` would in fact be
// structurally identical to the `{number: number}` declared below: a
// single-key `Pick` carries none of the source type's other fields along
// with it, so that is not the reason to leave it unused. The reason is that
// three different pivot tables are in play here (`CountItemWeapon`,
// `CountWeaponAttackAdd`, `CountWeaponAttackRemove`), and naming any one of
// them to stand for all three would credit it with a relationship to the
// other two that does not exist: they only ever share the `number` column,
// never a table. The literal spares a reader the question of why this
// particular one of three was picked.
// `WeaponRecipe::items()` is the sharper case: its own foreign pivot key is
// `weapon_recipe_id` (Eloquent's default from the "WeaponRecipe" model name),
// not `weapon_id`, even though both columns exist on `count_item_weapon` (see
// `CountItemWeapon`'s own docblock: `weapon_id` is there for `Weapon::items()`
// to use instead). So `recipe.items[].pivot` at runtime is
// `{weapon_recipe_id, item_id, number, created_at, updated_at}`, no `id` and
// no `weapon_id`; `weapon.attacks_to_add/remove[].pivot` is
// `{weapon_id, weapon_attack_id, number, created_at, updated_at}`, no `id`.
// Declared as the one field this page actually reads, matching
// `resources/js/__tests__/fixtures.ts`'s own `{...item, pivot: {number: 3}}`.
// Report: this is a `ModelShape` gap, not a controller-composed prop.
type ItemWithPivot = App.Models.Item & {pivot: {number: number}};
type WeaponAttackWithPivot = App.Models.WeaponAttack & {pivot: {number: number}};

type WeaponRecipeWithPivotItems = Omit<App.Models.WeaponRecipe, 'items'> & {
    items?: ItemWithPivot[];
};

type WeaponDetail = Omit<App.Models.Weapon, 'recipes' | 'attacks_to_add' | 'attacks_to_remove'> & {
    recipes?: WeaponRecipeWithPivotItems[];
    attacks_to_add?: WeaponAttackWithPivot[];
    attacks_to_remove?: WeaponAttackWithPivot[];
};

type MissingItem = {name: string; missing: number};

// `WeaponController::hunters()`'s own shape; no model backs it, and it is
// declared again here (rather than imported from `CraftWithHunter.vue`,
// which has no exports) because the brief's rule is to declare these locally
// per page.
type WeaponCraftableHunter = {
    id: number;
    name: string;
    campaign: string;
    campaign_id: number;
    can_craft: boolean;
    owned: boolean;
    craftable_recipes: number[];
    missing_by_recipe: Record<number, MissingItem[]>;
    parent_owned: boolean | null;
};

const props = withDefaults(defineProps<{
    weapon: WeaponDetail;
    hunters?: WeaponCraftableHunter[];
}>(), {
    hunters: () => [],
});

// Breadcrumb's icon slots want a component, not a URL or a rarity to tint by,
// so the type's plain icon and this weapon's own rarity-tinted one are each
// wrapped in one.
const typeIcon = () => h('img', {src: props.weapon.type?.image_url, alt: props.weapon.type?.name});
const currentIcon = () => h(WeaponTypeIcon, {weaponType: props.weapon.type, class: getRarityColor(props.weapon.rarity)});
</script>

<template>
    <AppLayout :title="weapon.name">
        <template #header>
            <Breadcrumb
                :current-title="weapon.name"
                :breadcrumbs="[
                    { url: route('wiki.index'), title: $t('Wiki') },
                    { url: route('wiki.weapon.index'), title: $t('Weapons'), icon: WeaponsIcon },
                    { url: route('wiki.weapon.type', [weapon.type_id]), title: weapon.type?.name ?? '', icon: typeIcon },
                ]"
                :icon="currentIcon"
            />
        </template>

        <div class="py-6 sm:py-12">
            <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                <!-- The weapon as the component prints it: what it brings to the
                     stamina board, what it costs and where it sits in its line. -->
                <Card class="gap-3 p-5">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 min-h-10 min-w-10 items-center justify-center rounded-full bg-gray-300 dark:bg-gray-900">
                            <WeaponTypeIcon
                                :weapon-type="weapon.type"
                                class="h-5 w-5"
                                :class="getRarityColor(weapon.rarity)"
                            />
                        </span>
                        <span class="mh-card-name flex-1 text-xl">{{ weapon.name }}</span>
                        <AverageDamage :weapon="weapon" />
                        <Link
                            class="mh-value"
                            :class="getRarityColor(weapon.rarity)"
                            :href="route('wiki.weapon.type', [weapon.type_id, { rarity: weapon.rarity }])"
                        >
                            {{ $t('Rarity') }} {{ weapon.rarity }}
                        </Link>
                    </div>

                    <div class="mh-rule" />

                    <WeaponStats :weapon="weapon" />

                    <!-- Only a hunting horn plays any, and the list printed on
                         its card is what its three songs come from, so the list
                         names this section the way a branch names the materials
                         one. The type's page carries all ten. -->
                    <template v-if="weapon.song_list?.songs?.length">
                        <h3 class="mh-heading mt-2 text-xs tracking-widest uppercase">
                            <Link
                                class="hover:underline"
                                :href="route('wiki.weapon.type', [weapon.type_id])"
                            >
                                {{ weapon.song_list.name }}
                            </Link>
                        </h3>

                        <ul class="flex flex-col gap-3">
                            <li
                                v-for="song in weapon.song_list.songs"
                                :key="song.id"
                                class="flex flex-col gap-1 sm:flex-row sm:items-start sm:gap-4"
                            >
                                <SongNotes
                                    :notes="song.notes"
                                    class="sm:mt-0.5"
                                />

                                <div class="min-w-0 flex-1">
                                    <p class="flex items-center gap-2 text-sm font-semibold text-gray-900 dark:text-parchment">
                                        {{ song.effect?.name }}
                                        <!-- Range 0 is the hunter alone, so there
                                             is no reach worth printing. -->
                                        <span
                                            v-if="song.range"
                                            class="mh-value text-xs"
                                            :title="$t('Range')"
                                        >
                                            <img
                                                :src="rangeIcon"
                                                :alt="$t('Range')"
                                                class="h-4 w-4"
                                            >
                                            {{ song.range }}
                                        </span>
                                    </p>
                                    <p
                                        class="mh-rules"
                                        v-html="replaceIcons(song.effect?.description)"
                                    />
                                </div>
                            </li>
                        </ul>
                    </template>

                    <!-- Most weapons are made one way. Two dual blades can be
                         built from either of two monsters, at different prices. -->
                    <template
                        v-for="recipe in weapon.recipes ?? []"
                        :key="recipe.id"
                    >
                        <h3 class="mh-heading mt-2 text-xs tracking-widest uppercase">
                            <Link
                                v-if="recipe.branch"
                                class="hover:underline"
                                :href="route('wiki.weapon.type', [weapon.type_id, { branch: recipe.branch }])"
                            >
                                {{ recipe.branch }}
                            </Link>
                            <template v-else>
                                {{ $t('Materials') }}
                            </template>
                            <Link
                                v-if="recipe.expansion"
                                class="text-parchment-dim hover:underline"
                                :href="route('wiki.weapon.type', [weapon.type_id, { expansion: recipe.expansion }])"
                            >
                                · {{ recipe.expansion_label }}
                            </Link>
                        </h3>
                        <ul class="flex flex-col gap-1 text-sm">
                            <li
                                v-for="item in recipe.items ?? []"
                                :key="item.id"
                                class="flex items-center justify-between gap-3"
                            >
                                <Link
                                    :href="route('wiki.item.show', [item.id])"
                                    class="text-gray-900 hover:underline dark:text-parchment"
                                >
                                    {{ item.name }}
                                </Link>
                                <span class="mh-value">{{ item.pivot.number }}</span>
                            </li>
                        </ul>
                    </template>

                    <!-- What this weapon does to the attack deck, not just what it
                         costs: the cards it takes out and the ones it brings in. -->
                    <template v-if="weapon.attacks_to_remove?.length || weapon.attacks_to_add?.length">
                        <h3 class="mh-heading mt-2 text-xs tracking-widest uppercase">
                            {{ $t('Attack cards') }}
                        </h3>
                        <div class="flex flex-col gap-2 text-sm">
                            <div v-if="weapon.attacks_to_remove?.length">
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    {{ $t('Removes') }}
                                </p>
                                <ul class="flex flex-col gap-1">
                                    <li
                                        v-for="attack in weapon.attacks_to_remove"
                                        :key="attack.id"
                                        class="flex items-center justify-between gap-3"
                                    >
                                        <span class="text-gray-900 dark:text-parchment">{{ attack.name }}</span>
                                        <span class="mh-value">{{ attack.pivot.number }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div v-if="weapon.attacks_to_add?.length">
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    {{ $t('Adds') }}
                                </p>
                                <ul class="flex flex-col gap-1">
                                    <li
                                        v-for="attack in weapon.attacks_to_add"
                                        :key="attack.id"
                                        class="flex items-center justify-between gap-3"
                                    >
                                        <span class="text-gray-900 dark:text-parchment">{{ attack.name }}</span>
                                        <span class="mh-value">{{ attack.pivot.number }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </template>

                    <div class="mh-rule mt-2" />

                    <dl class="flex flex-wrap gap-x-6 gap-y-1 text-sm text-gray-600 dark:text-gray-400">
                        <div
                            v-if="weapon.parent"
                            class="flex gap-2"
                        >
                            <dt>{{ $t('Upgrades from') }}</dt>
                            <dd>
                                <Link
                                    :href="route('wiki.weapon.show', [weapon.parent.id])"
                                    class="text-gray-900 underline dark:text-parchment"
                                >
                                    {{ weapon.parent.name }}
                                </Link>
                            </dd>
                        </div>
                        <div
                            v-if="weapon.children?.length"
                            class="flex flex-wrap gap-2"
                        >
                            <dt>{{ $t('Upgrades to') }}</dt>
                            <dd
                                v-for="child in weapon.children"
                                :key="child.id"
                            >
                                <Link
                                    :href="route('wiki.weapon.show', [child.id])"
                                    class="text-gray-900 underline dark:text-parchment"
                                >
                                    {{ child.name }}
                                </Link>
                            </dd>
                        </div>
                    </dl>
                </Card>

                <CraftWithHunter
                    :hunters="hunters"
                    :weapon="weapon"
                />
            </div>
        </div>
    </AppLayout>
</template>
