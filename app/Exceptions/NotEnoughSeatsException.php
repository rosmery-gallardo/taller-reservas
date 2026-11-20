<?php

namespace App\Exceptions;

use RuntimeException;

class NotEnoughSeatsException extends RuntimeException
{
    public function __construct(public readonly int $seatsLeft)
    {
        parent::__construct(
            $seatsLeft === 0
                ? 'El taller está completo.'
                : "Solo quedan {$seatsLeft} plazas disponibles."
        );
    }
}
