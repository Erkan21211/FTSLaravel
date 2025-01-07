<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // Hier kun je bijvoorbeeld een e-mail sturen of het bericht opslaan in de database.
        // Voorbeeld: Mail versturen
        /*
        Mail::to('admin@festivaltravelsystem.com')->send(new ContactMail($request->all()));
        */

        return redirect()->route('contact')->with('success', 'Uw bericht is verzonden. We nemen spoedig contact met u op!');
    }
}
