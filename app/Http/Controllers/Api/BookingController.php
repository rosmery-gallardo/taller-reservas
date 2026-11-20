<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotEnoughSeatsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Workshop;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    public function __construct(private readonly BookingService $bookings) {}

    /**
     * POST /api/workshops/{slug}/bookings
     */
    public function store(StoreBookingRequest $request, Workshop $workshop): JsonResponse
    {
        try {
            $booking = $this->bookings->book($workshop, $request->validated());
        } catch (NotEnoughSeatsException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => ['seats' => [$e->getMessage()]],
            ], 422);
        }

        return (new BookingResource($booking->load('workshop')))
            ->response()
            ->setStatusCode(201);
    }
}
