<?php

namespace App\Http\Controllers;

use App\Enums\Discipline;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkshopController extends Controller
{
    public function index(Request $request): View
    {
        $discipline = $request->string('disciplina')->toString() ?: null;

        $workshops = Workshop::query()
            ->upcoming()
            ->ofDiscipline($discipline)
            ->withSum('bookings', 'seats')
            ->get();

        return view('workshops.index', [
            'workshops' => $workshops,
            'disciplines' => Discipline::cases(),
            'active' => $discipline,
        ]);
    }

    public function show(Workshop $workshop): View
    {
        return view('workshops.show', ['workshop' => $workshop]);
    }
}
