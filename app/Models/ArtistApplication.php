<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArtistApplication extends Model
{
	use SoftDeletes;
	protected $fillable = [
		'name',
		'surname',
		'email',
		'phone',
		'social_media',
		'collaboration_area',
		'message',
		'portfolio_path',
		'year',
		'status',
		'admin_response',
		'responded_at',
		'responded_by',
	];

	protected $casts = [
		'responded_at' => 'datetime',
		'year'         => 'integer',
	];

	/**
	 * We use this to clear the dashboard cache whenever data changes.
	 */
	protected static function booted()
	{
		// This runs for Create and Update
		static::saved(function () {
			Cache::forget('admin_stats');
		});

		// This runs for Delete
		static::deleted(function () {
			Cache::forget('admin_stats');
		});
	}

	public function respondedBy()
	{
		return $this->belongsTo(User::class, 'responded_by');
	}

	public function scopePending(Builder $query): Builder
	{
		return $query->where('status', 'pending');
	}

	public function scopeCurrentYear(Builder $query): Builder
	{
		return $query->where('year', now()->year);
	}

	public function scopeApproved(Builder $query): Builder
	{
		return $query->where('status', 'approved');
	}

	public function scopeSearch(Builder $query, ?string $term): Builder
	{
		return $query->when($term, function ($q, $term) {
			$like = '%' . $term . '%';
			$q->where(function ($sub) use ($like) {
				$sub->where('name', 'like', $like)
					->orWhere('surname', 'like', $like)
					->orWhere('email', 'like', $like)
					->orWhere('phone', 'like', $like);
			});
		});
	}

	public function isCurrentYear(): bool
	{
		return $this->year === now()->year;
	}

	public function isPending(): bool
	{
		return $this->status === 'pending';
	}
}
