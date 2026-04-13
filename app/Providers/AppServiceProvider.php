<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;


use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\Dsn;

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
		// Force HTTPS on Railway (production)
		if (config('app.env') === 'production') {
			URL::forceScheme('https');
		}

		// Brevo mailer
		Mail::extend('brevo', function () {
			return Transport::fromDsn(
				'brevo+api://default:' . env('BREVO_API_KEY') . '@default'
			);
		});
	}
}
