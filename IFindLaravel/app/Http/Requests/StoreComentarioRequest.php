<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreComentarioRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'users_id'  => ['required', 'exists:users,id'],
            'post_id'   => ['required', 'exists:post,id'],
            'name_user' => ['required', 'string', 'max:100'],
            'texto'     => ['nullable', 'string'],
        ];
    }
}
