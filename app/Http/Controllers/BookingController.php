<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Toon de reisgeschiedenis van de ingelogde gebruiker.
     */
    public function index()
    {
        $bookings = Booking::where('customer_id', Auth::id())
            ->orderBy('booking_date', 'desc')
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function cancel(Booking $booking)
    {
        // Controleer of de ingelogde gebruiker eigenaar is van de boeking
        if ($booking->customer_id !== auth()->id()) {
            return redirect()->route('bookings.index')->withErrors('Je mag deze boeking niet annuleren.');
        }

        // Wijzig de status van de boeking naar 'geannuleerd'
        $booking->update(['status' => 'geannuleerd']);

        return redirect()->route('bookings.index')->with('success', 'De boeking is succesvol geannuleerd.');
    }
}
