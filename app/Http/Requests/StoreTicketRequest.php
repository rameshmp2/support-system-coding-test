<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // public endpoint
    }

    public function rules(): array
    {
        return [
            'customer_name'       => ['required', 'string', 'min:2', 'max:120'],
            'email'               => ['required', 'email:rfc,dns', 'max:191'],
            'phone'               => ['required', 'string', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'ticket_description'  => ['required', 'string', 'min:10', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Please enter a valid phone number.',
            'ticket_description.min' => 'Please describe your problem in at least 10 characters.',
        ];
    }
}
