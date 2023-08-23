<?php

namespace App\Models;

use App\Enum\ItemType;
use App\Models\Pivot\HunterArmor;
use App\Models\Pivot\HunterWeapon;
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
    use HasFactory;
    use EagerLoadPivotTrait;

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
            ->withTimestamps()
            ->using(HunterWeapon::class);
    }

    public function armors(): BelongsToMany
    {
        return $this->belongsToMany(Armor::class, HunterArmor::class)
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
        if ($weapon->is_default) {
            return false;
        }

        if ($weapon->parent_id && !$this->weapons()->find($weapon->parent_id)) {
            return false;
        }

        return $weapon->items->filter(function (Item $item) {
            $hunterItem = $this->items()->find($item->id);
            return empty($hunterItem) || $item->pivot->number > $hunterItem->pivot->number;
        })->count() === 0;
    }

    public function canCraftArmor(Armor $armor): bool
    {
        if ($armor->is_default) {
            return false;
        }

        return $armor->items->filter(function (Item $item) {
            $hunterItem = $this->items()->find($item->id);
            return empty($hunterItem) || $item->pivot->number > $hunterItem->pivot->number;
        })->count() === 0;
    }
}
