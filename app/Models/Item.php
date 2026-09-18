<?php

namespace App\Models;

use App\Enum\ItemType;
use Laravel\Scout\Searchable;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'icon_path',
    ];

    protected $appends = [
        'icon_url',
    ];

    protected $casts = [
        'type' => ItemType::class,
    ];

    public array $translatable = [
        'name',
    ];

    /** The icon shown in the game's own inventory, or a generated placeholder. */
    public function iconUrl(): Attribute
    {
        if (filter_var($this->icon_path, FILTER_VALIDATE_URL)) {
            return Attribute::get(fn () => $this->icon_path);
        }

        return Attribute::get(fn () => $this->icon_path
            ? Storage::disk(config('jetstream.profile_photo_disk', 'public'))->url($this->icon_path)
            : $this->defaultIconUrl());
    }

    protected function defaultIconUrl(): string
    {
        $name = trim(collect(explode(' ', $this->name))->map(fn ($segment) => mb_substr($segment, 0, 1))->join(' '));

        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF';
    }

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
