<?php

namespace App\Http\Controllers;

use App\Models\Festival;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Toon het dashboard aan de ingelogde gebruiker.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $searchResults = null;

        // Controleer of er een zoekopdracht is

        if ($request->has('query')) {
            $query = $request->input('query');
            $searchResults = Festival::where('name', 'like', '%' . $query . '%')
                ->orWhere('location', 'like', '%' . $query . '%')
                ->get();
        }

        return view('dashboard.index', compact('user', 'searchResults'));
    }

    /**
     * Toon het admin-dashboard.
     */
    public function admin()
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Onbevoegde toegang.');
        }

        return view('dashboard.admin');
    }
}
