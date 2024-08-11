<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            'image' => 'sometimes|string|max:100',
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20',
            'position' => 'sometimes|string|max:255',
            'division' => 'sometimes|uuid|exists:divisions,id'
        ];
    }

    public function messages():array {
        return [
            'image.string' => 'Gambar harus berupa string.',
            'name.string' => 'Nama harus berupa string.',
            'phone.string' => 'Nomor telepon harus berupa string.',
            'position.string' => 'Posisi harus berupa string.',
            'division.uuid' => 'Divisi harus berupa UUID yang valid.',
            'division.exists' => 'Divisi tidak ditemukan.'
        ];
    }
}
