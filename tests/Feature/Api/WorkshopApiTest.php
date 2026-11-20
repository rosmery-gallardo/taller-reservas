<?php

namespace Tests\Feature\Api;

use App\Models\Workshop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorkshopApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_upcoming_workshops(): void
    {
        Workshop::factory()->count(3)->create();
        Workshop::factory()->past()->create();

        $this->getJson('/api/workshops')
            ->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [['id', 'slug', 'title', 'discipline' => ['value', 'label', 'color'], 'starts_at', 'seats_left']],
            ]);
    }

    public function test_it_filters_by_discipline(): void
    {
        Workshop::factory()->create(['discipline' => 'tipografia']);
        Workshop::factory()->create(['discipline' => 'ceramica']);

        $this->getJson('/api/workshops?discipline=tipografia')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.discipline.value', 'tipografia');
    }

    public function test_it_shows_a_workshop_by_slug(): void
    {
        $workshop = Workshop::factory()->create();

        $this->getJson("/api/workshops/{$workshop->slug}")
            ->assertOk()
            ->assertJsonPath('data.slug', $workshop->slug);
    }

    public function test_unknown_workshop_returns_404(): void
    {
        $this->getJson('/api/workshops/no-existe')->assertNotFound();
    }
}
