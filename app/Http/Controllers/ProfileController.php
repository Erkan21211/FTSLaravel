<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProfileController extends Controller
{



    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {


        $customer = Auth::user(); // Haal de ingelogde gebruiker op
        return view('profile.edit', compact('customer'));

//        return view('profile.edit', [
//            'user' => $request->user(),
//        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $customer = Auth::user();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers,email,' . $customer->id],
            'phone_number' => ['nullable', 'string', 'max:20'],
        ]);

        $customer->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Profiel succesvol bijgewerkt!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
