<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Festival;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function een_gebruiker_kan_het_dashboard_bekijken()
    {
        $user = Customer::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSeeText('Dashboard van ' . $user->first_name);
        $response->assertSeeText('Mijn Boekingen');
        $response->assertSeeText('Nu boeken');
        $response->assertSeeText('Zoek');
    }

    /** @test */
    public function een_gebruiker_kan_zoeken_naar_reizen_via_het_dashboard()
    {
        $user = Customer::factory()->create();
        $festival1 = Festival::factory()->create(['name' => 'Rock Festival']);
        $festival2 = Festival::factory()->create(['name' => 'Jazz Festival']);

        $response = $this->actingAs($user)->get(route('dashboard', ['query' => 'Rock']));

        $response->assertStatus(200);
        $response->assertSeeText('Rock Festival');
        $response->assertDontSeeText('Jazz Festival');
    }

    /** @test */
    public function het_dashboard_toont_knoppen_voor_boekingen_en_reizen()
    {
        $user = Customer::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Mijn Boekingen');
        $response->assertSee('Nu boeken');
        $response->assertSee(route('bookings.index'));
        $response->assertSee(route('reizen.index'));
    }
}
