<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Bus;
use App\Models\BusPlanning;
use App\Models\Customer;
use App\Models\Festival;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PuntenTest extends TestCase
{
    use refreshDatabase;


    // Punten toevoegen bij een succesvolle boeking
    public function test_gebruiker_verdiend_punten_bij_een_succesvolle_booking()
    {
        $user = Customer::factory()->create(['points' => 0]);
        $this->actingAs($user);

        $festival = Festival::factory()->create();
        $bus = Bus::factory()->create();
        $busPlanning = BusPlanning::factory()->create([
            'festival_id' => $festival->id,
            'bus_id' => $bus->id,
            'available_seats' => 50,
            'cost_per_seat' => 25,
            'seats_filled' => 0,
        ]);

        $this->post(route('reizen.book', ['busPlanning' => $busPlanning->id]), [
            'bus_planning_id' => $busPlanning->id,
        ]);

        $user->refresh();

        $this->assertEquals(25, $user->points);
        $this->assertDatabaseHas('bookings', [
            'customer_id' => $user->id,
            'bus_planning_id' => $busPlanning->id,
        ]);
    }

    // Geen punten toevoegen bij een mislukte boeking
    public function test_punten_niet_toegevoegd_bij_ongeldige_boeking()
    {
        $user = Customer::factory()->create(['points' => 0]);
        $this->actingAs($user);

        $festival = Festival::factory()->create();
        $bus = Bus::factory()->create();
        $busPlanning = BusPlanning::factory()->create([
            'festival_id' => $festival->id,
            'bus_id' => $bus->id,
            'available_seats' => 0, // Geen beschikbare stoelen
            'cost_per_seat' => 25,
            'seats_filled' => 50,
        ]);

        $response = $this->post(route('reizen.book', ['busPlanning' => $busPlanning->id]), [
            'bus_planning_id' => $busPlanning->id,
        ]);

        $response->assertSessionHasErrors(['message' => 'Geen beschikbare stoelen meer.']);

        $user->refresh();
        $this->assertEquals(0, $user->points); // Geen punten verdiend
        $this->assertDatabaseMissing('bookings', [
            'customer_id' => $user->id,
            'bus_planning_id' => $busPlanning->id,
        ]);
    }


    // meededere boekingen
    public function test_meerdere_boekingen_tellen_correct_punten_op()
    {
        $user = Customer::factory()->create(['points' => 0]);
        $this->actingAs($user);

        $festival = Festival::factory()->create();
        $bus = Bus::factory()->create();

        $busPlanning1 = BusPlanning::factory()->create([
            'festival_id' => $festival->id,
            'bus_id' => $bus->id,
            'available_seats' => 50,
            'cost_per_seat' => 25,
            'seats_filled' => 0,
        ]);

        $busPlanning2 = BusPlanning::factory()->create([
            'festival_id' => $festival->id,
            'bus_id' => $bus->id,
            'available_seats' => 50,
            'cost_per_seat' => 30,
            'seats_filled' => 0,
        ]);

        // Eerste boeking
        $this->post(route('reizen.book', $busPlanning1->id), [
            'bus_planning_id' => $busPlanning1->id,
        ]);

        // Tweede boeking
        $this->post(route('reizen.book', $busPlanning2->id), [
            'bus_planning_id' => $busPlanning2->id,
        ]);

        $user->refresh();
        $this->assertEquals(55, $user->points); // 25 + 30 = 55 punten
        $this->assertDatabaseHas('bookings', ['bus_planning_id' => $busPlanning1->id]);
        $this->assertDatabaseHas('bookings', ['bus_planning_id' => $busPlanning2->id]);
    }
}
