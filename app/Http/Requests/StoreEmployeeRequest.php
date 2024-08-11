<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'image' => 'required|string|max:100',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'division' => 'required|uuid|exists:divisions,id',
            'position' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => 'Image is required.',
            'name.required' => 'Name is required.',
            'phone.required' => 'Phone number is required.',
            'division.required' => 'Division is required.',
            'division.uuid' => 'Division must be a valid UUID.',
            'division.exists' => 'Division does not exist.',
            'position.required' => 'Position is required.',
        ];
    }

}
