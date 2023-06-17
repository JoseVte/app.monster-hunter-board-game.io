<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WeaponType extends Model
{
    use HasFactory;
    use HasTranslations;
    use Searchable;

    protected $fillable = [
        'name',
        'description',
        'image_path',
    ];

    public array $translatable = [
        'name',
        'description',
    ];

    protected $appends = [
        'image_url',
    ];

    public function weapons(): HasMany
    {
        return $this->hasMany(Weapon::class, 'type_id');
    }

    public function imageUrl(): Attribute
    {
        if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
            return Attribute::get(fn () => $this->image_path);
        }

        return Attribute::get(fn () => $this->image_path
            ? Storage::disk(config('jetstream.profile_photo_disk', 'public'))->url($this->image_path)
            : $this->defaultImageUrl());
    }

    protected function defaultImageUrl(): string
    {
        $name = trim(collect(explode(' ', $this->name))->map(fn ($segment) => mb_substr($segment, 0, 1))->join(' '));

        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF';
    }

    public function toSearchableArray(): array
    {
        $searchable = [
            'url' => 'TODO',
        ];
        foreach (config('app.locales-available') as $locale) {
            $searchable[$locale.'.name'] = $this->getTranslation('name', $locale);
        }

        return $searchable;
    }
}
