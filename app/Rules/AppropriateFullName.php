<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AppropriateFullName implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // List of inappropriate words to check against
        $inappropriateWords = [
            'sex', 'sexy', 'nude', 'naked', 'porn', 'xxx',
            'adult', 'obscene', 'offensive', 'explicit',
            'violent', 'vulgar', 'profane', 'inappropriate',
            // Add more inappropriate words as needed
        ];

        $lowercaseValue = strtolower($value);

        foreach ($inappropriateWords as $word) {
            if (str_contains($lowercaseValue, $word)) {
                $fail('The :attribute contains inappropriate content.');
                return;
            }
        }
    }
}
