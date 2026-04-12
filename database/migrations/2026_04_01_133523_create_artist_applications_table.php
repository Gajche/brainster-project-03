<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('artist_applications', function (Blueprint $table) {
			$table->id();

			// Artist personal info
			$table->string('name', 100);
			$table->string('surname', 100);
			$table->string('email', 255);
			$table->string('phone', 30)->nullable();
			$table->string('social_media', 500)->nullable();

			// Application content
			$table->string('collaboration_area', 255);  // "Во која област..."
			$table->text('message');                     // Short message
			$table->string('portfolio_path', 500)->nullable(); // PDF file path

			// Submission year - used for year-restriction logic
			$table->unsignedSmallInteger('year');

			// Status: pending | approved | rejected
			$table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

			// Admin response fields (filled when admin reviews)
			$table->text('admin_response')->nullable();
			$table->timestamp('responded_at')->nullable();
			$table->unsignedBigInteger('responded_by')->nullable(); // FK to users.id

			$table->timestamps();

			// Indexes for admin search functionality
			$table->index(['name', 'surname']);
			$table->index('email');
			$table->index('phone');
			$table->index(['status', 'year']);

			// Foreign key for admin who reviewed
			$table->foreign('responded_by')->references('id')->on('users')->nullOnDelete();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('artist_applications');
	}
};
