<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArtistApplicationRequest;
use App\Mail\ApplicationReceived;
use App\Models\ArtistApplication;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;

class ApplicationController extends Controller
{
	public function store(StoreArtistApplicationRequest $request): RedirectResponse
	{
		try {
			$data = $request->validated();

			// Handle PDF portfolio upload
			if ($request->hasFile('portfolio')) {
				$file = $request->file('portfolio');

				// Extra security check on mime type (beyond validation)
				if ($file->getMimeType() !== 'application/pdf') {
					return back()->withErrors(['portfolio' => 'Само PDF датотеки се дозволени.'])->withInput();
				}

				// Store in storage/app/public/uploads with a unique name
				$path = $file->store('uploads', 'public');
				$data['portfolio_path'] = $path;
			}

			// Tag the application with the current year
			$data['year']   = now()->year;
			$data['status'] = 'pending';

			$application = ArtistApplication::create($data);

			// Send confirmation email to artist - wrapped in try-catch
			// so mail failure does not roll back the application
			try {
				Mail::to($application->email)->send(new ApplicationReceived($application));
			} catch (\Throwable $mailException) {
				Log::error('Failed to send ApplicationReceived email', [
					'application_id' => $application->id,
					'error'          => $mailException->getMessage(),
				]);
				// Do NOT re-throw - application is saved, just log the mail failure
			}

			// ----------------------

			// try {
			// 	Mail::to($application->email)
			// 		->send(new ApplicationReceived($application));
			// } catch (\Throwable $mailException) {
			// 	Log::error('Mail failed', [
			// 		'error' => $mailException->getMessage(),
			// 	]);
			// }

			return redirect()->route('work-with-us')
				->with('success', 'Вашата пријава е успешно испратена! Ќе добиете потврда на е-пошта.');
		} catch (\Throwable $e) {
			Log::error('Failed to store artist application', [
				'error' => $e->getMessage(),
				'trace' => $e->getTraceAsString(),
			]);

			return back()
				->withInput()
				->withErrors(['general' => 'Се случи грешка. Ве молиме обидете се повторно.']);
		}
	}
}
