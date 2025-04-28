<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role == 'admin';
    }

    // public function

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
                Rule::unique(User::class)->ignore($this->route('user')->id),
                    ],

                'password' => [
                    'nullable',
                    'confirmed',
                    'min:8',
                    'string',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).+$/',
                ],

                'phone' => ['required',
                    Rule::unique(User::class, 'phone_number')->ignore($this->route('user')->id),
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
}
