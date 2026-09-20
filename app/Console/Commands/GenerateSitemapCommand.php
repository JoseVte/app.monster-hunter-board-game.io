<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class GenerateSitemapCommand extends Command
{
    protected $signature = 'generate:sitemap';

    protected $description = 'Generate the sitemap.';

    public function handle(): void
    {
        $sitemap = Sitemap::create()
            ->add(
                $this->url(route('welcome'))
                    ->addAlternate(route('welcome').'/language/en', 'en')
                    ->addAlternate(route('welcome').'/language/es', 'es')
            )
            ->add($this->url(route('login')))
            ->add($this->url(route('policy.show')))
            ->add($this->url(route('terms.show')));

        // The register route only exists while AUTH_CAN_REGISTER is on, and it is
        // off by default. Asking the generator for its URL unconditionally threw
        // RouteNotFoundException, so no sitemap was written at all. There is
        // nothing to gain from listing a page a visitor cannot reach either.
        if (Route::has('register')) {
            $sitemap->add($this->url(route('register')));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }

    private function url(string $location): Url
    {
        return Url::create($location)
            ->addImage(asset('android-chrome-512x512.png'), config('app.name'))
            ->setLastModificationDate(Carbon::now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY);
    }
}
