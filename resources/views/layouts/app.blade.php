<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Talleres') · Escuela Forma</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=jost:400,500,700" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <header class="site-header">
        <div class="container">
            <a href="{{ route('workshops.index') }}" class="logo">
                <span class="shapes" aria-hidden="true">
                    <span class="circle"></span>
                    <span class="square"></span>
                    <span class="triangle"></span>
                </span>
                Escuela Forma
            </a>
            <nav><a href="{{ route('workshops.index') }}">Talleres</a></nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container">
            Proyecto de portfolio · Laravel, PHP, MVC y Sass · Inspirado en la Bauhaus
        </div>
    </footer>
</body>
</html>
