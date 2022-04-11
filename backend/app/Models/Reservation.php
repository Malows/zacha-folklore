<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'uuid',
        'qr_path',
        'qr_url',
        'email',
        'phone',
        'is_paid',
        'is_used',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_paid' => 'boolean',
        'is_used' => 'boolean',
    ];

    /**
     * Scope a query to only include unused reservations.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return void
     */
    public function scopeUnused(Builder $query)
    {
        $query->where('is_used', false);
    }
}
