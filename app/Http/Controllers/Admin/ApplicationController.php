<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewApplicationRequest;
use App\Mail\ApplicationReviewed;
use App\Models\ArtistApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
	/**
	 * List of pending applications - admin can search.
	 */
	public function pending(Request $request)
	{
		$search = $request->input('search');

		$applications = ArtistApplication::pending()
			->search($search)
			->orderByDesc('created_at')
			->paginate(15)
			->withQueryString();

		return view('admin.applications.pending', compact('applications', 'search'));
	}

	/**
	 * Show a single application.
	 */
	public function show(ArtistApplication $application)
	{
		return view('admin.applications.show', compact('application'));
	}

	/**
	 * Review (approve or reject) an application.
	 * YEAR RESTRICTION: only current-year pending applications can be actioned.
	 */
	public function review(ReviewApplicationRequest $request, ArtistApplication $application)
	{
		// Guard Clauses
		if (!$application->isCurrentYear()) {
			return back()->withErrors(['year' => 'Не можете да прегледувате апликации од претходни години.']);
		}

		if (!$application->isPending()) {
			return back()->withErrors(['status' => 'Оваа апликација веќе е прегледана.']);
		}

		$data = $request->validated();

		try {
			// Transaction to ensure the DB update is solid
			DB::transaction(function () use ($data, $application) {
				$application->update([
					'status'         => $data['decision'],
					'admin_response' => $data['admin_response'],
					'responded_at'   => now(),
					'responded_by'   => Auth::id(),
				]);
			});

			// Email Notification (Non-critical)
			try {
				Mail::to($application->email)->send(new ApplicationReviewed($application));
			} catch (\Throwable $e) {
				// report() so external monitors see it, and add context
				report($e);
				Log::warning("Email failed for application #{$application->id}", [
					'email' => $application->email,
					'error' => $e->getMessage()
				]);
			}

			$statusMk = $data['decision'] === 'approved' ? 'одобрена' : 'одбиена';

			return redirect()->route('admin.applications.pending')
				->with('success', "Апликацијата на {$application->name} {$application->surname} е {$statusMk}.");
		} catch (\Exception $e) {
			// Handle critical DB failures
			report($e);
			return back()->withErrors(['error' => 'Настана грешка при зачувување на промените. Ве молиме обидете се повторно.']);
		}
	}

	/**
	 * All applications - searchable list for admin reference.
	 */
	public function all(Request $request)
	{
		$search = $request->input('search');

		$applications = ArtistApplication::query()
			->search($search)
			->orderByDesc('created_at')
			->paginate(20)
			->withQueryString();

		return view('admin.applications.all', compact('applications', 'search'));
	}
}
