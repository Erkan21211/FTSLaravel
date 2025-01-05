<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BusPlanning;
use App\Models\Festival;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FestivalController extends Controller
{
    /**
     * Toon alle festivals.
     */
    public function index()
    {
        $busPlannings = BusPlanning::with(['festival', 'bus'])->get();
        return view('reizen.index', compact('busPlannings'));
    }

    /**
     * Toon details van een specifiek festival.
     */
    public function show(Festival $festival)
    {
        $busPlannings = BusPlanning::where('festival_id', $festival->id)->get();

        return view('reizen.show', compact('festival', 'busPlannings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'festival_id' => 'required|exists:festivals,id',
            'bus_planning_id' => 'required|exists:bus_planning,id',
        ]);

        $busPlanning = BusPlanning::findOrFail($validated['bus_planning_id']);

        // Controleer of er nog stoelen beschikbaar zijn
        if ($busPlanning->available_seats <= 0) {
            return redirect()->back()->with('error', 'Geen stoelen meer beschikbaar.');
        }

        // Maak de boeking aan
        Booking::create([
            'customer_id' => Auth::id(),
            'festival_id' => $validated['festival_id'],
            'bus_planning_id' => $validated['bus_planning_id'],
            'status' => 'geboekt',
            'cost' => $busPlanning->cost_per_seat,
        ]);

        // Verminder beschikbare stoelen
        $busPlanning->decrement('available_seats');

        return redirect()->route('dashboard')->with('success', 'Je busrit is succesvol geboekt!');
    }
}
