<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use App\Models\TourPackage;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(TourPackage $tourPackage)
    {
        $hasConfirmedBooking = Booking::where('customer_id', auth()->id())
            ->where('tour_package_id', $tourPackage->id)
            ->where('status', 'confirmed')
            ->exists();

        if (!$hasConfirmedBooking) {
            return redirect()
                ->route('customer.bookings.index')
                ->withErrors([
                    'review' => 'You can only review packages after confirming a booking.'
                ]);
        }

        $existingReview = Review::where('customer_id', auth()->id())
            ->where('tour_package_id', $tourPackage->id)
            ->first();

        return view('customer.reviews.create', compact('tourPackage', 'existingReview'));
    }

    public function store(Request $request, TourPackage $tourPackage)
    {
        $hasConfirmedBooking = Booking::where('customer_id', auth()->id())
            ->where('tour_package_id', $tourPackage->id)
            ->where('status', 'confirmed')
            ->exists();

        if (!$hasConfirmedBooking) {
            return redirect()
                ->route('customer.bookings.index')
                ->withErrors([
                    'review' => 'You can only review packages after confirming a booking.'
                ]);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::updateOrCreate(
            [
                'customer_id' => auth()->id(),
                'tour_package_id' => $tourPackage->id,
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        return redirect()
            ->route('packages.show', $tourPackage->id)
            ->with('success', 'Review submitted successfully.');
    }
}