<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateFavoriteRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'author' => ['required', 'string'],
            'description' => ['nullable','string'],
            'release_year' => ['nullable', 'numeric'],
            'type' => ['required', 'string', Rule::in(['movie', 'book'])],
            'tags' => ['required', 'array'],
            'tags.*' => ['string'],
        ];
    }
}
