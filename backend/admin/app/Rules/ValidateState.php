<?php

namespace App\Rules;

use App\Models\State;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateState implements ValidationRule
{
    protected $country_code;

    public function __construct($country_code)
    {
        $this->country_code = $country_code;
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        $state = callStatic(State::class, 'where', 'code', $value)
            ->join('countries', 'countries.id', '=', 'states.country_id')
            ->where('countries.code', $this->country_code);

        if (! $state) {
            $fail('The '.$attribute.' is invalid for the selected country.');
        }
    }
}
