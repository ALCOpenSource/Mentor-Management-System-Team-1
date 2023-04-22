<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'currency',
        'currency_symbol',
        'currency_code',
        'capital',
        'region',
        'subregion',
        'phone_code',
        'timezones',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'timezones' => 'array',
    ];

    protected $appends = [
        'flag',
    ];

    /**
     * Flag attribute.
     */
    public function getFlagAttribute(): string
    {
        return asset(sprintf('vendor/blade-flags/country-%s.svg', strtolower($this->code)));
    }

    /**
     * Get the states for the country.
     */
    public function Cities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(City::class);
    }

    /**
     * Get the states for the country.
     */
    public function States(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(State::class);
    }
}
