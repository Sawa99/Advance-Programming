<?php

namespace App\Rules;

use Closure;
use App\Models\Assignment;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ValidMark implements ValidationRule
{
    public function __construct(private Assignment $assignment)
    {}
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_numeric($value) || $value < 0 || $value > $this->assignment->total_marks) {
            $fail('The mark must be between 0 and ' . $this->assignment->total_marks . '.');
        }
    }
}
