<?php

namespace App\Console\Commands;

use JsonException;
use RecursiveIteratorIterator;
use Illuminate\Console\Command;
use RecursiveDirectoryIterator;

class ExtractTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:extract-vue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract all translatable strings from views, generating a json file.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Running');

        $translations = $this->extractTranslationsByPath(resource_path().'/js');

        $this->saveTranslations($translations);
    }

    private function extractTranslationsByPath(string $path): array
    {
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

        $translations = [];

        foreach ($rii as $file) {
            if (!$file->isDir()) {
                $translations = array_merge($translations, $this->extractTranslations($file->getPathname()));
            }
        }

        return $translations;
    }

    private function extractTranslations(string $path): array
    {
        $data = str_replace("\'", "'", file_get_contents($path));
        preg_match_all('/\$t\(\'(?<translations>[^)]+)\'\)/', $data, $matches);

        $translations = [];
        if (!empty($matches['translations'])) {
            $translations = array_values(array_unique($matches['translations']));
            sort($translations);
        }

        // What about the ones inside {{ }}?
        preg_match_all('/__\(\'(?<translations>[^)]+)\'\)/', $data, $matches);
        if (!empty($matches['translations'])) {
            $translations = array_merge($translations, array_values(array_unique($matches['translations'])));
            sort($translations);
        }

        $slug = str_replace($path.'/', '', $path);
        if (!empty($translations)) {
            $this->info($slug.':');
            $this->info(print_r($translations, 1));
        }

        return $translations;
    }

    /**
     * @throws JsonException
     */
    private function saveTranslations(array $translations): void
    {
        $oldEnTranslations = collect(json_decode(file_get_contents(lang_path('en.json')), false, 512, JSON_THROW_ON_ERROR));
        $oldEsTranslations = collect(json_decode(file_get_contents(lang_path('es.json')), false, 512, JSON_THROW_ON_ERROR));

        $translations = array_values(array_unique($translations));
        foreach ($translations as $translation) {
            if (!$oldEnTranslations->has($translation)) {
                $oldEnTranslations = $oldEnTranslations->merge([$translation => $translation]);
            }
            if (!$oldEsTranslations->has($translation)) {
                $oldEsTranslations = $oldEsTranslations->merge([$translation => '']);
            }
        }

        $encodedEn = json_encode(
            $oldEnTranslations
            ->sortKeys(SORT_NATURAL | SORT_FLAG_CASE)
            ->toArray(),
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );

        $encodedEs = json_encode(
            $oldEsTranslations
            ->sortKeys(SORT_NATURAL | SORT_FLAG_CASE)
            ->toArray(),
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );

        file_put_contents(lang_path('en.json'), $encodedEn);
        file_put_contents(lang_path('es.json'), $encodedEs);
        $this->info(count($translations).' written');
    }
}
