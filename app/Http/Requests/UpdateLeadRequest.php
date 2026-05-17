<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Se conecta directamente con el LeadPolicy @update
        return $this->user()->can('update', $this->route('lead'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'estimated_value' => 'nullable|numeric|min:0',
            'source' => 'nullable|string|max:255',
            'next_follow_up' => 'nullable|date',
            'notes' => 'nullable|string',
        ];
    }
}
