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

		// Ensure the profile exists so the view doesn't have to handle 'null'
		$profile = $user->adminProfile ?: new AdminProfile();

		return view('admin.profile.edit', compact('user', 'profile'));
	}

	public function update(Request $request)
	{
		// Assign validation to a variable
		$validated = $request->validate([
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
			DB::transaction(function () use ($validated, $user) {
				// Update basic User info
				$user->update(['name' => $validated['name']]);

				// Update or Create the Profile using validated data
				$user->adminProfile()->updateOrCreate(
					['user_id' => $user->id],
					[
						'first_name' => $validated['first_name'],
						'last_name'  => $validated['last_name'],
						'phone'      => $validated['phone'],
						'address'    => $validated['address'],
						'city'       => $validated['city'],
					]
				);
			});

			return back()->with('success', 'Профилот е успешно ажуриран.');
		} catch (\Throwable $e) {
			// Contextual Logging
			Log::withContext([
				'user_id' => $user->id,
				'payload' => $request->except(['_token', '_method'])
			]);

			report($e);

			return back()
				->withInput()
				->withErrors(['error' => 'Настана грешка при зачувување на податоците.']);
		}
	}
}
