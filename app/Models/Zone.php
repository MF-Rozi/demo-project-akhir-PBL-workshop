<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Zone extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    public function attractions(): HasMany
    {
        return $this->hasMany(Attraction::class);
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function approvedReviews(): MorphMany
    {
        return $this->reviews()->where('is_approved', true);
    }

    public function averageRating()
    {
        return $this->approvedReviews()->avg('rating');
    }
}
