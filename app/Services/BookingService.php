<?php

namespace App\Services;

use App\Exceptions\NotEnoughSeatsException;
use App\Models\Booking;
use App\Models\Workshop;
use Illuminate\Support\Facades\DB;

/**
 * Lógica de negocio de las reservas, separada de los controladores
 * para reutilizarla desde la web y desde la API.
 */
class BookingService
{
    /**
     * Crea una reserva comprobando las plazas libres dentro de una transacción,
     * para que dos reservas simultáneas no superen el aforo.
     *
     * @param  array{name: string, email: string, seats: int}  $data
     *
     * @throws NotEnoughSeatsException
     */
    public function book(Workshop $workshop, array $data): Booking
    {
        return DB::transaction(function () use ($workshop, $data) {
            $locked = Workshop::query()->lockForUpdate()->findOrFail($workshop->id);
            $seatsLeft = $locked->capacity - $locked->seatsTaken();

            if ($data['seats'] > $seatsLeft) {
                throw new NotEnoughSeatsException(max(0, $seatsLeft));
            }

            return $locked->bookings()->create($data);
        });
    }
}
