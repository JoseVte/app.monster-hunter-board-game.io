<?php

namespace App\Models;

use App\Enum\ItemType;
use Laravel\Scout\Searchable;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    /** The monsters this part comes from. */
    public function monsters(): BelongsToMany
    {
        return $this->belongsToMany(Monster::class)->withTimestamps();
    }

    /**
     * The weapons that spend it, the reverse of Weapon::items(). A weapon with
     * two recipes can name the same item in both, so this asks for the weapons
     * rather than the rows.
     */
    public function weapons(): BelongsToMany
    {
        return $this->belongsToMany(Weapon::class, 'count_item_weapon')->distinct();
    }

    /** The armours that spend it, the reverse of Armor::items(). */
    public function armors(): BelongsToMany
    {
        return $this->belongsToMany(Armor::class, 'count_item_armor')->distinct();
    }

    use HasFactory;
    use HasTranslations;
    use Searchable;

    protected $fillable = [
        'type',
        'name',
    ];

    protected $casts = [
        'type' => ItemType::class,
    ];

    public array $translatable = [
        'name',
    ];

    public function toSearchableArray(): array
    {
        $searchable = [
            'url' => route('wiki.item.show', $this->id),
            'type' => strtolower($this->type->name),
        ];
        foreach ($this->type->getTranslations() as $locale => $translation) {
            $searchable[$locale.'.type'] = $translation;
            $searchable[$locale.'.name'] = $this->getTranslation('name', $locale);
        }

        return $searchable;
    }
}
