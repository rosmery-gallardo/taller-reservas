<?php

namespace App\Http\Controllers;

use App\Exceptions\NotEnoughSeatsException;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Workshop;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;

class BookingController extends Controller
{
    public function __construct(private readonly BookingService $bookings) {}

    public function store(StoreBookingRequest $request, Workshop $workshop): RedirectResponse
    {
        try {
            $this->bookings->book($workshop, $request->validated());
        } catch (NotEnoughSeatsException $e) {
            return back()->withInput()->withErrors(['seats' => $e->getMessage()]);
        }

        return redirect()
            ->route('workshops.show', $workshop)
            ->with('status', '¡Reserva confirmada! Te esperamos en el taller.');
    }
}
