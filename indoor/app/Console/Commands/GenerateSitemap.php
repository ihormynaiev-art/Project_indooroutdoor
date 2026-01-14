<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sitemap = Sitemap::create();
        $sitemap->add(Url::create('/')->setLastModificationDate(Carbon::today()));
        $sitemap->add(Url::create('/catalog')->setLastModificationDate(Carbon::today()));
        $sitemap->add(Url::create('/about-us')->setLastModificationDate(Carbon::today()));
        $sitemap->add(Url::create('/contact-us')->setLastModificationDate(Carbon::today()));
        $sitemap->add(Url::create('/home-pro')->setLastModificationDate(Carbon::today()));
        $sitemap->add(Url::create('/e-dition')->setLastModificationDate(Carbon::today()));
        $sitemap->add(Url::create('/privacy-policy')->setLastModificationDate(Carbon::today()));
        $sitemap->add(Url::create('/terms-condition')->setLastModificationDate(Carbon::today()));

        User::with('providerDetail')
            ->has('providerDetail')
            ->where('is_verified', true)
            ->get()->each(function (User $user) use ($sitemap) {
                $sitemap->add(
                    Url::create("/provider-details/{$user->providerDetail->id}")
                        ->setLastModificationDate($user->providerDetail->updated_at)
                );
            });
        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
