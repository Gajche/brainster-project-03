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
			$table->string('collaboration_area', 255);
			$table->text('message');
			$table->string('portfolio_path', 500)->nullable();

			// Submission year
			$table->unsignedSmallInteger('year');

			// Status: pending | approved | rejected
			$table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

			// Admin response fields
			$table->text('admin_response')->nullable();
			$table->timestamp('responded_at')->nullable();
			$table->unsignedBigInteger('responded_by')->nullable();

			$table->timestamps();

			// 'deleted_at' column
			$table->softDeletes();

			// Indexes
			$table->index(['name', 'surname']);
			$table->index('email');
			$table->index('phone');
			// Modified index to include deleted_at for faster dashboard queries
			$table->index(['status', 'year', 'deleted_at']);

			// Foreign key
			$table->foreign('responded_by')->references('id')->on('users')->nullOnDelete();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('artist_applications');
	}
};
