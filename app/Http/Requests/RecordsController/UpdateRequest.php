<?php

namespace App\Http\Requests\RecordsController;

use App\Models\Record;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:i',
            'service_id' => 'required|integer|exists:services,id'
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'Выберите дату',
            'date.date_format' => 'Неверный формат даты',
            'service_id.required' => 'Выберите услугу',
            'service_id.integer' => 'Ошибка',
            'service_id.exists' => 'Ошибка'
        ];
    }
}
