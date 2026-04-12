<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArtistApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
	public function index(Request $request)
	{
		try {
			// Dashboard shows approved applications grouped by year
			$approvedByYear = ArtistApplication::approved()
				->orderByDesc('year')
				->orderByDesc('created_at')
				->get()
				->groupBy('year');

			// Summary counts
			$stats = [
				'total'    => ArtistApplication::count(),
				'pending'  => ArtistApplication::pending()->count(),
				'approved' => ArtistApplication::approved()->count(),
				'rejected' => ArtistApplication::where('status', 'rejected')->count(),
			];

			return view('admin.dashboard', compact('approvedByYear', 'stats'));
		} catch (\Throwable $e) {
			Log::error('Admin dashboard error', ['error' => $e->getMessage()]);
			return view('admin.dashboard', ['approvedByYear' => collect(), 'stats' => []]);
		}
	}
}
