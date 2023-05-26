<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MinWordsRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private int $min_words = 1)
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
        return str_word_count($value) >= $this->min_words;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $word = $this->min_words == 1 ? 'word' : 'words';

        return 'The :attribute cannot be less than '.$this->min_words." $word.";
    }
}
