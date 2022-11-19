<?php

namespace App\Http\Requests\RecordsController;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'service_id' => 'required|integer|exists:services,id',
            'salon_id' => 'required|integer|exists:salons,id',
            'choice-client' => '',
            'client_id' => 'required|integer|exists:users,id',

            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'whatsapp' => 'nullable|string',
            'telegram' => 'nullable|string',
            'phone' => 'nullable|string',
            'note' => 'nullable|string',
            'password' => 'nullable|string',
            'password_verify' => 'nullable|string'
        ];
    }
}
