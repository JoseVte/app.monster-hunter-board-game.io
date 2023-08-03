<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Console\Command;

class GenerateSitemapCommand extends Command
{
    protected $signature = 'generate:sitemap';

    protected $description = 'Generate the sitemap.';

    public function handle(): void
    {
        Sitemap::create()
            ->add(
                Url::create(route('welcome'))
                    ->addAlternate(route('welcome').'/language/en', 'en')
                    ->addAlternate(route('welcome').'/language/es', 'es')
                    ->addImage(asset('android-chrome-512x512.png'), config('app.name'))
                    ->setLastModificationDate(Carbon::now())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            )
            ->add(
                Url::create(route('login'))
                    ->addImage(asset('android-chrome-512x512.png'), config('app.name'))
                    ->setLastModificationDate(Carbon::now())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            )
            ->add(
                Url::create(route('register'))
                    ->addImage(asset('android-chrome-512x512.png'), config('app.name'))
                    ->setLastModificationDate(Carbon::now())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            )
            ->writeToFile(public_path('sitemap.xml'));
    }
}
