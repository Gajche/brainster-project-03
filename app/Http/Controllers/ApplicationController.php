<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArtistApplicationRequest;
use App\Mail\ApplicationReceived;
use App\Models\ArtistApplication;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

/**
 * Class ApplicationController
 * * Handles public-facing application submissions from artists.
 */
class ApplicationController extends Controller
{
	/**
	 * Store a new artist application in the database.
	 * * This method processes the incoming request, handles the portfolio file upload,
	 * persists the data using the ArtistApplication model, and triggers a 
	 * confirmation email to the applicant.
	 *
	 * @param StoreArtistApplicationRequest $request The validated form request.
	 * @return RedirectResponse Redirects back with a success or error message.
	 */
	public function store(StoreArtistApplicationRequest $request): RedirectResponse
	{
		try {
			/**
			 * The StoreArtistApplicationRequest handles validation rules 
			 * (max file size, required fields, etc.) before this code even runs.
			 */
			$data = $request->validated();

			/**
			 * Handle File Upload:
			 * Stores the file in storage/app/public/uploads and saves the 
			 * path to be stored in the database.
			 */
			// if ($request->hasFile('portfolio')) {
			// 	$data['portfolio_path'] = $request->file('portfolio')->store('uploads', 'public');
			// }

			// Handle File Upload if it exists
			if ($request->hasFile('portfolio')) {
				$data['portfolio_path'] = $request->file('portfolio')->store('uploads', 'public');
			}

			// Handle URL (Validation already ensured it's a valid URL)
			if ($request->filled('portfolio_url')) {
				$data['portfolio_url'] = $request->input('portfolio_url');
			}

			// Set system-generated fields
			$data['year']   = now()->year;
			$data['status'] = 'pending';

			/**
			 * Create the record.
			 */
			$application = ArtistApplication::create($data);

			/**
			 * Send Confirmation Email:
			 * Wrapped in a separate try-catch so that if the mail server is down,
			 * the user still sees their application was successful in the database.
			 */
			try {
				Mail::to($application->email)->send(new ApplicationReceived($application));

				// SUCCESS LOG: Confirms a new submission and the email trigger
				\Illuminate\Support\Facades\Log::info("New artist application submitted", [
					'application_id' => $application->id,
					'artist_email'   => $application->email,
					'name'           => $application->name . ' ' . $application->surname
				]);
			} catch (\Throwable $mailException) {
				// ERROR LOG: Specifically for receipt mail failures
				\Illuminate\Support\Facades\Log::error("Failed to send receipt email to applicant", [
					'application_id' => $application->id,
					'error'          => $mailException->getMessage()
				]);
				report($mailException);
			}

			return redirect()->route('work-with-us')
				->with('success', 'Вашата пријава е успешно испратена!');
		} catch (\Throwable $e) {
			/**
			 * General Error Handling:
			 * Reports the exception to the logs and returns the user to the form.
			 */
			report($e);

			return back()
				->withInput()
				->withErrors(['general' => 'Се случи грешка. Ве молиме обидете се повторно.']);
		}
	}
}
