<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorkshopResource;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class WorkshopController extends Controller
{
    /**
     * GET /api/workshops?discipline=tipografia
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $workshops = Workshop::query()
            ->upcoming()
            ->ofDiscipline($request->string('discipline')->toString() ?: null)
            ->withSum('bookings', 'seats')
            ->get();

        return WorkshopResource::collection($workshops);
    }

    /**
     * GET /api/workshops/{slug}
     */
    public function show(Workshop $workshop): WorkshopResource
    {
        return new WorkshopResource($workshop);
    }
}
