<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
		//register non-production packages here
		if(!$this->app->environment('production')) {
			$this->app->register('SocialEngine\TestDbSetup\ServiceProvider');
			$this->app->register('Barryvdh\Debugbar\ServiceProvider');
		}
    }
}
