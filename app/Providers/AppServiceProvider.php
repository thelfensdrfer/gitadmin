<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

use Rollbar;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Rollbar::init([
            'access_token' => Config::get('services.rollbar.token.server'),
            'environment' => Config::get('app.env'),
        ], true, true);

        \View::composer('*', function($view){
            $view->with('theUser', \Auth::user());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
