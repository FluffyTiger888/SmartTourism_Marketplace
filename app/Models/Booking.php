<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'tour_package_id',
        'number_of_people',
        'total_price',
        'status',
        'booking_date',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function tourPackage()
    {
        return $this->belongsTo(TourPackage::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function guideAssignment()
    {
        return $this->hasOne(TourGuideAssignment::class);
    }
}