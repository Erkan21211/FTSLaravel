<?php

namespace Tests\old_tests;

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
    public function test_gebruiker_kan_punten_inwisselen_voor_een_boeking()
    {
        // Arrange: Maak een gebruiker met voldoende punten aan
        $user = Customer::factory()->create(['points' => 100]);
        $this->actingAs($user);

        // Arrange: Maak een festival, bus, en busplanning aan
        $festival = Festival::factory()->create();
        $bus = Bus::factory()->create();
        $busPlanning = BusPlanning::factory()->create([
            'available_seats' => 10, // Stel beschikbare stoelen in
            'seats_filled' => 0,    // Geen stoelen gevuld
            'cost_per_seat' => 50,  // Kosten per stoel
        ]);

        dd($busPlanning->toArray());

        // Act: Voer de POST-aanroep uit om punten in te wisselen
        $response = $this->post(route('reizen.redeem', $busPlanning->id), [
            'bus_planning_id' => $busPlanning->id,
        ]);

        // Assert: Controleer de redirect en success-bericht
        $response->assertRedirect(route('bookings.index'));
        $response->assertSessionHas('success', "Je hebt 50 punten ingewisseld voor deze boeking!");

        // Fetch de meest recente BusPlanning data
        $updatedBusPlanning = BusPlanning::find($busPlanning->id);

        // Debug: Controleer de waarde na de POST-aanroep
        $this->assertEquals(1, $updatedBusPlanning->seats_filled, 'Seats filled was not incremented.');
        $this->assertEquals(10, $updatedBusPlanning->available_seats, 'Available seats should not change.');

        // Assert: Controleer of de boeking in de database is aangemaakt
        $this->assertDatabaseHas('bookings', [
            'customer_id' => $user->id,
            'bus_planning_id' => $busPlanning->id,
            'status' => 'actief',
        ]);

        // Debug: Controleer de punten van de gebruiker
        $user->refresh();
        $this->assertEquals(50, $user->points, 'User points were not deducted correctly.');
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
