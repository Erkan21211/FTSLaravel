<?php

namespace App\Http\Controllers;

use App\Models\Festival;
use Illuminate\Http\Request;

class FestivalController extends Controller
{
    /**
     * Toon alle festivals.
     */
    public function index()
    {
        $festivals = Festival::all();
        return view('reizen.index', compact('festivals'));
    }

    /**
     * Toon details van een specifiek festival.
     */
    public function show(Festival $festival)
    {
        $busPlanning = $festival->busPlanning; // Relatie tussen festival en bus_planning
        return view('reizen.show', compact('festival', 'busPlanning'));
    }
}
