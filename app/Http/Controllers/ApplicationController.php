<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArtistApplicationRequest;
use App\Mail\ApplicationReceived;
use App\Models\ArtistApplication;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
	public function store(StoreArtistApplicationRequest $request): RedirectResponse
	{
		try {
			// Validation handles the file type and security automatically
			$data = $request->validated();

			// Handle File Upload
			if ($request->hasFile('portfolio')) {
				$data['portfolio_path'] = $request->file('portfolio')->store('uploads', 'public');
			}

			$data['year']   = now()->year;
			$data['status'] = 'pending';

			// Create record
			$application = ArtistApplication::create($data);

			// Send Email
			// (use ->queue() instead of ->send())
			// If you use queue(), you can remove the inner try-catch entirely!
			try {
				Mail::to($application->email)->send(new ApplicationReceived($application));
			} catch (\Throwable $mailException) {
				report($mailException); // Tell the system the mail failed, but keep going
			}

			return redirect()->route('work-with-us')
				->with('success', 'Вашата пријава е успешно испратена!');
		} catch (\Throwable $e) {
			report($e); // Send to your error monitoring service

			return back()
				->withInput()
				->withErrors(['general' => 'Се случи грешка. Ве молиме обидете се повторно.']);
		}
	}
}
