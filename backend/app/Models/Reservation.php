<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'last_name',
        'amount',
        'uuid',
        'email',
        'phone',
        'is_paid',
        'is_used',
        'event_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['qr_path', 'qr_url'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_paid' => 'boolean',
        'is_used' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the QR disk path.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function qrPath(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['uuid'].'.png',
        );
    }

    /**
     * Get the QR HTTP URL.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function qrUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => url('/storage/reservations/'.$attributes['uuid'].'.png'),
        );
    }
}
