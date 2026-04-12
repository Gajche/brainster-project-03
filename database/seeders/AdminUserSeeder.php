<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\AdminProfile;

class AdminUserSeeder extends Seeder
{
	public function run(): void
	{
		// Create admin user 
		$admin = User::firstOrCreate(
			['email' => 'admin@evolucija.com'],
			[
				'name'              => 'Admin',
				'password'          => Hash::make('password'),
				'email_verified_at' => now(),
			]
		);

		// Create profile
		AdminProfile::firstOrCreate(
			['user_id' => $admin->id],
			[
				'first_name' => 'Festival',
				'last_name'  => 'Admin',
				'address'    => 'Ул. 1, Ѓорче Петров Бр.55',
				'city'       => 'Скопје',
			]
		);

		$this->command->info('Admin created: admin@evolucija.com / password');
	}
}
