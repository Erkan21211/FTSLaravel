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
    public function gebruiker_kan_een_busrit_boeken()
    {
        // Arrange
        $festival = Festival::factory()->create();
        $bus = Bus::factory()->create();
        $busPlanning = BusPlanning::factory()->create([
            'festival_id' => $festival->id,
            'bus_id' => $bus->id,
            'available_seats' => 50,
            'seats_filled' => 10,
        ]);

        $user = Customer::factory()->create();

        // Act
        $response = $this->actingAs($user)->post(route('reizen.book', $busPlanning->id), [
            'bus_planning_id' => $busPlanning->id,
        ]);

        $this->assertDatabaseCount('bookings', 1);

        // Assert
        $response->assertRedirect(route('bookings.index'));
        $this->assertDatabaseHas('bookings', [
            'customer_id' => $user->id,
            'bus_planning_id' => $busPlanning->id,
        ]);
        // Controleer de seats_filled
        $this->assertEquals(11, $busPlanning->fresh()->seats_filled);
    }

    /** @test */
    public function gebruiker_kan_geen_busrit_boeken_als_er_geen_stoelen_beschikbaar_zijn()
    {
        // Arrange
        $festival = Festival::factory()->create();
        $bus = Bus::factory()->create();
        $busPlanning = BusPlanning::factory()->create([
            'festival_id' => $festival->id,
            'bus_id' => $bus->id,
            'available_seats' => 10,
            'seats_filled' => 10,
        ]);

        $user = Customer::factory()->create();

        // Act
        $response = $this->actingAs($user)->post(route('reizen.book', ['busPlanning' => $busPlanning->id]), [
            'bus_planning_id' => $busPlanning->id,
        ]);

        // Assert
        $response->assertRedirect(route('bookings.index'));
        $response->assertSessionHasErrors(['message' => 'Geen beschikbare stoelen meer.']);
        $this->assertDatabaseMissing('bookings', [
            'customer_id' => $user->id,
            'bus_planning_id' => $busPlanning->id,
        ]);

        // Controleer dat seats_filled niet is gewijzigd
        $this->assertEquals(10, $busPlanning->fresh()->seats_filled);
    }
}
