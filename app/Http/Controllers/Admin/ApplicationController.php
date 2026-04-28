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
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Class ApplicationController
 * * Handles the administrative tasks for artist applications, including
 * listing, viewing, reviewing, and deleting submissions.
 */
class ApplicationController extends Controller
{
	/**
	 * Display a paginated list of pending artist applications.
	 *
	 * @param Request $request
	 * @return View
	 */
	public function pending(Request $request): View
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
	 * Display the details of a specific artist application.
	 *
	 * @param ArtistApplication $application
	 * @return View
	 */
	public function show(ArtistApplication $application): View
	{
		return view('admin.applications.show', compact('application'));
	}

	/**
	 * Review and process an artist application (Approve or Reject).
	 *
	 * Updates the application status, logs the admin response, 
	 * and sends a notification email to the applicant.
	 *
	 * @param ReviewApplicationRequest $request
	 * @param ArtistApplication $application
	 * @return RedirectResponse
	 */
	public function review(ReviewApplicationRequest $request, ArtistApplication $application): RedirectResponse
	{
		// Guard Clauses: Prevent reviewing old or already processed apps
		if (!$application->isCurrentYear()) {
			return back()->withErrors(['year' => 'Не можете да прегледувате апликации од претходни години.']);
		}

		if (!$application->isPending()) {
			return back()->withErrors(['status' => 'Оваа апликација веќе е прегледана.']);
		}

		$data = $request->validated();

		try {
			// Update application status within a transaction for data integrity
			DB::transaction(function () use ($data, $application) {
				$application->update([
					'status'         => $data['decision'],
					'admin_response' => $data['admin_response'],
					'responded_at'   => now(),
					'responded_by'   => Auth::id(),
				]);
			});

			// Send notification email
			try {
				Mail::to($application->email)->send(new ApplicationReviewed($application));

				// SUCCESS LOG: Confirms the email was sent (or queued)
				Log::info("Application review email sent to: {$application->email}", [
					'application_id' => $application->id,
					'status'         => $application->status,
					'admin_id'       => Auth::id(),
				]);
			} catch (\Throwable $e) {
				// ERROR LOG: Specifically for mail failures
				Log::error("Failed to send review email to: {$application->email}", [
					'application_id' => $application->id,
					'error'          => $e->getMessage()
				]);
				report($e);
			}

			$statusMk = $data['decision'] === 'approved' ? 'одобрена' : 'одбиена';

			return redirect()->route('admin.applications.pending')
				->with('success', "Апликацијата на {$application->name} {$application->surname} е {$statusMk}.");
		} catch (\Throwable $e) {
			Log::withContext(['admin_id' => Auth::id(), 'target_application' => $application->id]);
			report($e);

			return back()->withInput()->withErrors(['error' => 'Настана грешка при зачувување на промените. Ве молиме обидете се повторно.']);
		}
	}

	/**
	 * Display a paginated list of all artist applications (Active and Pending).
	 *
	 * @param Request $request
	 * @return View
	 */
	public function all(Request $request): View
	{
		$search = $request->input('search');

		$applications = ArtistApplication::query()
			->search($search)
			->orderByDesc('created_at')
			->paginate(20)
			->withQueryString();

		return view('admin.applications.all', compact('applications', 'search'));
	}

	/**
	 * Soft-delete an artist application.
	 * * Note: This triggers the 'deleted' event in the Model, 
	 * which automatically clears the dashboard cache.
	 *
	 * @param ArtistApplication $application
	 * @return RedirectResponse
	 */
	public function destroy(ArtistApplication $application): RedirectResponse
	{
		try {
			$application->delete();
			return back()->with('success', 'Апликацијата е успешно избришана.');
		} catch (\Throwable $e) {
			report($e);
			return back()->withErrors(['error' => 'Настана грешка при бришењето.']);
		}
	}
}
