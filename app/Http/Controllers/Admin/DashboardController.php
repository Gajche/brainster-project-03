<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArtistApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	public function index(Request $request)
	{
		try {
			// Optimization: Cache the stats for 10 minutes to save DB load
			$stats = Cache::remember('admin_stats', 600, function () {
				return ArtistApplication::query()
					->selectRaw("
                        COUNT(*) as total,
                        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                        SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
                        SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected
                    ")
					->first()
					->toArray();
			});

			// Fetch grouped applications
			$approvedByYear = ArtistApplication::approved()
				->orderByDesc('year')
				->orderByDesc('created_at')
				->get()
				->groupBy('year');

			return view('admin.dashboard', compact('approvedByYear', 'stats'));
		} catch (\Throwable $e) {
			// Reporting the error to Sentry/Logviewer
			report($e);

			Log::error("Dashboard failed to load for User #" . Auth::id(), [
				'exception' => $e->getMessage()
			]);

			// Don't show a 500 error, go back with a message
			return redirect()->route('admin.applications.pending')
				->with('error', 'Грешка при вчитување на контролната табла. Проблемот е пријавен.');
		}
	}
}
