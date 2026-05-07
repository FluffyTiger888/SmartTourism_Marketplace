<?php

namespace App\Http\Controllers;

use App\Models\TourGuideAssignment;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    public function assignments()
    {
        if (auth()->user()->role !== 'tour_guide') {
            abort(403);
        }

        $assignments = TourGuideAssignment::with('booking.customer', 'booking.tourPackage')
            ->where('tour_guide_id', auth()->id())
            ->latest()
            ->get();

        return view('guide.assignments.index', compact('assignments'));
    }

    public function updateStatus(Request $request, TourGuideAssignment $assignment)
    {
        if (auth()->user()->role !== 'tour_guide') {
            abort(403);
        }

        if ($assignment->tour_guide_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:upcoming,ongoing,completed',
        ]);

        $assignment->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Tour status updated successfully.');
    }
}