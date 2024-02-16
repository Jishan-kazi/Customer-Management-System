<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
            'name' => "required|regex:/^[0-9A-Za-z.\s,'-]*$/|max:50",
            'email' => "required|email|max:50",
            'address' => "required|regex:/^[0-9A-Za-z.\s,'-]*$/",
            'phone' => ['required', 'numeric', Rule::unique('customers', 'phone')->ignore($this->route('customerId'))],

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name cannot be empty',
            'name.regex' => 'Only letters, numbers, spaces, dash & underscore is allowed',
            'name.max' => 'Maximum 50 characters allowed',

            'email.required' => 'Email cannot be empty',
            'email.email' => 'Invalid email',
            'email.max' => 'Maximum 50 characters allowed',
            
            'address.required' => 'Address cannot be empty',
            'address.regex' => 'Only letters, numbers, spaces, dash & underscore is allowed',

            'phone.required' => 'Phone cannot be empty',
            'phone.numeric' => 'Only numbers allowed'
        ];
    }
}
