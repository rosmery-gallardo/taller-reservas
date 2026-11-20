<?php

namespace Tests\Unit;

use App\Enums\Discipline;
use PHPUnit\Framework\TestCase;

class DisciplineTest extends TestCase
{
    public function test_every_discipline_has_a_label_and_a_bauhaus_color(): void
    {
        foreach (Discipline::cases() as $discipline) {
            $this->assertNotEmpty($discipline->label());
            $this->assertContains($discipline->color(), ['red', 'blue', 'yellow', 'black']);
        }
    }

    public function test_it_is_built_from_the_database_value(): void
    {
        $this->assertSame('Tipografía', Discipline::from('tipografia')->label());
    }
}
