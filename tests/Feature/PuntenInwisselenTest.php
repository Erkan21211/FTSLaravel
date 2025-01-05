<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Bus;
use App\Models\BusPlanning;
use App\Models\Customer;
use App\Models\Festival;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PuntenInwisselenTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function gebruiker_kan_punten_inwisselen_voor_een_boeking()
    {
        $user = Customer::factory()->create(['points' => 100]);
        $this->actingAs($user);

        $festival = Festival::factory()->create();
        $bus = Bus::factory()->create();
        $busPlanning = BusPlanning::factory()->create([
            'festival_id' => $festival->id,
            'bus_id' => $bus->id,
            'available_seats' => 10,
            'cost_per_seat' => 50,
            'seats_filled' => 0,
        ]);

        $response = $this->post(route('reizen.redeem', $busPlanning->id), [
            'bus_planning_id' => $busPlanning->id,
        ]);

        $response->assertRedirect(route('bookings.index'));
        $response->assertSessionHas('success', "Je hebt 50.00 punten ingewisseld voor deze boeking!");

        $this->assertDatabaseHas('bookings', [
            'customer_id' => $user->id,
            'bus_planning_id' => $busPlanning->id,
            'status' => 'actief',
        ]);

        $user->refresh();
        $this->assertEquals(50, $user->points);
    }

    /** @test */
    public function gebruiker_kan_geen_punten_inwisselen_met_onvoldoende_saldo()
    {
        $user = Customer::factory()->create(['points' => 30]);
        $this->actingAs($user);

        $festival = Festival::factory()->create();
        $bus = Bus::factory()->create();
        $busPlanning = BusPlanning::factory()->create([
            'festival_id' => $festival->id,
            'bus_id' => $bus->id,
            'available_seats' => 10,
            'cost_per_seat' => 50,
            'seats_filled' => 0,
        ]);

        $response = $this->post(route('reizen.redeem', $busPlanning->id), [
            'bus_planning_id' => $busPlanning->id,
        ]);

        $response->assertRedirect(route('reizen.show', $busPlanning->id));
        $response->assertSessionHasErrors(['message' => 'Onvoldoende punten om deze boeking te maken.']);

        $this->assertDatabaseMissing('bookings', [
            'customer_id' => $user->id,
            'bus_planning_id' => $busPlanning->id,
        ]);

        $user->refresh();
        $this->assertEquals(30, $user->points);
    }

    /** @test */
    public function punten_saldo_wordt_correct_bijgewerkt_na_inwisselen()
    {
        $user = Customer::factory()->create(['points' => 75]);
        $this->actingAs($user);

        $festival = Festival::factory()->create();
        $bus = Bus::factory()->create();
        $busPlanning = BusPlanning::factory()->create([
            'festival_id' => $festival->id,
            'bus_id' => $bus->id,
            'available_seats' => 10,
            'cost_per_seat' => 75,
            'seats_filled' => 0,
        ]);

        $this->post(route('reizen.redeem', $busPlanning->id), [
            'bus_planning_id' => $busPlanning->id,
        ]);

        $user->refresh();
        $this->assertEquals(0, $user->points);
    }

    /** @test */
    public function gebruiker_kan_geen_boeking_doen_als_er_geen_stoelen_beschikbaar_zijn()
    {
        $user = Customer::factory()->create(['points' => 100]);
        $this->actingAs($user);

        $festival = Festival::factory()->create();
        $bus = Bus::factory()->create();
        $busPlanning = BusPlanning::factory()->create([
            'festival_id' => $festival->id,
            'bus_id' => $bus->id,
            'available_seats' => 10,
            'seats_filled' => 10, // Geen stoelen beschikbaar
            'cost_per_seat' => 50,
        ]);

        $response = $this->post(route('reizen.redeem', $busPlanning->id), [
            'bus_planning_id' => $busPlanning->id,
        ]);

        $response->assertRedirect(route('reizen.show', $busPlanning->id));
        $response->assertSessionHasErrors(['message' => 'Geen beschikbare stoelen meer.']);

        $this->assertDatabaseMissing('bookings', [
            'customer_id' => $user->id,
            'bus_planning_id' => $busPlanning->id,
        ]);

        $user->refresh();
        $this->assertEquals(100, $user->points); // Punten blijven gelijk
    }
}
