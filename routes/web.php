<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArtCityController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\WorkWithUsController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use Illuminate\Support\Facades\Route;

// PUBLIC ROUTES
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/art-city', [ArtCityController::class, 'index'])->name('art-city');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/work-with-us', [WorkWithUsController::class, 'index'])->name('work-with-us');

// Artist application submit - rate limited (max 3 per IP per hour, throttle:3,60 for production, 100 per minute for testing)
Route::post('/apply', [ApplicationController::class, 'store'])
	->name('apply')
	->middleware('throttle:100,1');


// BREEZE AUTH ROUTES (login, logout, password reset)
require __DIR__ . '/auth.php';

// ADMIN ROUTES - protected by auth middleware
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {

	// Dashboard - shows approved apps by year
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

	// Applications
	Route::get('/applications/pending', [AdminApplicationController::class, 'pending'])
		->name('applications.pending');

	Route::get('/applications', [AdminApplicationController::class, 'all'])
		->name('applications.all');

	Route::get('/applications/{application}', [AdminApplicationController::class, 'show'])
		->name('applications.show');

	Route::post('/applications/{application}/review', [AdminApplicationController::class, 'review'])
		->name('applications.review');

	// Admin profile
	Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
});

// Redirect /admin to dashboard (convenience)
Route::redirect('/admin', '/admin/dashboard');

// Toastr-test
Route::get('/test-toast', function () {
	return redirect('/')->with('success', 'Сè работи совршено! (Everything works perfectly!)');
});
