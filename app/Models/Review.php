<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
    protected $fillable = [
        'reviewable_type',
        'reviewable_id',
        'visitor_name',
        'visitor_email',
        'rating',
        'comment',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'rating' => 'integer',
    ];

    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

    public function isAttractionReview(): bool
    {
        return $this->reviewable_type === Attraction::class;
    }

    public function getAttractionAttribute(): ?Attraction
    {
        return $this->isAttractionReview() ? $this->reviewable : null;
    }

    public function getZoneAttribute(): ?Zone
    {
        return $this->isAttractionReview() ? null : $this->reviewable;
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }
}
