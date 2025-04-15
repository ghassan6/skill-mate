<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['nullable', 'string', 'max:255', 'min:5'],
            'email' => [
                'nullable',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
                    ],

                'password' => ['nullable', 'confirmed', 'min:8', 'string'],

                'phone' => ['nullable',
                    Rule::unique(User::class, 'phone_number')->ignore($this->user()->id),
                    'string',
                    'min:10',
                    ],

                'city_id' => ['nullable', 'exists:cities,id'],
                'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
                'bio' => ['nullable' , 'string', 'max:500' , 'min:10']


        ];
    }
}
