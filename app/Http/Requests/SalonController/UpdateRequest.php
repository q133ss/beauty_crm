<?php

namespace App\Http\Requests\SalonController;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => 'string|required',
            'description' => 'string|required',
            'percent' => 'integer',
            'status' => ['required', Rule::in(['1','0'])]
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'Неверный формат названия',
            'name.required' => 'Введите название',

            'description.string' => 'Неверный формат описания',
            'description.required' => 'Введите описание',

            'percent.integer' => 'Неверный формат процента преодплаты',

            'status.required' => 'Неверный статус',
            'status.rule' => 'Ошибка статуса'
        ];
    }
}
