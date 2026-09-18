<?php

namespace App\Models;

use App\Enum\MonsterCategory;
use Laravel\Scout\Searchable;
use App\Enum\MonsterExpansion;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Monster extends Model
{
    /**
     * What this monster drops. A part drops from more than one, so the link is
     * many to many.
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)->withTimestamps();
    }

    /** The stats and body-part breaks for each difficulty tier it is fought at. */
    public function difficulties(): HasMany
    {
        // Ordering by stars only happens to work while no monster pairs an arena
        // tier with a non-arena one at the same star rating. This orders by the
        // enum's own declared case order instead, portably: FIELD() is MySQL only
        // and the test suite runs on SQLite.
        return $this->hasMany(MonsterDifficulty::class)->orderByRaw(
            "CASE difficulty
                WHEN 'EASY' THEN 1
                WHEN 'NORMAL' THEN 2
                WHEN 'HARD' THEN 3
                WHEN 'ARENA_EASY' THEN 4
                WHEN 'ARENA_NORMAL' THEN 5
                WHEN 'ARENA_HARD' THEN 6
                ELSE 7
            END",
        );
    }

    /** The roll-1-to-12 reward table printed alongside its card. */
    public function rewards(): HasMany
    {
        return $this->hasMany(MonsterReward::class)->orderBy('roll');
    }

    use HasFactory;
    use HasTranslations;
    use Searchable;

    protected $fillable = [
        'name',
        'description',
        'category',
        'expansion',
        'resistance_fire',
        'resistance_water',
        'resistance_thunder',
        'resistance_ice',
        'resistance_dragon',
        'resistance_paralysis',
        'resistance_poison',
        'resistance_sleep',
        'resistance_nitro',
        'resistance_stun',
        'setup',
        'mechanics',
        'icon_path',
    ];

    public array $translatable = [
        'name',
        'description',
        'setup',
    ];

    protected $appends = [
        'icon_url',
    ];

    protected $casts = [
        'category' => MonsterCategory::class,
        'expansion' => MonsterExpansion::class,
        'resistance_fire' => 'integer',
        'resistance_water' => 'integer',
        'resistance_thunder' => 'integer',
        'resistance_ice' => 'integer',
        'resistance_dragon' => 'integer',
        'resistance_paralysis' => 'integer',
        'resistance_poison' => 'integer',
        'resistance_sleep' => 'integer',
        'resistance_nitro' => 'integer',
        'resistance_stun' => 'integer',
    ];

    /**
     * A list of {title, description: [{title, description}]} sections, every
     * leaf already bilingual in the seed data. Spatie's translatable trait only
     * flattens a flat string per locale, not this nested shape, so this walks
     * it by hand instead.
     */
    protected function mechanics(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value): array => $value ? $this->localizeMechanics(json_decode($value, true)) : [],
            set: fn (?array $value): ?string => $value ? json_encode($value) : null,
        );
    }

    /**
     * @param  array<int, array<string, mixed>>  $mechanics
     * @return array<int, array<string, mixed>>
     */
    private function localizeMechanics(array $mechanics): array
    {
        $locale = app()->getLocale();

        return collect($mechanics)
            ->map(fn (array $section): array => [
                'title' => $section['title'][$locale] ?? $section['title']['en'],
                'description' => collect($section['description'])
                    ->map(fn (array $item): array => [
                        'title' => $item['title'][$locale] ?? $item['title']['en'],
                        'description' => $item['description'][$locale] ?? $item['description']['en'],
                    ])
                    ->all(),
            ])
            ->all();
    }

    /** The emblem printed on its physical card, or a generated placeholder. */
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
            'category' => $this->category->name,
            'expansion' => $this->expansion->name,
            'url' => route('wiki.monster.show', $this->id),
        ];
        foreach (config('app.locales-available') as $locale) {
            $searchable[$locale.'.name'] = $this->getTranslation('name', $locale);
        }

        return $searchable;
    }
}
