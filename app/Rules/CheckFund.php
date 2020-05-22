<?php

namespace App\Rules;

use App\Coin;
use Illuminate\Contracts\Validation\Rule;

class CheckFund implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = auth()->user();
        $amount = $user->getBalance(strtoupper($parameters[0]));
        return $value <= $amount;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your wallet doesn\'t have sufficient fund';
    }
}
