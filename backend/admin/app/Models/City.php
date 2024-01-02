<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country_id',
        'state_id',
    ];

    protected $hidden = [
        'country_id',
        'state_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the country that owns the city.
     */
    public function Country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the state that owns the city.
     */
    public function State(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(State::class);
    }
}
