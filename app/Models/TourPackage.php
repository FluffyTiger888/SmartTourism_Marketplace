<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_id',
        'title',
        'destination',
        'description',
        'price',
        'duration',
        'max_capacity',
        'available_seats',
        'status',
        'tags',
    ];

    public function agency()
    {
        return $this->belongsTo(User::class, 'agency_id');
    }

    public function itineraries()
    {
        return $this->hasMany(Itinerary::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }
}