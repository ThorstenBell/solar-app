<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnergyUsageRequest extends FormRequest
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
            'installation_id' => 'required|exists:installations,id',
            'energy_produced' => 'required|numeric|min:0',
            'energy_consumed' => 'required|numeric|min:0',
            'date' => 'required|date',
        ];
    }
}
