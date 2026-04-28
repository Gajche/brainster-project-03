<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArtistApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class DashboardController
 * * Manages the main administrative overview, providing high-level statistics
 * and grouped application data for the admin home screen.
 */
class DashboardController extends Controller
{
	/**
	 * Display the admin dashboard with application statistics and approved entries.
	 *
	 * This method uses caching for statistics to reduce database overhead and
	 * retrieves approved applications grouped by their submission year.
	 *
	 * @param Request $request
	 * @return View
	 */
	public function index(Request $request): View
	{
		try {
			/**
			 * Optimization: Cache stats for 10 minutes (600 seconds).
			 * The cache is automatically invalidated via Model Events in ArtistApplication
			 * whenever a record is saved, updated, or deleted.
			 */
			$stats = Cache::remember('admin_stats', 600, function () {
				return ArtistApplication::query()
					->selectRaw("
                        COUNT(*) as total,
                        COALESCE(SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END), 0) as pending,
                        COALESCE(SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END), 0) as approved,
                        COALESCE(SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END), 0) as rejected
                    ")
					->first()
					->toArray();
			});

			/**
			 * Fetch all approved applications and group them by year.
			 * This allows the Blade view to easily render nested lists by year.
			 */
			$approvedByYear = ArtistApplication::approved()
				->orderByDesc('year')
				->orderByDesc('created_at')
				->get()
				->groupBy('year');

			return view('admin.dashboard', compact('approvedByYear', 'stats'));
		} catch (\Throwable $e) {
			/**
			 * Error Handling: Log administrative context for easier debugging.
			 * Provides a graceful fallback to the view with zeroed statistics.
			 */
			Log::withContext([
				'admin_id' => Auth::id(),
				'url'      => $request->fullUrl()
			]);

			report($e);

			return view('admin.dashboard', [
				'approvedByYear' => collect(),
				'stats' => [
					'total'    => 0,
					'pending'  => 0,
					'approved' => 0,
					'rejected' => 0
				]
			])->with('error', 'Грешка при вчитување на статистиката. Проблемот е пријавен.');
		}
	}
}
