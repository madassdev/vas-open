<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $request_root = request()->root();
        $live_domain = env('LIVE_APP_DOMAIN');
        $context = $request_root === $live_domain ? "live" : "test";
        config()->set(["app.auth_context" => $context]);
        Schema::defaultStringLength(191);
    }
}
