<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\BusPlanning;
use App\Models\Festival;
use Illuminate\Http\Request;

class FestivalAdminController extends Controller
{
    /**
     * Toon het overzicht van reizen.
     */
    public function index()
    {
        // Laad de bus en festival relaties mee
        $busPlannings = BusPlanning::with('bus', 'festival')->get();

        return view('admin.reizen.index', compact('busPlannings'));
    }

    /**
     * Toon het formulier om een nieuwe reis toe te voegen.
     */
    public function create()
    {
        $buses = Bus::all();
        return view('admin.reizen.create', compact('buses'));
    }

    /**
     * Sla een nieuwe reis op.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'cost_per_seat' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:1',
            'bus_id' => 'required|exists:buses,id',
        ]);

        // Maak een nieuw festival aan
        $festival = Festival::create($request->only(['name', 'location', 'start_date', 'end_date']));

        // Maak een bijbehorende busplanning aan
        BusPlanning::create([
            'festival_id' => $festival->id,
            'bus_id' => $request->bus_id,
            'departure_time' => $request->start_date, // Gebruik startdatum als vertrekdatum
            'departure_location' => $request->location,
            'available_seats' => $request->available_seats,
            'cost_per_seat' => $request->cost_per_seat,
        ]);

        return redirect()->route('admin.reizen.index')->with('success', 'Nieuwe reis succesvol toegevoegd.');
    }

    /**
     * maak een nieuwe bus aan (view)
      */
    public function createBus()
    {
        // de view met het formulier voor het toevoegen van een bus
        return view('admin.buses.create');
    }

    public function storeBus(Request $request)
    {
        // Valideer de invoer
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        // Maak een nieuwe bus aan
        Bus::create($request->only(['name', 'capacity']));

        // Redirect met succesbericht
        return redirect()->route('admin.reizen.index')->with('success', 'Nieuwe bus succesvol toegevoegd.');
    }

    public function edit(Festival $festival)
    {
        $festival->load('busPlanning'); // Laad de busPlanning mee

        return view('admin.reizen.edit', compact('festival'));
    }


    public function update(Request $request, Festival $festival)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'cost_per_seat' => 'required|numeric|min:0',
                'available_seats' => 'required|integer|min:1',
                'bus_id' => 'required|exists:buses,id',
            ]);

            // Update Festival
            $festival->update([
                'name' => $request->name,
                'location' => $request->location,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            // Update of maak een nieuwe BusPlanning
            $busPlanning = BusPlanning::where('festival_id', $festival->id)->first();
            if ($busPlanning) {
                $busPlanning->update([
                    'bus_id' => $request->bus_id,
                    'departure_time' => $request->start_date,
                    'departure_location' => $request->location,
                    'available_seats' => $request->available_seats,
                    'cost_per_seat' => $request->cost_per_seat,
                ]);
            } else {
                BusPlanning::create([
                    'festival_id' => $festival->id,
                    'bus_id' => $request->bus_id,
                    'departure_time' => $request->start_date,
                    'departure_location' => $request->location,
                    'available_seats' => $request->available_seats,
                    'cost_per_seat' => $request->cost_per_seat,
                ]);
            }

            return redirect()->route('admin.reizen.index')->with('success', 'Reis succesvol bijgewerkt.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Er is een fout opgetreden: ' . $e->getMessage()]);
        }
    }




    public function destroy(Festival $festival)
    {
        $festival->delete();

        return redirect()->route('admin.reizen.index')->with('success', 'Reis succesvol verwijderd.');
    }
}
