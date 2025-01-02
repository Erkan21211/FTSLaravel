<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function profielpagina_is_toegankelijk()
    {
        // Arrange: Maak een gebruiker aan en log in
        $user = Customer::factory()->create();

        // Act: Open de profielpagina
        $response = $this->actingAs($user)->get(route('profile.edit'));

        // Assert: Controleer of de pagina toegankelijk is
        $response->assertStatus(200);
        $response->assertViewIs('profile.edit');
    }

    /** @test */
    public function gebruiker_kan_profielgegevens_bijwerken()
    {
        // Arrange: Maak een gebruiker aan en log in
        $user = Customer::factory()->create();

        $newData = [
            'first_name' => 'NieuweVoornaam',
            'last_name' => 'NieuweAchternaam',
            'email' => 'nieuwe_email@example.com',
            'phone_number' => '0612345678',
        ];

        // Act: Verstuur een PATCH-verzoek
        $response = $this->actingAs($user)->patch(route('profile.update'), $newData);

        // Debug: Controleer de redirect en database
//        dd($response->headers->get('Location'), $user->fresh()->toArray());

        // Assert: Controleer de redirect en database
        $response->assertRedirect(route('profile.edit'));
        $this->assertDatabaseHas('customers', [
            'id' => $user->id,
            'first_name' => 'NieuweVoornaam',
            'last_name' => 'NieuweAchternaam',
            'email' => 'nieuwe_email@example.com',
            'phone_number' => '0612345678',
        ]);
    }

    /** @test */
    public function validatie_faalt_bij_ongeldige_gegevens()
    {
        // Arrange: Maak een gebruiker aan en log in
        $user = Customer::factory()->create();

        // Ongeldige gegevens
        $invalidData = [
            'first_name' => '', // Verplicht veld
            'last_name' => '',  // Verplicht veld
            'email' => 'geen_geldig_emailadres', // Ongeldig e-mailadres
            'phone_number' => str_repeat('1', 21), // Maximaal 20 karakters
        ];

        // Act: Verstuur een PATCH-verzoek met ongeldige gegevens
        $response = $this->actingAs($user)->patch(route('profile.update'), $invalidData);

        // Assert: Controleer of de validatiefouten worden weergegeven
        $response->assertSessionHasErrors([
            'first_name',
            'last_name',
            'email',
            'phone_number',
        ]);

        // Controleer dat de gegevens niet zijn bijgewerkt
        $this->assertDatabaseHas('customers', [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
        ]);
    }
}
