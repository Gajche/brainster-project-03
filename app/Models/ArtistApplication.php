<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ArtistApplication extends Model
{
	// Mass assignment protection - only these fields are fillable
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

	// Relationship: admin who responded
	public function respondedBy()
	{
		return $this->belongsTo(User::class, 'responded_by');
	}

	// Scope: only pending applications
	public function scopePending(Builder $query): Builder
	{
		return $query->where('status', 'pending');
	}

	// Scope: only current year - used for year restriction
	public function scopeCurrentYear(Builder $query): Builder
	{
		return $query->where('year', now()->year);
	}

	// Scope: approved applications
	public function scopeApproved(Builder $query): Builder
	{
		return $query->where('status', 'approved');
	}

	// Helper: is this application from the current year?
	public function isCurrentYear(): bool
	{
		return $this->year === now()->year;
	}

	// Helper: is this application still pending?
	public function isPending(): bool
	{
		return $this->status === 'pending';
	}
}
