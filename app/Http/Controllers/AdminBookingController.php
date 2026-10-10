<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index()
    {
        // Eager load relationships to prevent N+1 query problems
        $bookings = Booking::with(['user', 'vehicle', 'service'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,in_progress,completed,cancelled'
        ]);

        $booking->update([
            'status' => $validated['status']
        ]);

        return back()->with('success', 'Booking status updated successfully.');
    }
}
