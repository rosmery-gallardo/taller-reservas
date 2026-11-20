<?php

namespace Tests\Feature\Api;

use App\Models\Booking;
use App\Models\Workshop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_booking(): void
    {
        $workshop = Workshop::factory()->create(['capacity' => 5]);

        $this->postJson("/api/workshops/{$workshop->slug}/bookings", [
            'name' => 'Ana Gil',
            'email' => 'ana@example.com',
            'seats' => 2,
        ])
            ->assertCreated()
            ->assertJsonPath('data.seats', 2)
            ->assertJsonPath('data.workshop', $workshop->slug);

        $this->assertSame(3, $workshop->fresh()->seats_left);
    }

    public function test_it_rejects_bookings_over_capacity(): void
    {
        $workshop = Workshop::factory()->create(['capacity' => 4]);
        Booking::factory()->for($workshop)->create(['seats' => 3]);

        $this->postJson("/api/workshops/{$workshop->slug}/bookings", [
            'name' => 'Ana Gil',
            'email' => 'ana@example.com',
            'seats' => 2,
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('seats');

        $this->assertDatabaseCount('bookings', 1);
    }

    public function test_it_validates_the_input(): void
    {
        $workshop = Workshop::factory()->create();

        $this->postJson("/api/workshops/{$workshop->slug}/bookings", [
            'name' => '',
            'email' => 'no-es-un-correo',
            'seats' => 9,
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'seats']);
    }
}
