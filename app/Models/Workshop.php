<?php

namespace App\Models;

use App\Enums\Discipline;
use Database\Factories\WorkshopFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workshop extends Model
{
    /** @use HasFactory<WorkshopFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'discipline',
        'instructor',
        'starts_at',
        'duration_minutes',
        'capacity',
        'price_cents',
    ];

    protected function casts(): array
    {
        return [
            'discipline' => Discipline::class,
            'starts_at' => 'datetime',
            'duration_minutes' => 'integer',
            'capacity' => 'integer',
            'price_cents' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('starts_at', '>=', now())->orderBy('starts_at');
    }

    public function scopeOfDiscipline(Builder $query, ?string $discipline): Builder
    {
        return $discipline ? $query->where('discipline', $discipline) : $query;
    }

    public function seatsTaken(): int
    {
        return (int) $this->bookings()->sum('seats');
    }

    protected function seatsLeft(): Attribute
    {
        return Attribute::get(function () {
            // Si la consulta ya trajo withSum('bookings', 'seats'), evitamos otra consulta (N+1).
            $taken = $this->getAttributes()['bookings_sum_seats'] ?? $this->seatsTaken();

            return max(0, $this->capacity - (int) $taken);
        });
    }

    protected function priceEuros(): Attribute
    {
        return Attribute::get(fn () => number_format($this->price_cents / 100, 2, ',', '.').' €');
    }
}
