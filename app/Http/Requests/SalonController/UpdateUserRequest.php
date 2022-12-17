<?php

namespace App\Http\Requests\SalonController;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|string',
            'phone' => 'required|min:16|regex:/[+]{1}[0-9]{1}[(]{1}[0-9]{3}[)]{1}[0-9]{3}[-]{1}[0-9]{2}[-]{1}[0-9]{2}/',
            'email' => 'required|email',
            'salon_id' => [
                'required',
                'integer',
                'exists:salons,id',
                function($attribute, $value, $fail){
                    //Проверка, принадлежит ли салон юзеру
                    abort_if(!Auth()->user()->checkSalon($value), 403);
                }
            ],
            'post_id' => 'required|integer|exists:stuff_posts,id'
        ];
    }
}
