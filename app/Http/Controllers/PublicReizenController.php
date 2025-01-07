<?php

namespace App\Http\Controllers;

use App\Models\BusPlanning;
use Illuminate\Http\Request;

class PublicReizenController extends Controller
{
    public function index()
    {
        // Haal alle beschikbare busplanningen op
        $busPlannings = BusPlanning::with('festival', 'bus')->get();

        return view('reizen.guest', compact('busPlannings'));
    }
}
