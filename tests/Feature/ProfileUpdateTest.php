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
        // Schakel alle middleware uit (inclusief CSRF)
        $this->withoutMiddleware();

        // Maak een gebruiker met vaste beginwaarden
        $user = Customer::factory()->create([
            'first_name'   => 'Pepijn',
            'last_name'    => 'de Ruiter',
            'email'        => 'muller.thijmen@example.com',
            'phone_number' => '0622414609',
        ]);

        $newData = [
            'first_name'   => 'NieuweVoornaam',
            'last_name'    => 'NieuweAchternaam',
            'email'        => 'nieuwe.email@example.com',
            'phone_number' => '0612345678',
        ];

        // Act: Voer de PATCH-request uit
        $response = $this->actingAs($user)->patch(route('profile.update'), $newData);

        // Assert: Controleer dat er geredirect wordt naar de profielpagina
        $response->assertRedirect(route('profile.edit'));

        // Assert: Controleer dat de database de nieuwe gegevens bevat
        $this->assertDatabaseHas('customers', [
            'id'           => $user->id,
            'first_name'   => 'NieuweVoornaam',
            'last_name'    => 'NieuweAchternaam',
            'email'        => 'nieuwe.email@example.com',
            'phone_number' => '0612345678',
        ]);
    }



    /** @test */
    public function validatie_faalt_bij_ongeldige_gegevens()
    {
        // Schakel alle middleware uit (inclusief CSRF)
        $this->withoutMiddleware();

        // Arrange: Maak een gebruiker aan
        $user = Customer::factory()->create();

        // Ongeldige gegevens
        $invalidData = [
            'first_name'   => '', // verplicht veld
            'last_name'    => '', // verplicht veld
            'email'        => 'geen_geldig_emailadres', // ongeldig e-mailadres
            'phone_number' => str_repeat('1', 21), // te lang, maximaal 20 karakters
        ];

        // Act: Verstuur de PATCH-request en geef een "from"-URL op (controleer of deze route bestaat of gebruik een URL-string)
        $response = $this->actingAs($user)
            ->from('/profile/edit')
            ->patch(route('profile.update'), $invalidData);

        // Assert: De response moet redirecten naar de "from"-URL en validatiefouten bevatten
        $response->assertStatus(302);
        $response->assertRedirect('/profile/edit');
        $response->assertSessionHasErrors(['first_name', 'last_name', 'email', 'phone_number']);

        // Assert: Controleer dat de gebruiker in de database niet is gewijzigd
        $this->assertDatabaseHas('customers', [
            'id'           => $user->id,
            'first_name'   => $user->first_name,
            'last_name'    => $user->last_name,
            'email'        => $user->email,
            'phone_number' => $user->phone_number,
        ]);
    }

}
