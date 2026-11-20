@extends('layouts.app')

@section('title', $workshop->title)

@section('content')
    <div class="container">
        @if (session('status'))
            <p class="alert alert--success" role="status">{{ session('status') }}</p>
        @endif

        <div class="detail">
            <article>
                <span class="tag-{{ $workshop->discipline->color() }}">{{ $workshop->discipline->label() }}</span>
                <h1>{{ $workshop->title }}</h1>
                <p>{{ $workshop->description }}</p>

                <dl class="facts">
                    <div><dt>Fecha</dt><dd>{{ $workshop->starts_at->format('d/m/Y H:i') }}</dd></div>
                    <div><dt>Duración</dt><dd>{{ $workshop->duration_minutes }} min</dd></div>
                    <div><dt>Profesor/a</dt><dd>{{ $workshop->instructor }}</dd></div>
                    <div><dt>Precio</dt><dd>{{ $workshop->price_euros }}</dd></div>
                </dl>
            </article>

            <form method="POST" action="{{ route('bookings.store', $workshop) }}" class="form">
                @csrf
                <h2>Reservar plaza</h2>
                <p>Quedan <strong>{{ $workshop->seats_left }}</strong> de {{ $workshop->capacity }} plazas.</p>

                <label for="name">Nombre</label>
                <input id="name" name="name" value="{{ old('name') }}" required>
                @error('name') <p class="error">{{ $message }}</p> @enderror

                <label for="email">Correo electrónico</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                @error('email') <p class="error">{{ $message }}</p> @enderror

                <label for="seats">Plazas</label>
                <input id="seats" name="seats" type="number" min="1" max="4" value="{{ old('seats', 1) }}" required>
                @error('seats') <p class="error">{{ $message }}</p> @enderror

                <button type="submit" class="button" @disabled($workshop->seats_left === 0)>
                    {{ $workshop->seats_left === 0 ? 'Completo' : 'Confirmar reserva' }}
                </button>
            </form>
        </div>
    </div>
@endsection
