<?php

namespace Database\Seeders;

use App\Models\ArtistApplication;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArtistApplicationSeeder extends Seeder
{
	public function run(): void
	{
		$admin = User::where('email', 'admin@evolucija.com')->first();

		// 2 pending 2026  - mentor/evaluator can approve/reject to test the flow
		// 2 approved 2026 - visible on dashboard under 2026
		// 2 rejected 2026 - visible in all applications list
		// 2 approved 2024 - demonstrates year grouping on dashboard
		// 1 pending 2024  - demonstrates read-only restriction for past years
		// 1 with PDF 2026 - demonstrates file upload feature

		// CURRENT YEAR (2026) PENDING
		// Admin can approve or reject these during evaluation
		ArtistApplication::create([
			'name'               => 'Ана',
			'surname'            => 'Петровска',
			'email'              => 'ana.petrovska@gmail.com',
			'phone'              => '071 234 567',
			'social_media'       => 'https://www.instagram.com/ana.petrovska',
			'collaboration_area' => 'Визуелна уметност',
			'message'            => 'Сакам да учествувам на фестивалот со моите мурали и графити. Имам искуство од 5 години во уличната уметност.',
			'portfolio_path'     => null,
			'year'               => 2026,
			'status'             => 'pending',
		]);

		ArtistApplication::create([
			'name'               => 'Марко',
			'surname'            => 'Јовановски',
			'email'              => 'marko.jovanovski@yahoo.com',
			'phone'              => '070 987 654',
			'social_media'       => 'https://www.instagram.com/marko.jovanovski',
			'collaboration_area' => 'Музика',
			'message'            => 'Сум електронски музичар со 3 години на меѓународната сцена. Би сакал да настапам на фестивалот.',
			'portfolio_path'     => null,
			'year'               => 2026,
			'status'             => 'pending',
		]);

		// CURRENT YEAR (2026) APPROVED
		// Visible on dashboard under 2026
		ArtistApplication::create([
			'name'               => 'Лена',
			'surname'            => 'Јариќ',
			'email'              => 'lena.jaric@gmail.com',
			'phone'              => '072 111 222',
			'social_media'       => 'https://www.instagram.com/lena.jaric',
			'collaboration_area' => 'Перформанс уметност',
			'message'            => 'Перформанс уметница со меѓународно искуство. Би сакала да донесам интерактивен перформанс.',
			'portfolio_path'     => null,
			'year'               => 2026,
			'status'             => 'approved',
			'admin_response'     => 'Честитаме! Вашата апликација е одобрена. Ќе ве контактираме со дополнителни детали за фестивалот.',
			'responded_at'       => now()->subDays(5),
			'responded_by'       => $admin?->id,
		]);

		ArtistApplication::create([
			'name'               => 'Михаил',
			'surname'            => 'Петров',
			'email'              => 'mihail.petrov@hotmail.com',
			'phone'              => '078 333 444',
			'social_media'       => 'https://www.facebook.com/mihail.petrov',
			'collaboration_area' => 'Фотографија',
			'message'            => 'Документарен фотограф. Би сакал да ги документирам настаните на фестивалот.',
			'portfolio_path'     => null,
			'year'               => 2026,
			'status'             => 'approved',
			'admin_response'     => 'Одлична апликација! Со задоволство ве прифаќаме. Очекувајте детали на вашата е-пошта.',
			'responded_at'       => now()->subDays(3),
			'responded_by'       => $admin?->id,
		]);

		// CURRENT YEAR (2026) REJECTED
		ArtistApplication::create([
			'name'               => 'Сара',
			'surname'            => 'Николова',
			'email'              => 'sara.nikolova@gmail.com',
			'phone'              => '075 555 666',
			'social_media'       => null,
			'collaboration_area' => 'Танц',
			'message'            => 'Сакам да учествувам со модерен танц.',
			'portfolio_path'     => null,
			'year'               => 2026,
			'status'             => 'rejected',
			'admin_response'     => 'Ви благодариме за интересот. За жал, оваа година немаме слободни места за оваа категорија. Ве охрабруваме да аплицирате следната година.',
			'responded_at'       => now()->subDays(7),
			'responded_by'       => $admin?->id,
		]);

		ArtistApplication::create([
			'name'               => 'Борис',
			'surname'            => 'Симоновски',
			'email'              => 'boris.simonovski@outlook.com',
			'phone'              => '071 777 888',
			'social_media'       => 'https://www.instagram.com/boris.simonovski',
			'collaboration_area' => 'Поезија',
			'message'            => 'Поет со две објавени збирки. Би сакал да читам поезија на фестивалот.',
			'portfolio_path'     => null,
			'year'               => 2026,
			'status'             => 'rejected',
			'admin_response'     => 'Ви благодариме за апликацијата. За жал, оваа година фестивалот се фокусира на визуелни и музички уметности. Следната година планираме да вклучиме и литературна програма.',
			'responded_at'       => now()->subDays(10),
			'responded_by'       => $admin?->id,
		]);

		// PAST YEAR (2024) APPROVED
		// Visible on dashboard under 2024 - demonstrates year grouping
		ArtistApplication::create([
			'name'               => 'Елена',
			'surname'            => 'Христова',
			'email'              => 'elena.hristova@gmail.com',
			'phone'              => '072 100 200',
			'social_media'       => 'https://www.instagram.com/elena.hristova',
			'collaboration_area' => 'Сликарство',
			'message'            => 'Сликарка со изложби во Македонија и Србија.',
			'portfolio_path'     => null,
			'year'               => 2024,
			'status'             => 'approved',
			'admin_response'     => 'Одобрено. Добредојдовте на Еволуција на Сонот 3!',
			'responded_at'       => now()->subYear()->subDays(20),
			'responded_by'       => $admin?->id,
			'created_at'         => now()->subYear()->subDays(30),
			'updated_at'         => now()->subYear()->subDays(20),
		]);

		ArtistApplication::create([
			'name'               => 'Владимир',
			'surname'            => 'Ѓорѓиевски',
			'email'              => 'vladimir.gjorgijevski@gmail.com',
			'phone'              => '070 300 400',
			'social_media'       => null,
			'collaboration_area' => 'Скулптура',
			'message'            => 'Скулптор со искуство во јавни инсталации.',
			'portfolio_path'     => null,
			'year'               => 2024,
			'status'             => 'approved',
			'admin_response'     => 'Со задоволство ве прифаќаме на фестивалот.',
			'responded_at'       => now()->subYear()->subDays(15),
			'responded_by'       => $admin?->id,
			'created_at'         => now()->subYear()->subDays(25),
			'updated_at'         => now()->subYear()->subDays(15),
		]);

		// PAST YEAR (2024) PENDING
		// Demonstrates read-only restriction - admin cannot action this
		ArtistApplication::create([
			'name'               => 'Тања',
			'surname'            => 'Димитриевска',
			'email'              => 'tanja.dimitrievska@yahoo.com',
			'phone'              => '071 500 600',
			'social_media'       => 'https://www.instagram.com/tanja.dimitrievska',
			'collaboration_area' => 'Видео уметност',
			'message'            => 'Видео уметница со документарни проекти.',
			'portfolio_path'     => null,
			'year'               => 2024,
			'status'             => 'pending',
			'created_at'         => now()->subYear()->subDays(5),
			'updated_at'         => now()->subYear()->subDays(5),
		]);

		// CURRENT YEAR WITH PDF
		// Demonstrates file upload feature worked
		ArtistApplication::create([
			'name'               => 'Никола',
			'surname'            => 'Стојановски',
			'email'              => 'nikola.stojanovski@gmail.com',
			'phone'              => '078 700 800',
			'social_media'       => 'https://www.instagram.com/nikola.stojanovski',
			'collaboration_area' => 'Графички дизајн',
			'message'            => 'Графички дизајнер. Би сакал да придонесам со визуелниот идентитет на фестивалот.',
			'portfolio_path'     => 'uploads/demo-portfolio.pdf',
			'year'               => 2026,
			'status'             => 'pending',
		]);
	}
}
