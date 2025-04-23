<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function prepareForValidation()
        {
            // $this->route('service') is your Service model via implicit binding
            $this->merge([
                'existing_images' => $this->route('service')->images->count(),
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
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|min:5|max:50',
            'description' => 'required|string|min:30|max:500',
            'hourly_rate' => 'required|numeric|min:1',
            'city_id' => 'required|exists:cities,id',
            'address' => 'nullable|string|min:5|max:100',
            'featured_until' => 'nullable|date|after_or_equal:today',
            'images' => 'required_without:existing_images|array',
            'images.*' => 'image|mimes:jpg,png,bmp,gif|max:5120'
        ];
    }
}
