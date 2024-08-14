<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerDataCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:15', 'regex:/^\+?[1-9]\d{1,14}$/'],
            'house_number' => ['required', 'string', 'max:30', 'regex:/^[1-9]\d*(?: ?(?:[a-z]|[\/-] ?\d+[a-z]?))?$/'],
            'address_1' => ['required', 'string', 'max:255'],
            'address_2' => ['nullable', 'string', 'max:255'],
            'postcode' => ['required', 'string', 'max:10'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'rating' => ['required', 'string', 'in:Bronze,Silver,Gold,Platinum'],
            'rating_manual' => ['required', 'boolean'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }
}
