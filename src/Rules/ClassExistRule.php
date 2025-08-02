<?php

namespace JobMetric\EventSystem\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ClassExistRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!class_exists($value)) {
            $fail(trans('event-system::base.validation.class_exist', [
                'class' => $value
            ]));
        }
    }
}
