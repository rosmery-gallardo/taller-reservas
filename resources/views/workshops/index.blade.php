@extends('layouts.app')

@section('title', 'Talleres')

@section('content')
    <section class="hero">
        <div class="hero__text">
            <h1>La forma sigue a la función</h1>
            <p>Talleres prácticos de diseño, tipografía, cerámica, fotografía y arquitectura. Plazas limitadas.</p>
        </div>
        <div class="hero__art" aria-hidden="true"></div>
    </section>

    <div class="container">
        <nav class="filters" aria-label="Filtrar por disciplina">
            <a href="{{ route('workshops.index') }}" @class(['chip', 'is-active' => ! $active])>Todos</a>
            @foreach ($disciplines as $discipline)
                <a href="{{ route('workshops.index', ['disciplina' => $discipline->value]) }}"
                   @class(['chip', 'is-active' => $active === $discipline->value])>
                    {{ $discipline->label() }}
                </a>
            @endforeach
        </nav>

        @if ($workshops->isEmpty())
            <p class="empty">No hay talleres programados para esta disciplina.</p>
        @else
            <div class="grid">
                @foreach ($workshops as $workshop)
                    <a href="{{ route('workshops.show', $workshop) }}" class="card">
                        <div class="card__band bg-{{ $workshop->discipline->color() }}"></div>
                        <div class="card__body">
                            <span class="tag-{{ $workshop->discipline->color() }}">{{ $workshop->discipline->label() }}</span>
                            <h2>{{ $workshop->title }}</h2>
                            <p>{{ $workshop->starts_at->translatedFormat('d/m/Y · H:i') }} · {{ $workshop->instructor }}</p>
                        </div>
                        <div class="card__meta">
                            <span>{{ $workshop->price_euros }}</span>
                            <span>{{ $workshop->seats_left > 0 ? $workshop->seats_left.' plazas' : 'Completo' }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
