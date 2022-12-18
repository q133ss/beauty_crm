<?php

namespace App\Http\Requests\SalonController;

use Illuminate\Foundation\Http\FormRequest;

class ChangeWorkTimeRequest extends FormRequest
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
            'start' => 'date_format:"H:i:s"|required',
            'end' => 'date_format:"H:i:s"|required|after:start'
        ];
    }

    public function messages()
    {
        return [
            'start.date_format' => 'Неверный формат времени',
            'start.required' => 'Укажите начало рабочего дня',

            'end.date_format' => 'Неверный формат времени',
            'end.required' => 'Укажите конец рабочего дня',
            'end.after' => 'Конец рабочего дня не должен быть меньше чем начало'
        ];
    }
}
