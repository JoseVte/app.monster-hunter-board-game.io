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
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
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
        return $items->every(function (Item $item): bool {
            $owned = $this->items->firstWhere('id', $item->id);

            return $owned && $owned->pivot->number >= $item->pivot->number;
        });
    }

    public function canCraftArmor(Armor $armor): bool
    {
        if ($armor->is_default) {
            return false;
        }

        return $this->canAfford($armor->items);
    }
}
