<?php

namespace App\Models;

use App\Enum\ItemType;
use App\Models\Pivot\HunterArmor;
use App\Models\Pivot\HunterWeapon;
use Illuminate\Support\Collection;
use App\Models\Pivot\CountItemHunter;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pivot\DayDowntimeActivityHunter;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Hunter extends Model
{
    use EagerLoadPivotTrait;
    use HasFactory;

    protected $fillable = [
        'name',

        'campaign_id',
        'weapon_type_id',
    ];

    /**
     * The rulebook starts everyone on the great sword, and a hunter always has
     * something in hand, so one is put there rather than leaving the column
     * empty until somebody picks.
     */
    protected static function booted(): void
    {
        static::creating(function (self $hunter): void {
            $hunter->weapon_type_id ??= WeaponType::where('name->en', 'Great Sword')->value('id');
        });
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * The type a hunter carries into a hunt. Separate from the favourite weapon
     * kept within each type: only one type goes to the fight.
     */
    public function weaponType(): BelongsTo
    {
        return $this->belongsTo(WeaponType::class);
    }

    public function palico(): HasOne
    {
        return $this->hasOne(Palico::class, 'hunter_id');
    }

    public function days(): BelongsToMany
    {
        return $this->belongsToMany(Day::class, DayDowntimeActivityHunter::class)
            ->withTimestamps()
            ->using(DayDowntimeActivityHunter::class);
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, CountItemHunter::class)
            ->withPivot('number')
            ->withTimestamps()
            ->using(CountItemHunter::class);
    }

    public function weapons(): BelongsToMany
    {
        return $this->belongsToMany(Weapon::class, HunterWeapon::class)
            ->withPivot('equipped')
            ->withTimestamps()
            ->using(HunterWeapon::class);
    }

    public function equippedWeapons(): BelongsToMany
    {
        return $this->belongsToMany(Weapon::class, HunterWeapon::class)
            ->wherePivot('equipped', true)
            ->withPivot('equipped')
            ->withTimestamps()
            ->using(HunterWeapon::class);
    }

    public function armors(): BelongsToMany
    {
        return $this->belongsToMany(Armor::class, HunterArmor::class)
            ->withPivot('equipped')
            ->withTimestamps()
            ->using(HunterArmor::class);
    }

    public function equippedArmors(): BelongsToMany
    {
        return $this->belongsToMany(Armor::class, HunterArmor::class)
            ->wherePivot('equipped', true)
            ->withPivot('equipped')
            ->withTimestamps()
            ->using(HunterArmor::class);
    }

    public function commonItems(): BelongsToMany
    {
        return $this->items()->where('type', ItemType::COMMON->name);
    }

    public function otherItems(): BelongsToMany
    {
        return $this->items()->where('type', ItemType::OTHER->name);
    }

    public function monsterItems(): BelongsToMany
    {
        return $this->items()->where('type', ItemType::MONSTER_PART->name);
    }

    public function getUser(): ?User
    {
        return $this->campaign->users()->wherePivot('hunter_id', $this->id)->first();
    }

    public function canCraftWeapon(Weapon $weapon): bool
    {
        return $this->craftableRecipes($weapon)->isNotEmpty();
    }

    /**
     * A weapon with more than one recipe can be built from whichever the hunter
     * can afford, so this answers which of them those are rather than a bare yes.
     *
     * @return Collection<int, WeaponRecipe>
     */
    public function craftableRecipes(Weapon $weapon): Collection
    {
        if ($weapon->is_default) {
            return collect();
        }

        if ($weapon->parent_id && ! $this->weapons->firstWhere('id', $weapon->parent_id)) {
            return collect();
        }

        return $weapon->recipes->filter(fn (WeaponRecipe $recipe): bool => $this->canAfford($recipe->items))->values();
    }

    /**
     * @param  Collection<int, Item>  $items
     */
    private function canAfford(Collection $items): bool
    {
        return $this->missingItems($items)->isEmpty();
    }

    /**
     * The gap between what a recipe or an armour needs and what the hunter
     * carries, only the items actually short. An empty list says the materials
     * are not what is holding this back.
     *
     * @param  Collection<int, Item>  $items
     * @return Collection<int, array{name: string, missing: int}>
     */
    public function missingItems(Collection $items): Collection
    {
        return $items
            ->map(function (Item $item): ?array {
                $owned = $this->items->firstWhere('id', $item->id)?->pivot->number ?? 0;
                $missing = $item->pivot->number - $owned;

                return $missing > 0 ? ['name' => $item->name, 'missing' => $missing] : null;
            })
            ->filter()
            ->values();
    }

    public function canCraftArmor(Armor $armor): bool
    {
        if ($armor->is_default) {
            return false;
        }

        // Armour has no upgrade tree the way a weapon does, so a second copy of a
        // piece buys nothing and only spends the parts.
        if ($this->armors->contains($armor->id)) {
            return false;
        }

        return $this->canAfford($armor->items);
    }
}
