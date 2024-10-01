<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MakeBookingRequest extends FormRequest
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
            'name' => 'required|max:255|string',
            'phone_number' => 'required|max:255|string',
            'time_at' => 'required|date_format:H:i:s',
        ];
    }
}
