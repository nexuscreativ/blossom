<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingReview extends Model
{
    protected $fillable = ['listing_id', 'user_id', 'rating', 'comment'];

    protected function casts(): array
    {
        return ['rating' => 'integer'];
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
