<?php

namespace App\Http\Requests\SalonController;

use Illuminate\Foundation\Http\FormRequest;

class AddBreakRequest extends FormRequest
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
            'start' => 'required',
            'stop' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'start.required' => 'Укажите начало перерыва',
            'stop.required' => 'Укажите конец перерыва'
        ];
    }
}
