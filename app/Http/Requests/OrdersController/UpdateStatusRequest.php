<?php

namespace App\Http\Requests\OrdersController;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStatusRequest extends FormRequest
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
            'order_status_id' => ['integer','required', Rule::in(['2', '3'])]
        ];
    }

    public function messages()
    {
        return [
            'order_status_id.integer' => 'Ошибка',
            'order_status_id.required' => 'Ошибка',
            'order_status_id.in' => 'Ошибка'
        ];
    }
}
