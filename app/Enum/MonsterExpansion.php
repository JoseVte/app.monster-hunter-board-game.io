<?php

namespace App\Enum;

use App\Enum\Traits\TranslatableEnum;
use App\Enum\Contracts\TranslatableEnum as TranslatableEnumContract;

enum MonsterExpansion implements TranslatableEnumContract
{
    use TranslatableEnum;

    case ANCIENT_FOREST;
    case WILDSPIRE_WASTE;
    case KULU_YA_KU_EXPANSION;
    case PICKING_BONES;
    case TEOSTRA_EXPANSION;
    case NERGIGANTE_EXPANSION;
    case KUSHALA_EXPANSION;

    case KIRIN_EXPANSION;

    public function label(?string $locale = null): string
    {
        return match ($this) {
            self::ANCIENT_FOREST => __('Ancient Forest', [], $locale),
            self::WILDSPIRE_WASTE => __('Wildspire Waste', [], $locale),
            self::KULU_YA_KU_EXPANSION => __('Kulu-Ya-Ku Expansion', [], $locale),
            self::PICKING_BONES => __('Picking Bones Expansion', [], $locale),
            self::TEOSTRA_EXPANSION => __('Teostra Expansion', [], $locale),
            self::NERGIGANTE_EXPANSION => __('Nergigante Expansion', [], $locale),
            self::KUSHALA_EXPANSION => __('Kushala Expansion', [], $locale),
            self::KIRIN_EXPANSION => __('Kirin Expansion', [], $locale),
        };
    }

    /**
     * How many days this expansion adds to a campaign's timer.
     *
     * The base campaign is 25 days (`Campaign::BASE_MAX_DAYS`) and an expansion
     * either lengthens it or does not. The number is a rule of the game, so it
     * lives with the expansion rather than in `config/`, where nothing would
     * notice a case being renamed out from under it.
     *
     * Zero is the honest answer for the seven below, not a placeholder: the
     * rulebook text for them has not been entered yet, and
     * `CampaignExpansionDaysTest` fails the moment one of them gains rules in
     * `resources/lang/en/campaign-rules.php` that mention a day count without
     * this method being taught about it.
     */
    public function extraCampaignDays(): int
    {
        return match ($this) {
            self::KULU_YA_KU_EXPANSION, self::KIRIN_EXPANSION, self::KUSHALA_EXPANSION, self::NERGIGANTE_EXPANSION, self::TEOSTRA_EXPANSION => 5,
            self::PICKING_BONES => 15,
            default => 0,
        };
    }

    /**
     * Whether this is one of the two boxes a campaign can be played out of on
     * its own, rather than something added to one.
     *
     * The Ancient Forest and the Wildspire Waste are each a complete game; a
     * campaign uses one or the other or both, and the six below are add-ons
     * that need one of them underneath. The enum makes no distinction between
     * the two kinds anywhere else, because everywhere else (a monster's box, a
     * weapon recipe's, an armour's) the question is only which box a thing
     * came out of.
     */
    public function isBaseGame(): bool
    {
        return match ($this) {
            self::ANCIENT_FOREST, self::WILDSPIRE_WASTE => true,
            default => false,
        };
    }

    /**
     * The box a new campaign starts out ticked with.
     *
     * Named here rather than written into the create form, so that renaming
     * the case moves the default with it instead of leaving the form holding a
     * string that matches nothing and failing validation on first submit.
     * The Ancient Forest is the one most people own; whoever plays out of the
     * Wildspire Waste unticks it.
     */
    public static function defaultCampaignBox(): self
    {
        return self::ANCIENT_FOREST;
    }

    /**
     * The case names of the boxes a campaign can be played out of.
     *
     * @return array<int, string>
     */
    public static function baseGameNames(): array
    {
        return array_values(array_map(
            fn (self $expansion): string => $expansion->name,
            array_filter(self::cases(), fn (self $expansion): bool => $expansion->isBaseGame()),
        ));
    }

    /**
     * The shape the campaign create and edit forms read: the name to show, the
     * key the campaign stores, whether it is a box that stands on its own, and
     * what ticking it does to the timer.
     *
     * @return array<int, array{key: string, label: string, base_game: bool, extra_days: int}>
     */
    public static function asCampaignOptions(): array
    {
        return array_map(fn (self $expansion): array => [
            'key' => $expansion->name,
            'label' => $expansion->label(),
            'base_game' => $expansion->isBaseGame(),
            'extra_days' => $expansion->extraCampaignDays(),
        ], self::cases());
    }
}
