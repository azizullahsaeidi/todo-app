<?php

namespace App\Http\Requests;

use App\Rules\MaxWordsRule;
use App\Rules\MinWordsRule;
use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
{
    return [
        // The `todo_type_id` field is required, must be numeric, and must exist in the `todo_types` table.
        'todo_type_id' => ['required', 'numeric', 'exists:todo_types,id'],

        // The `title` field is required, must be a string, and must have between 1 and 20 words.
        'title' => ['required', 'string', new MinWordsRule(1), new MaxWordsRule(20)],

        // The `description` field is required, must be a string, and must have between 5 and 1000 words.
        'description' => ['required', 'string', new MinWordsRule(5), new MaxWordsRule(1000)],

        // The `date` field is required and must be a valid date.
        'date' => ['required', 'date'],
    ];
}
}
