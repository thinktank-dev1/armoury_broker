<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Notifications\ChannelManager;
use App\Notifications\Channel\CommunicationChannel;

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
        $this->app->make(ChannelManager::class)->extend('custom', function ($app) {
            return new CommunicationChannel();
        });
    }
}
