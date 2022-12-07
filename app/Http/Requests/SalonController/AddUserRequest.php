<?php

namespace App\Http\Requests\SalonController;

use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
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
            'phone' => 'required|unique:users,phone|min:16|regex:/[+]{1}[0-9]{1}[(]{1}[0-9]{3}[)]{1}[0-9]{3}[-]{1}[0-9]{2}[-]{1}[0-9]{2}/',
            'email' => 'required|unique:users,email|email',
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

    public function messages()
    {
        return [
            'name.required' => 'Введите имя',
            'name.string' => 'Неверный формат имени',

            'phone.required' => 'Введите телефон',
            'phone.unique' => 'Пользователь с таким телефоном уже существует',
            'phone.min' => 'Не верный формат телефона',
            'phone.regex' => 'Не верный формат телефона',

            'email.required' => 'Введите Email',
            'email.unique' => 'Пользователь с таким Email уже существует',
            'email.email' => 'Не верный формат Emai2l',

            'salon_id.required' => 'Выберите салон',
            'salon_id.integer' => 'Ошибка',
            'salon_id.exists' => 'Ошибка',

            'post_id.required' => 'Выберите должность',
            'post_id.integer' => 'Ошибка',
            'post_id.exists' => 'Ошибка'
        ];
    }
}
