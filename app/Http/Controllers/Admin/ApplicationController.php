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

class ApplicationController extends Controller
{
	/**
	 * List of pending applications - admin can search.
	 */
	public function pending(Request $request)
	{
		try {
			$query = ArtistApplication::pending()->orderByDesc('created_at');

			if ($search = $request->input('search')) {
				$like = '%' . $search . '%';
				$query->where(function ($q) use ($like) {
					$q->where('name', 'like', $like)
						->orWhere('surname', 'like', $like)
						->orWhere('email', 'like', $like)
						->orWhere('phone', 'like', $like);
				});
			}

			$applications = $query->paginate(15)->withQueryString();
			return view('admin.applications.pending', compact('applications', 'search'));
		} catch (\Throwable $e) {
			Log::error('Error loading pending applications', ['error' => $e->getMessage()]);
			return back()->withErrors(['error' => 'Грешка при вчитување на апликации.']);
		}
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
		try {
			// SECURITY: Enforce year restriction - past-year apps are read-only
			if (!$application->isCurrentYear()) {
				return back()->withErrors([
					'year' => 'Не можете да прегледувате апликации од претходни години.'
				]);
			}

			// SECURITY: Only pending applications can be reviewed
			if (!$application->isPending()) {
				return back()->withErrors([
					'status' => 'Оваа апликација веќе е прегледана.'
				]);
			}

			$data = $request->validated();

			// Update application record
			$application->update([
				'status'         => $data['decision'],
				'admin_response' => $data['admin_response'],
				'responded_at'   => now(),
				'responded_by'   => Auth::id(),
			]);

			// Notify artist via email
			try {
				Mail::to($application->email)->send(new ApplicationReviewed($application));
			} catch (\Throwable $mailException) {
				Log::error('Failed to send ApplicationReviewed email', [
					'application_id' => $application->id,
					'error'          => $mailException->getMessage(),
				]);
				// Application status is saved; mail failure is non-critical
			}

			$statusMk = $data['decision'] === 'approved' ? 'одобрена' : 'одбиена';
			return redirect()->route('admin.applications.pending')
				->with('success', "Апликацијата на {$application->name} {$application->surname} е {$statusMk}.");
		} catch (\Throwable $e) {
			Log::error('Error reviewing application', [
				'application_id' => $application->id,
				'error'          => $e->getMessage(),
			]);
			return back()->withErrors(['error' => 'Се случи грешка при прегледување на апликацијата.']);
		}
	}

	/**
	 * All applications - searchable list for admin reference.
	 */
	public function all(Request $request)
	{
		try {
			$query = ArtistApplication::orderByDesc('created_at');

			if ($search = $request->input('search')) {
				$like = '%' . $search . '%';
				$query->where(function ($q) use ($like) {
					$q->where('name', 'like', $like)
						->orWhere('surname', 'like', $like)
						->orWhere('email', 'like', $like)
						->orWhere('phone', 'like', $like);
				});
			}

			$applications = $query->paginate(20)->withQueryString();
			return view('admin.applications.all', compact('applications', 'search'));
		} catch (\Throwable $e) {
			Log::error('Error loading all applications', ['error' => $e->getMessage()]);
			return back()->withErrors(['error' => 'Грешка при вчитување.']);
		}
	}
}
