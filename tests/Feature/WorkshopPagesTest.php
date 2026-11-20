<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Workshop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorkshopPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_lists_upcoming_workshops_only(): void
    {
        $upcoming = Workshop::factory()->create();
        $past = Workshop::factory()->past()->create();

        $this->withoutVite()
            ->get('/')
            ->assertOk()
            ->assertSee($upcoming->title)
            ->assertDontSee($past->title);
    }

    public function test_workshop_detail_page_shows_seats_left(): void
    {
        $workshop = Workshop::factory()->create(['capacity' => 10]);
        Booking::factory()->for($workshop)->create(['seats' => 3]);

        $this->withoutVite()
            ->get(route('workshops.show', $workshop))
            ->assertOk()
            ->assertSee('Quedan <strong>7</strong>', false);
    }

    public function test_booking_form_creates_a_booking_and_redirects(): void
    {
        $workshop = Workshop::factory()->create();

        $this->post(route('bookings.store', $workshop), [
                'name' => 'Ana Gil',
                'email' => 'ana@example.com',
                'seats' => 2,
            ])
            ->assertRedirect(route('workshops.show', $workshop))
            ->assertSessionHas('status');

        $this->assertDatabaseHas('bookings', ['email' => 'ana@example.com', 'seats' => 2]);
    }
}
