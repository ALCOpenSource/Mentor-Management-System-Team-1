<?php

namespace App\Rules;

use App\Models\City;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateCity implements ValidationRule
{
    protected $country_code;
    protected $state_code;

    public function __construct($country_code = null, $state_code = null)
    {
        $this->country_code = $country_code;
        $this->state_code = $state_code;
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        $city = callStatic(City::class, 'where', 'name', $value);

        if ($this->country_code) {
            $city = $city->join('countries', 'countries.id', '=', 'cities.country_id')
                ->where('countries.code', $this->country_code);
        }

        if ($this->state_code) {
            $city = $city->join('states', 'states.id', '=', 'cities.state_id')
                ->where('states.code', $this->state_code);
        }

        if ((! $this->country_code && ! $this->state_code) || ! $city) {
            $fail('The '.$attribute.' is invalid for the selected country.');
        }
    }
}
