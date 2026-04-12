<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
	public function edit()
	{
		/** @var User $user */
		$user    = Auth::user();
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

		try {
			/** @var User $user */
			$user = Auth::user();

			User::where('id', $user->id)->update(['name' => $request->name]);

			AdminProfile::updateOrCreate(
				['user_id' => $user->id],
				$request->only(['first_name', 'last_name', 'phone', 'address', 'city'])
			);

			return back()->with('success', 'Профилот е успешно ажуриран.');
		} catch (\Throwable $e) {
			Log::error('Profile update error', ['error' => $e->getMessage()]);
			return back()->withErrors(['error' => 'Грешка при ажурирање на профилот.']);
		}
	}
}
