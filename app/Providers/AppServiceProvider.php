<?php

namespace App\Providers;

use App\Comment;
use App\Observers\PostObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
    {
    // public function boot(UrlGenerator $url)
    // {
    //     if (env('APP_ENV') !== 'local') {
    //         $url->forceScheme('https');
    //     }
    //     else{
    //         $url->forceScheme('http');
    //     }


        Comment::observe(PostObserver::class);
    }
}
