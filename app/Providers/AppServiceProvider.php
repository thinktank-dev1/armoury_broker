<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Notifications\ChannelManager;
use App\Notifications\Channel\CommunicationChannel;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

use App\Models\LegalDoc;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        $terms_of_use = null;
        $privacy_policy = null;

        if (Schema::hasTable('legal_docs')) {
            $docs = LegalDoc::get();
            foreach ($docs as $doc) {
                if ($doc->name === 'terms_of_use') {
                    $terms_of_use = $doc->link_url;
                }

                if ($doc->name === 'privacy_policy') {
                    $privacy_policy = $doc->link_url;
                }
            }
        }

        View::share('terms_of_use', $terms_of_use);
        View::share('privacy_policy', $privacy_policy);

        $this->app->make(ChannelManager::class)->extend('custom', function ($app) {
            return new CommunicationChannel();
        });
    }
}
