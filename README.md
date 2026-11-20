# Taller Reservas · Escuela Forma

Aplicación en **Laravel** para consultar y reservar talleres de una escuela de diseño ficticia. Tiene dos partes:

- **Web MVC** con Blade y Sass, con un diseño inspirado en la Bauhaus (formas geométricas, colores primarios y tipografía geométrica).
- **API REST** en JSON, que usa el front en Angular [taller-reservas-web](https://github.com/rosmery-gallardo/taller-reservas-web).

## Qué demuestra

- Arquitectura **MVC**: modelos Eloquent, controladores finos y vistas Blade.
- **Capa de servicio** (`BookingService`) con la lógica de negocio compartida entre la web y la API.
- Control de aforo dentro de una **transacción** con bloqueo de fila, para que dos reservas simultáneas no superen las plazas.
- Validación con **Form Requests** y mensajes en español.
- **API Resources** para dar forma a las respuestas JSON, filtros por query string y limitación de peticiones (`throttle`).
- **Enum** de PHP para las disciplinas, con su etiqueta y su color.
- Consulta con `withSum` para evitar el problema N+1 al calcular las plazas libres.
- **Tests de funcionalidad** con PHPUnit para la web y la API.
- **Sass** organizado en parciales (variables, base, layout, componentes) y compilado con Vite.

## Endpoints de la API

| Método | Ruta | Descripción |
| --- | --- | --- |
| `GET` | `/api/workshops` | Talleres próximos. Filtro opcional `?discipline=tipografia` |
| `GET` | `/api/workshops/{slug}` | Detalle de un taller |
| `POST` | `/api/workshops/{slug}/bookings` | Crea una reserva (`name`, `email`, `seats`) |

Ejemplo de respuesta de `GET /api/workshops`:

```json
{
  "data": [
    {
      "id": 1,
      "slug": "tipografia-geometrica-con-reticula",
      "title": "Tipografía geométrica con retícula",
      "discipline": { "value": "tipografia", "label": "Tipografía", "color": "black" },
      "instructor": "Jordi Ferrer",
      "starts_at": "2026-12-01T18:30:00+00:00",
      "duration_minutes": 180,
      "capacity": 10,
      "seats_left": 10,
      "price_cents": 4500
    }
  ]
}
```

Si no quedan plazas suficientes, la API responde `422` con el error en el campo `seats`.

## Estructura principal

```
app/
├── Enums/Discipline.php
├── Exceptions/NotEnoughSeatsException.php
├── Http/
│   ├── Controllers/            # Web: WorkshopController, BookingController
│   │   └── Api/                # API: WorkshopController, BookingController
│   ├── Requests/StoreBookingRequest.php
│   └── Resources/              # WorkshopResource, BookingResource
├── Models/                     # Workshop, Booking
└── Services/BookingService.php
resources/
├── sass/                       # _variables, _base, _layout, _components
└── views/                      # layouts/app, workshops/index, workshops/show
tests/Feature/                  # tests de la web y de la API
```

## Puesta en marcha

Requisitos: PHP 8.3, Composer y Node.js.

```bash
git clone https://github.com/rosmery-gallardo/taller-reservas.git
cd taller-reservas
composer run setup   # instala dependencias, crea la base de datos SQLite, migra y carga datos de ejemplo
php artisan serve
```

Abre http://localhost:8000.

## Tests

```bash
php artisan test
```

## Tecnologías

PHP 8.3 · Laravel 13 · Eloquent · Blade · Sass · Vite · SQLite · PHPUnit
