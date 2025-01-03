<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Festival;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingHistoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Een gebruiker kan zijn/haar reisgeschiedenis bekijken.
     */
    public function test_gebruiker_kan_reisgeschiedenis_bekijken()
    {
        // Arrange: Maak een gebruiker en boekingen aan
        $customer = Customer::factory()->create();
        $festival = Festival::factory()->create();

        $bookings = Booking::factory()->count(3)->create([
            'customer_id' => $customer->id,
            'festival_id' => $festival->id,
        ]);

        // Act: Bezoek de route voor de boekingsgeschiedenis
        $response = $this->actingAs($customer)->get(route('bookings.index'));

        // Assert: Controleer of de juiste gegevens worden weergegeven
        $response->assertStatus(200);
        $response->assertViewHas('bookings', function ($viewBookings) use ($bookings) {
            return $viewBookings->count() === $bookings->count();
        });
    }

    /**
     * Test: De reisgeschiedenis is gesorteerd op datum (recentste eerst).
     */
    public function test_reisgeschiedenis_is_gesorteerd_op_datum()
    {
        // Arrange: Maak een gebruiker en boekingen aan met verschillende datums
        $customer = Customer::factory()->create();
        $festival = Festival::factory()->create();

        Booking::factory()->create([
            'customer_id' => $customer->id,
            'festival_id' => $festival->id,
            'booking_date' => now()->subDays(1), // Boekingsdatum gisteren
        ]);

        Booking::factory()->create([
            'customer_id' => $customer->id,
            'festival_id' => $festival->id,
            'booking_date' => now(), // Boekingsdatum vandaag
        ]);

        // Act: Bezoek de route voor de boekingsgeschiedenis
        $response = $this->actingAs($customer)->get(route('bookings.index'));

        // Assert: Controleer of de boekingen gesorteerd zijn op datum
        $bookings = $response->viewData('bookings');
        $this->assertTrue($bookings[0]->booking_date->greaterThanOrEqualTo($bookings[1]->booking_date));
    }

    /**
     * Test: Een gebruiker ziet geen reisgeschiedenis van andere gebruikers.
     */
    public function test_gebruiker_ziet_geen_andermans_reisgeschiedenis()
    {
        // Arrange: Maak een gebruiker en een andere gebruiker met boekingen aan
        $customer = Customer::factory()->create();
        $otherCustomer = Customer::factory()->create();

        Booking::factory()->create([
            'customer_id' => $otherCustomer->id, // Boekingen van een andere gebruiker
        ]);

        // Act: Bezoek de route voor de boekingsgeschiedenis
        $response = $this->actingAs($customer)->get(route('bookings.index'));

        // Assert: Controleer dat er geen boekingen worden weergegeven
        $response->assertStatus(200);
        $response->assertViewHas('bookings', function ($viewBookings) {
            return $viewBookings->isEmpty();
        });
    }

    /**
     * Test: Een gebruiker zonder boekingen ziet een duidelijke melding.
     */
    public function test_gebruiker_met_geen_boekingen_ziet_melding()
    {
        // Arrange: Maak een gebruiker zonder boekingen aan
        $customer = Customer::factory()->create();

        // Act: Bezoek de route voor de boekingsgeschiedenis
        $response = $this->actingAs($customer)->get(route('bookings.index'));

        // Assert: Controleer of de melding correct wordt weergegeven
        $response->assertStatus(200);
        $response->assertSee('Je hebt nog geen boekingen.');
    }
}
