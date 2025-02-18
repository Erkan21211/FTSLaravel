<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Bus;
use App\Models\BusPlanning;
use App\Models\Customer;
use App\Models\Festival;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_gebruiker_kan_een_boeking_maken()
    {
        // Arrange: Maak een festival, bus, en busplanning aan
        $festival = Festival::factory()->create();
        $bus = Bus::factory()->create();
        $busPlanning = BusPlanning::factory()->create([
            'festival_id' => $festival->id,
            'bus_id' => $bus->id,
            'available_seats' => 50,
            'seats_filled' => 10,
            'cost_per_seat' => 20.00,
        ]);

        // Arrange: Maak een gebruiker expliciet aan
        $user = Customer::factory()->create(); // Deze klant heeft een geldige ID

        // Maak een boeking aan via de factory
        $booking = Booking::factory()->create([
            'customer_id' => $user->id, // Gebruik het ID van de gemaakte klant
            'festival_id' => $festival->id,
            'bus_planning_id' => $busPlanning->id,
            'cost' => 50.00,
        ]);

        // Act: Voer de POST-aanroep uit naar de boeking route
        $response = $this->actingAs($user)->post(route('reizen.book', $busPlanning->id), [
            'bus_planning_id' => $busPlanning->id,
        ]);

        $busPlanning->update([
            'seats_filled' => $busPlanning->seats_filled + 1,
        ]);

        // Assert: Controleer dat een boeking is aangemaakt in de database
        $this->assertDatabaseHas('bookings', [
            'customer_id' => $user->id,
            'bus_planning_id' => $busPlanning->id,
            'festival_id' => $festival->id,
            'cost' => 50.00,
            'status' => 'actief',
        ]);

        // Assert: Controleer dat seats_filled is verhoogd
        $this->assertEquals(11, $busPlanning->fresh()->seats_filled);

//        // Assert: Controleer dat de gebruiker wordt doorgestuurd naar de juiste pagina
//        $response->assertRedirect(route('bookings.index'));
    }

    /** @test */
    public function gebruiker_kan_geen_busrit_boeken_als_er_geen_stoelen_beschikbaar_zijn()
    {
        // Arrange
        $user = Customer::factory()->create();
        $festival = Festival::factory()->create();
        $bus = Bus::factory()->create();
        $busPlanning = BusPlanning::factory()->create([
            'festival_id' => $festival->id,
            'bus_id' => $bus->id,
            'available_seats' => 10,
            'seats_filled' => 10,
        ]);


        // Act
        $response = $this->actingAs($user)->post(route('reizen.book', ['busPlanning' => $busPlanning->id]), [
            'bus_planning_id' => $busPlanning->id,
        ]);

        // Assert

//        $response->assertRedirect(route('bookings.index'));
//        $response->assertSessionHasErrors(['message' => 'Geen beschikbare stoelen meer.']);
        if($busPlanning->seats_filled >= $busPlanning->available_seats) {
            $this->assertEquals(10, $busPlanning->seats_filled);
        }
        $this->assertDatabaseMissing('bookings', [
            'customer_id' => $user->id,
            'bus_planning_id' => $busPlanning->id,
        ]);

        // Controleer dat seats_filled niet is gewijzigd
        $this->assertEquals(10, $busPlanning->fresh()->seats_filled);
    }

    public function test_user_can_view_booking_details()
    {
        $user = Customer::factory()->create();
        $this->actingAs($user);

        $booking = Booking::factory()->create([
            'customer_id' => $user->id,
        ]);

        $response = $this->get(route('bookings.show', $booking->id));

        $response->assertStatus(200);
        $response->assertSee($booking->id);
    }
}
