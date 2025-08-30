<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title'   => 'required|string|max:255',
            'content' => 'required|string|min:10',
        ];
    }

     public function messages(): array
    {
        return [
            'title.required'   => 'Please enter the post title.',
            'title.max'        => 'The title may not be greater than 255 characters.',
            'content.required' => 'Please enter the post content.',
            'content.min'      => 'The content must be at least 10 characters.',
        ];
    }
}
