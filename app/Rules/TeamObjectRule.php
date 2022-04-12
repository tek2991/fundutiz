<?php

namespace App\Rules;

use App\Models\Team;
use Illuminate\Contracts\Validation\Rule;

class TeamObjectRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $result = true;

        foreach ($value as $team => $status) {
            $result = Team::where('id', $team)->exists() && gettype($status) === 'boolean' ? true : false;
            if ($result === false) {
                break;
            }
        }

        return $result;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Error validating Team Object.';
    }
}
