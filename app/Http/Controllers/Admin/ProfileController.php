<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
	public function edit()
	{
		/** @var User $user */
		$user = Auth::user();

		$profile = $user->adminProfile ?? new AdminProfile(['user_id' => $user->id]);

		return view('admin.profile.edit', compact('user', 'profile'));
	}

	public function update(Request $request)
	{
		$request->validate([
			'name'       => 'required|string|max:255',
			'first_name' => 'nullable|string|max:100',
			'last_name'  => 'nullable|string|max:100',
			'phone'      => 'nullable|string|max:30',
			'address'    => 'nullable|string|max:255',
			'city'       => 'nullable|string|max:100',
		]);

		/** @var User $user */
		$user = Auth::user();

		try {
			// Transaction ensures both updates happen or neither happens
			DB::transaction(function () use ($request, $user) {

				// Update the User model directly
				$user->update(['name' => $request->name]);

				// Update or Create the Profile
				$user->adminProfile()->updateOrCreate(
					['user_id' => $user->id],
					$request->only(['first_name', 'last_name', 'phone', 'address', 'city'])
				);
			});

			return back()->with('success', 'Профилот е успешно ажуриран.');
		} catch (\Throwable $e) {
			// Report for monitoring and log for local debugging
			report($e);

			Log::error("Profile update failed for User #{$user->id}", [
				'error' => $e->getMessage()
			]);

			return back()->withErrors(['error' => 'Настана грешка при зачувување на податоците.']);
		}
	}
}
