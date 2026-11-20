<?php

namespace Database\Seeders;

use App\Models\Workshop;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $workshops = [
            ['Color y forma: el círculo, el cuadrado y el triángulo', 'diseno', 'Marta Puig', 7, 120, 12, 3500,
                'Exploramos la relación entre forma y color de los ejercicios del curso preliminar de la Bauhaus y diseñamos una composición propia.'],
            ['Tipografía geométrica con retícula', 'tipografia', 'Jordi Ferrer', 10, 180, 10, 4500,
                'Construimos un alfabeto con regla, compás y una retícula modular, y lo llevamos a un cartel.'],
            ['Cerámica funcional: piezas para el día a día', 'ceramica', 'Laia Soler', 14, 180, 8, 4500,
                'Modelado de piezas sencillas y útiles, sin ornamento, siguiendo el principio de que la forma sigue a la función.'],
            ['Fotografía de la Nueva Visión', 'fotografia', 'Pau Roig', 18, 120, 12, 3500,
                'Picados, contrapicados y sombras duras: fotografiamos la ciudad como lo hacían Moholy-Nagy y sus alumnos.'],
            ['Arquitectura y espacio mínimo', 'arquitectura', 'Núria Vidal', 25, 90, 15, 2500,
                'Analizamos viviendas mínimas y diseñamos en maqueta un espacio de 25 m² funcional y luminoso.'],
            ['Cartel constructivista', 'diseno', 'Marta Puig', 32, 120, 12, 3500,
                'Diagonales, bloques de color y tipografía en negrita para diseñar un cartel con mensaje.'],
        ];

        foreach ($workshops as [$title, $discipline, $instructor, $inDays, $duration, $capacity, $price, $description]) {
            Workshop::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'description' => $description,
                'discipline' => $discipline,
                'instructor' => $instructor,
                'starts_at' => now()->addDays($inDays)->setTime(18, 30),
                'duration_minutes' => $duration,
                'capacity' => $capacity,
                'price_cents' => $price,
            ]);
        }
    }
}
