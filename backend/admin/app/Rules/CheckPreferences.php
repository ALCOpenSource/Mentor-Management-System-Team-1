<?php

namespace App\Rules;

use App\Helpers\AppConstants;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckPreferences implements ValidationRule
{
    protected function checkPreferences(mixed $preferences, mixed $value, \Closure $fail): void
    {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                if (! isset($preferences[$k])) {
                    $fail('Invalid preference key');

                    return;
                }

                if (is_array($preferences[$k]) && is_array($v) && ! array_intersect_assoc($preferences[$k], $v)) {
                    $fail("Invalid preference value: [$k], accepted values: [".implode(', ', $preferences[$k]).']');

                    return;
                }

                if (gettype($preferences[$k]) !== gettype($v)) {
                    $fail("Invalid preference value: [$k], accepted values: [".implode(', ', $preferences[$k]).']');

                    return;
                }
            }
        }

        // If the preferences is a boolean, then we don't need to check the value
        if (is_bool($preferences) && is_bool($value)) {
            return;
        }

        // Assume that the preference type need to match the value type
        if (gettype($preferences) !== gettype($value)) {
            $fail('Invalid preference value');

            return;
        }
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        // Get the preference key
        $preference_key = explode('.', $attribute)[1] ?? null;

        if (is_null($preference_key) || ! isset(AppConstants::PREFERENCES[$preference_key])) {
            $fail('Invalid preference key');

            return;
        }

        $preferences = AppConstants::PREFERENCES[$preference_key];

        // Recursively check the preferences
        $this->checkPreferences($preferences, $value, $fail);
    }
}
