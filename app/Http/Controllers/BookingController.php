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
            ->orderByRaw("CASE WHEN status = 'actief' THEN 0 ELSE 1 END")
            ->orderBy('booking_date', 'desc')
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Toon de details van een boeking.
     */

    public function show(Booking $booking) {

        if ($booking->customer_id !== auth()->id()) {
            abort(403, 'Je hebt geen toegang tot deze boeking.');
        }

        return view('bookings.show', compact('booking'));
    }


    public function store(Request $request, BusPlanning $busPlanning)
    {
        // Controleer of de gebruiker al een actieve boeking heeft voor deze busrit
        $existingBooking = Booking::where('customer_id', auth()->id())
            ->where('bus_planning_id', $busPlanning->id)
            ->where('status', 'actief')
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

        // Haal de huidige gebruiker op
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->withErrors([
                'message' => 'Je moet ingelogd zijn om een boeking te maken.',
            ]);
        }

        // Maak een nieuwe boeking aan
        $booking = Booking::create([
            'customer_id' => $user->id,
            'festival_id' => $busPlanning->festival_id,
            'bus_planning_id' => $busPlanning->id,
            'booking_date' => now(),
            'cost' => $busPlanning->cost_per_seat,
            'status' => 'actief',
        ]);

        if (!$booking) {
            return redirect()->route('bookings.index')->withErrors([
                'message' => 'Er is iets misgegaan tijdens het maken van de boeking.',
            ]);
        }

        // Bereken en voeg punten toe aan de gebruiker
        $earnedPoints = (int)$busPlanning->cost_per_seat;

        try {
            $user->increment('points', $earnedPoints);
        } catch (\Exception $e) {
            return redirect()->route('bookings.index')->withErrors([
                'message' => 'Er is een fout opgetreden bij het toekennen van punten: ' . $e->getMessage(),
            ]);
        }

        // Verhoog het aantal gevulde stoelen
        $busPlanning->increment('seats_filled');

        return redirect()->route('bookings.index')->with('success', "Boeking succesvol aangemaakt. Je hebt $earnedPoints punten verdiend!");
    }

    public function cancel(Booking $booking)
    {
        // Controleer of de ingelogde gebruiker eigenaar is van de boeking
        if ($booking->customer_id !== auth()->id()) {
            return redirect()->route('bookings.index')->withErrors('Je mag deze boeking niet annuleren.');
        }

        // Controleer of de boeking actief is
        if ($booking->status !== 'actief') {
            return redirect()->route('bookings.index')->withErrors([
                'message' => 'Boeking is niet geldig voor puntentoekenning.',
            ]);
        }

        // Haal de gerelateerde busplanning op
        $busPlanning = $booking->busPlanning;

        if ($busPlanning) {
            // Verminder het aantal gevulde stoelen
            $busPlanning->decrement('seats_filled');
        } else {
            return redirect()->route('bookings.index')->withErrors('Er is een probleem met de gekoppelde busplanning.');
        }

        // Haal de gebruiker op en verminder de punten zonder negatief saldo toe te staan
        $user = auth()->user();
        $pointsToDeduct = (int)$booking->cost;
        $user->update(['points' => max(0, $user->points - $pointsToDeduct)]);

        // Wijzig de status van de boeking naar 'geannuleerd'
        $booking->update(['status' => 'geannuleerd']);

        return redirect()->route('bookings.index')->with('success', 'De boeking is succesvol geannuleerd.');
    }


    // Inwisselen van punten voor een boeking
    public function redeemPoints(Request $request, BusPlanning $busPlanning)
    {
        $user = auth()->user();

        // Haal de benodigde punten op
        $requiredPoints = $busPlanning->cost_per_seat;

        // Controleer of de gebruiker voldoende punten heeft
        if ($user->points < $requiredPoints) {
            return redirect()->route('reizen.show', $busPlanning->id)->withErrors([
                'message' => 'Onvoldoende punten om deze boeking te maken.',
            ]);
        }

        // Verwerk de korting
        Booking::create([
            'customer_id' => $user->id,
            'festival_id' => $busPlanning->festival_id,
            'bus_planning_id' => $busPlanning->id,
            'booking_date' => now(),
            'cost' => 0, // Geen kosten vanwege puntenkorting
            'status' => 'actief',
        ]);

        // Verminder het puntensaldo
        $user->decrement('points', $requiredPoints);

        return redirect()->route('bookings.index')->with('success', "Je hebt $requiredPoints punten ingewisseld voor deze boeking!");
    }


}
