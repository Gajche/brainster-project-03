<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// This line below is the one you are missing!
use Illuminate\Support\Facades\URL;

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
		/**
		 * Forces all generated links (CSS, JS, Images) to use https 
		 * when the app is running on Railway (production).
		 */
		if (config('app.env') === 'production') {
			URL::forceScheme('https');
		}
	}
}
