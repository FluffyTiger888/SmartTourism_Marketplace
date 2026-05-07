<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\TourPackage;
use App\Models\TourGuideAssignment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request, TourPackage $tourPackage)
    {
        if (auth()->user()->role !== 'customer') {
            abort(403, 'Only customers can book tour packages.');
        }

        $request->validate([
            'number_of_people' => 'required|integer|min:1',
        ]);

        $numberOfPeople = $request->number_of_people;

        if ($tourPackage->status !== 'available') {
            return back()->withErrors([
                'booking' => 'This package is currently not available for booking.'
            ]);
        }

        if ($tourPackage->available_seats < $numberOfPeople) {
            return back()->withErrors([
                'number_of_people' => 'Not enough seats available for this package.'
            ]);
        }

        $totalPrice = $tourPackage->price * $numberOfPeople;

        Booking::create([
            'customer_id' => auth()->id(),
            'tour_package_id' => $tourPackage->id,
            'number_of_people' => $numberOfPeople,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'booking_date' => now()->toDateString(),
        ]);

        $tourPackage->decrement('available_seats', $numberOfPeople);

        return redirect()
            ->route('customer.bookings.index')
            ->with('success', 'Booking created successfully. Please complete payment to confirm your booking.');
    }

    public function customerBookings()
    {
        $bookings = Booking::with('tourPackage', 'payment', 'guideAssignment.guide')
            ->where('customer_id', auth()->id())
            ->latest()
            ->get();

        return view('customer.bookings.index', compact('bookings'));
    }

    public function cancel(Booking $booking)
    {
        if ($booking->customer_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status === 'confirmed') {
            return back()->withErrors([
                'cancel' => 'Confirmed bookings cannot be cancelled from here.'
            ]);
        }

        if ($booking->status !== 'cancelled') {
            $booking->tourPackage->increment('available_seats', $booking->number_of_people);

            $booking->update([
                'status' => 'cancelled',
            ]);
        }

        return back()->with('success', 'Booking cancelled successfully.');
    }

    public function agencyBookings()
    {
        if (auth()->user()->role !== 'agency_owner') {
            abort(403);
        }

        $bookings = Booking::with('customer', 'tourPackage', 'payment', 'guideAssignment.guide')
            ->whereHas('tourPackage', function ($query) {
                $query->where('agency_id', auth()->id());
            })
            ->latest()
            ->get();

        $guides = User::where('role', 'tour_guide')
            ->where('is_active', true)
            ->get();

        return view('agency.bookings.index', compact('bookings', 'guides'));
    }

    public function assignGuide(Request $request, Booking $booking)
    {
        if (auth()->user()->role !== 'agency_owner') {
            abort(403);
        }

        if ($booking->tourPackage->agency_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status !== 'confirmed') {
            return back()->withErrors([
                'guide' => 'Only confirmed bookings can be assigned to a tour guide.'
            ]);
        }

        $request->validate([
            'tour_guide_id' => 'required|exists:users,id',
        ]);

        $guide = User::where('id', $request->tour_guide_id)
            ->where('role', 'tour_guide')
            ->first();

        if (!$guide) {
            return back()->withErrors([
                'tour_guide_id' => 'Selected user is not a valid tour guide.'
            ]);
        }

        TourGuideAssignment::updateOrCreate(
            [
                'booking_id' => $booking->id,
            ],
            [
                'tour_guide_id' => $guide->id,
                'status' => 'upcoming',
            ]
        );

        return back()->with('success', 'Tour guide assigned successfully.');
    }
}