<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BusPlanning;
use Illuminate\Http\Request;
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

    public function store(Request $request, BusPlanning $busPlanning)
    {
        // gebruiker al een actieve boeking heeft voor dezelfde busrit
        $existingBooking = Booking::where('customer_id', auth()->id())
            ->where('bus_planning_id', $busPlanning->id)
            ->where('status', 'actief') // Controleer alleen op actieve boekingen
            ->first();

        if ($existingBooking) {
            return redirect()->route('bookings.index')->withErrors([
                'message' => 'Je hebt deze busrit al geboekt.',
            ]);
        }

        // Controleer of er nog stoelen beschikbaar zijn
        if ($busPlanning->seats_filled >= $busPlanning->available_seats) {
            return redirect()->route('bookings.index')->withErrors([
                'message' => 'Geen beschikbare stoelen meer.',
            ]);
        }

        // Maak een nieuwe boeking aan
        Booking::create([
            'customer_id' => auth()->id(),
            'festival_id' => $busPlanning->festival_id,
            'bus_planning_id' => $busPlanning->id,
            'booking_date' => now(),
            'cost' => $busPlanning->cost_per_seat,
            'status' => 'actief',
        ]);

        // Verhoog het aantal gevulde stoelen
        $busPlanning->increment('seats_filled');

        return redirect()->route('bookings.index')->with('success', 'Boeking succesvol aangemaakt.');
    }
    public function cancel(Booking $booking)
    {
        // de ingelogde gebruiker eigenaar is van de boeking
        if ($booking->customer_id !== auth()->id()) {
            return redirect()->route('bookings.index')->withErrors('Je mag deze boeking niet annuleren.');
        }

        // Haal de gerelateerde busplanning op
        $busPlanning = $booking->busPlanning;

        if ($busPlanning) {
            // Verminder het aantal gevulde stoelen
            $busPlanning->decrement('seats_filled');
        }

        // Wijzig de status van de boeking naar 'geannuleerd'
        $booking->update(['status' => 'geannuleerd']);

        return redirect()->route('bookings.index')->with('success', 'De boeking is succesvol geannuleerd.');
    }
}
