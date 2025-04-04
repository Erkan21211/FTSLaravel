<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Customer;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the registration form is displayed.
     */
    public function test_registration_form_is_accessible()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Register');
    }

    public function test_user_can_register()
    {
        // Start de sessie zodat we een CSRF-token krijgen
        session()->start();
        $data = [
            '_token'                => session()->token(),
            'first_name'            => 'John',
            'last_name'             => 'Doe',
            'email'                 => 'john.doe@example.com',
            'phone_number'          => '1234567890',
            'password'              => 'Password123!',
            'password_confirmation' => 'Password123!',
        ];

        $response = $this->post('/register', $data);
        $response->assertRedirect('/login');

        $this->assertDatabaseHas('customers', [
            'email' => 'john.doe@example.com',
        ]);
    }

    public function test_registration_validation_fails_with_invalid_data()
    {
        session()->start();
        $data = [
            '_token'                => session()->token(),
            'first_name'            => '', // leeg: verplicht veld
            'last_name'             => 'Doe',
            'email'                 => 'invalid-email', // ongeldig e-mailadres
            'phone_number'          => '123456789012345678901', // te lang (meer dan 20 karakters)
            'password'              => 'short', // te kort en voldoet niet aan de eisen
            'password_confirmation' => 'short',
        ];

        $response = $this->post('/register', $data);
        $response->assertSessionHasErrors(['first_name', 'email', 'password']);
    }

    public function test_registration_fails_with_duplicate_email()
    {
        // Maak een bestaande klant aan
        Customer::create([
            'first_name'   => 'Jane',
            'last_name'    => 'Doe',
            'email'        => 'jane.doe@example.com',
            'phone_number' => '1234567890',
            'password'     => bcrypt('Password123!'),
        ]);

        session()->start();
        $data = [
            '_token'                => session()->token(),
            'first_name'            => 'John',
            'last_name'             => 'Doe',
            'email'                 => 'jane.doe@example.com', // duplicate email
            'phone_number'          => '0987654321',
            'password'              => 'Password123!',
            'password_confirmation' => 'Password123!',
        ];

        $response = $this->post('/register', $data);
        $response->assertSessionHasErrors(['email']);
    }
}
