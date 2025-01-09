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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone_number' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.customers.index')->with('success', 'Nieuwe klant succesvol toegevoegd.');
    }

    // Verwijder een klant
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Klant succesvol verwijderd.');
    }
}
