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
        $response->assertStatus(200); // Check if the page loads successfully
        $response->assertSee('Register'); // Verify the presence of the form
    }

    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone_number' => '1234567890',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('customers', [
            'email' => 'john.doe@example.com',
        ]);
    }

    public function test_registration_validation_fails_with_invalid_data()
    {
        $response = $this->post('/register', [
            'first_name' => '',
            'last_name' => 'Doe',
            'email' => 'invalid-email',
            'phone_number' => '123456789012345678901', // Too long
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertSessionHasErrors(['first_name', 'email', 'password']);
    }

    public function test_registration_fails_with_duplicate_email()
    {
        // Create an existing customer
        Customer::create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane.doe@example.com',
            'phone_number' => '1234567890',
            'password' => bcrypt('Password123!'),
        ]);

        $response = $this->post('/register', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'jane.doe@example.com', // Duplicate email
            'phone_number' => '0987654321',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasErrors(['email']);
    }
}
