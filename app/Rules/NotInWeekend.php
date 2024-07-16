<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class NotInWeekend implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $date = Carbon::parse($value);

        if ($date->dayOfWeek == 6 || $date->dayOfWeek == 0) {
            $fail('A data não pode ser em um final de semana.');
        }
    }
}
