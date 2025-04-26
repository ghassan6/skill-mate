<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role == 'admin';
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'bio' => $this->bio ?: null,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:255', 'min:5'],
            'first_name' => ['required', 'string' , 'max:30'],
            'last_name' => ['required', 'string' , 'max:30'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class),
                    ],

                'password' => ['required', 'confirmed', 'min:8', 'string'],

                'phone' => ['required',
                    Rule::unique(User::class, 'phone_number'),
                    'string',
                    'min:10',
                    'max:10',
                    'regex:/^(078|079|077)\d{7}$/',
                    ],

                'city_id' => ['required', 'exists:cities,id'],
                'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
                'bio' => ['nullable' , 'string', 'max:500' , 'min:10'],
                'listing_limit' => ['required', 'min:0']
        ];
    }


    public function messages()
    {
        return [
            'phone.regex' => 'The phone number must start with 078, 079, or 077 and be exactly 10 digits long.',
        ];
    }
}
