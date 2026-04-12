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
		Schema::create('admin_profiles', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('user_id')->unique();
			$table->string('first_name', 100)->nullable();
			$table->string('last_name', 100)->nullable();
			$table->string('phone', 30)->nullable();
			$table->string('address', 255)->nullable();
			$table->string('city', 100)->nullable();
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('admin_profiles');
	}
};
