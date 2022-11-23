<?php

namespace App\Http\Requests\ClientController;

use Illuminate\Foundation\Http\FormRequest;

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
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone|min:16|regex:/[+]{1}[0-9]{1}[(]{1}[0-9]{3}[)]{1}[0-9]{3}[-]{1}[0-9]{2}[-]{1}[0-9]{2}/',
            'telegram' => 'string',
            'salon_id' => [
                'integer',
                'exists:salons,id',
                function($attribute, $value, $fail){
                    abort_if(!Auth()->user()->salonCheck($value), 403);
                }
            ],
            'social_name' => 'nullable|array',
            'social_val' => 'nullable|array',
            'note' => 'nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Введите имя пользователя',
            'name.string' => 'Неверное имя пользователя',
            'email.email' => 'Email не корректный',
            'email.required' => 'Введите Email',
            'email.unique' => 'Пользователь с таким Email уже существует',

            'telegram.string' => 'Поле Telegram некорректное',
            'phone.required' => 'Введите телефон пользователя',
            'phone.unique' => 'Пользователь с таким номером телефона уже существует',
            'phone.regex' => 'Поле телефон некорректное',
            'phone.min' => 'Поле телефон некорректное',
            'note.string' => 'Поле заметка некорректное'
        ];
    }
}
