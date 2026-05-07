<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function checkout(Booking $booking)
    {
        if ($booking->customer_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status === 'confirmed') {
            return redirect()
                ->route('customer.bookings.index')
                ->with('success', 'This booking is already confirmed.');
        }

        if ($booking->status === 'cancelled') {
            return redirect()
                ->route('customer.bookings.index')
                ->withErrors([
                    'payment' => 'Cancelled bookings cannot be paid.'
                ]);
        }

        $booking->load('tourPackage');

        return view('customer.payments.checkout', compact('booking'));
    }

    public function pay(Request $request, Booking $booking)
    {
        if ($booking->customer_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status !== 'pending') {
            return redirect()
                ->route('customer.bookings.index')
                ->withErrors([
                    'payment' => 'Only pending bookings can be paid.'
                ]);
        }

        $request->validate([
            'card_holder' => 'required|string|max:255',
            'card_number' => 'required|string|min:12|max:19',
            'expiry_month' => 'required|integer|min:1|max:12',
            'expiry_year' => 'required|integer|min:' . date('Y'),
            'cvv' => 'required|string|min:3|max:4',
        ]);

        $transactionId = 'TXN-' . strtoupper(Str::random(10));

        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $booking->total_price,
            'payment_method' => 'sandbox_card',
            'transaction_id' => $transactionId,
            'payment_status' => 'successful',
        ]);

        $booking->update([
            'status' => 'confirmed',
        ]);

        return redirect()
            ->route('customer.payments.success', $booking->id)
            ->with('success', 'Payment successful. Your booking is now confirmed.');
    }

    public function success(Booking $booking)
    {
        if ($booking->customer_id !== auth()->id()) {
            abort(403);
        }

        $booking->load('tourPackage', 'payment');

        return view('customer.payments.success', compact('booking'));
    }
}