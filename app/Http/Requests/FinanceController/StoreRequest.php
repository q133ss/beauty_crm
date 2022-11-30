<?php

namespace App\Http\Requests\FinanceController;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'finance_type' => ['required', Rule::in(['income', 'expense'])],
            'type' => 'required|string',
            'sum' => 'required|integer|min:1',
            'date' => 'required|date_format:Y-m-d'
        ];
    }

    public function messages()
    {
        return [
            'finance_type.required' => 'Ошибка',
            'finance_type.in' => 'Ошибка',

            'type.required' => 'Выберите тип',
            'type.string' => 'Ошибка',

            'sum.required' => 'Введите сумму',
            'sum.integer' => 'Сумма должна быть целым числом',
            'sum.min' => 'Сумма должна быть больше 1',

            'date.required' => 'Выберите дату',
            'date.date_format' => 'Ошибка'
        ];
    }
}
