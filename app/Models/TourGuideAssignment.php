<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourGuideAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'tour_guide_id',
        'status',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function guide()
    {
        return $this->belongsTo(User::class, 'tour_guide_id');
    }
}