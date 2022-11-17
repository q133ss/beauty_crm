<?php

namespace App\Http\Requests\RecordsController;

use Illuminate\Foundation\Http\FormRequest;

class StatusRequest extends FormRequest
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
            'id' => 'required|integer|exists:records,id',
            'status_id' => 'required|integer|exists:record_statuses,id'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Ошибка',
            'id.integer' => 'Ошибка',
            'id.exists' => 'Ошибка',
            'status_id.required' => 'Ошибка',
            'status_id.integer' => 'Ошибка',
            'status_id.exists' => 'Ошибка'
        ];
    }
}
