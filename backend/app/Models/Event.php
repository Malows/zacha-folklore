<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'location',
        'event_day',
        'started_at',
        'is_active',
        'reserved_tickets',
        'pre_paid_reserved_tickets',
        'common_tickets',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'event_day' => 'date',
        'started_at' => 'datetime',
        'is_active' => 'boolean',
        'location' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menuSections()
    {
        return $this->hasMany(MenuSection::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function menuItems()
    {
        return $this->hasManyThrough(MenuItem::class, MenuSection::class);
    }

    /**
     * Scope a query to only include unused reservations.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeActive(Builder $query)
    {
        $now = Carbon::now();

        $query
            ->where('is_active', true)
            ->whereDate('event_day', '>=', $now);
    }

    /**
     * Scope a query to only include unused reservations.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeNextEvent(Builder $query)
    {
        $now = Carbon::now();

        $query
            ->whereDate('event_day', '>', $now);
    }
}
