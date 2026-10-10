<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerBookingController extends Controller
{
    public function index()
    {
        $bookings = Auth::user()->bookings()->with(['service', 'vehicle'])->latest()->get();
        return view('customer.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $services = Service::all();
        $vehicles = Auth::user()->vehicles;
        return view('customer.bookings.create', compact('services', 'vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required',
            'customer_notes' => 'nullable|string|max:1000',
        ]);

        // Ensure the vehicle belongs to the authenticated user
        $vehicle = Vehicle::where('id', $validated['vehicle_id'])
                          ->where('user_id', Auth::id())
                          ->firstOrFail();

        Booking::create([
            'user_id' => Auth::id(),
            'vehicle_id' => $vehicle->id,
            'service_id' => $validated['service_id'],
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'status' => 'pending',
            'customer_notes' => $validated['customer_notes'],
        ]);

        return redirect()->route('customer.bookings.index')->with('success', 'Booking created successfully.');
    }
}
