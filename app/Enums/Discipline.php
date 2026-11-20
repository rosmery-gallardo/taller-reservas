<?php

namespace App\Enums;

enum Discipline: string
{
    case Diseno = 'diseno';
    case Tipografia = 'tipografia';
    case Ceramica = 'ceramica';
    case Fotografia = 'fotografia';
    case Arquitectura = 'arquitectura';

    public function label(): string
    {
        return match ($this) {
            self::Diseno => 'Diseño',
            self::Tipografia => 'Tipografía',
            self::Ceramica => 'Cerámica',
            self::Fotografia => 'Fotografía',
            self::Arquitectura => 'Arquitectura',
        };
    }

    /** Color de la paleta Bauhaus asociado a cada disciplina. */
    public function color(): string
    {
        return match ($this) {
            self::Diseno, self::Arquitectura => 'red',
            self::Tipografia => 'black',
            self::Ceramica => 'yellow',
            self::Fotografia => 'blue',
        };
    }
}
