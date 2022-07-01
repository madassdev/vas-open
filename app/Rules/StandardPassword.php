<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class StandardPassword implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        //
        if (preg_match("/(?=.*\d{4,})(?!.*border\d{4,};)/", $value)) {
            $fail('The :attribute must be not contain sequences of more than 4 digits in a row. eg: (1234),(5678)');
        }
    }
}
