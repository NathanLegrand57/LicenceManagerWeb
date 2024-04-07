<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class LicenceRequest extends FormRequest
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
            'libelle' => 'required|string|max:75',
            'duree' => 'required|integer|max:366',
            'prix' => 'required|numeric|max:400',
        ];
    }
}
