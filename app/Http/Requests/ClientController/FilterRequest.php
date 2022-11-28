<?php

namespace App\Http\Requests\ClientController;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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
            'salon' => [
                'integer',
                'exists:salons,id',
                function($attribute, $value, $fail){
                    //Проверка, принадлежит ли салон юзеру
                    abort_if(!Auth()->user()->checkSalon($value), 403);
                }
            ]
        ];
    }
}
