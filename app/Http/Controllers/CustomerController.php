<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Toon klantenoverzicht
    public function index()
    {
        $customers = Customer::all();
        return view('admin.customers.index', compact('customers'));
    }

    // Toon formulier om een klant te bewerken
    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    // Update klantinformatie
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone_number' => 'nullable|string|max:20',
        ]);

        $customer->update($request->only(['name', 'email', 'phone_number']));

        return redirect()->route('admin.customers.index')->with('success', 'Klantgegevens succesvol bijgewerkt.');
    }

    // Toon formulier om een klant toe te voegen
    public function create()
    {
        return view('admin.customers.create');
    }

    // Sla nieuwe klant op
    public function store(Request $request)
    {
        // Valideer de invoer
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone_number' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        // Maak een nieuwe klant aan
        Customer::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'password' => bcrypt($validated['password']),
        ]);

        // Redirect naar klantenlijst met succesbericht
        return redirect()->route('admin.customers.index')
            ->with('success', 'Klant succesvol toegevoegd!');
    }

    // Verwijder een klant
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Klant succesvol verwijderd.');
    }
}
