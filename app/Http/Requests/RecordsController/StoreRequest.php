<?php

namespace App\Http\Requests\RecordsController;

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
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'service_id' => 'required|integer|exists:services,id',
            'salon_id' => 'required|integer|exists:salons,id',
            'choice-client' => '',
            'client_id' => 'required|integer|exists:users,id',

            'name' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email',
            'whatsapp' => 'nullable|string',
            'telegram' => 'nullable|string',
            'phone' => 'nullable|string',
            'note' => 'nullable|string',
            'password' => 'nullable|string|required_with:password_verify|same:password_verify',
            'password_verify' => 'nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'Выберите дату',
            'date.date' => 'Неверный формат даты',

            'time.required' => 'Введите время',
            'time.date_format' => 'Не верный формат времени',

            'service_id.required' => 'Выберите услугу',
            'service_id.integer' => 'Такой услуги не существует',
            'service_id.exists' => 'Такой услуги не существует',

            'salon.required' => 'Выберите салон',
            'salon.integer' => 'Такого салона не существует',
            'salon.exists' => 'Такого салона не существует',

            'client_id.required' => 'Выберите клиента',
            'client_id.integer' => 'Такого клиента не существует',
            'client_id.exists' => 'Такого клиента не существует',

            'name.string' => 'Неверное имя пользователя',
            'email.email' => 'Email не корректный',
            'email.unique' => 'Пользователь с таким Email уже существует',

            'whatsapp.string' => 'Поле Whatsapp некорректное',
            'telegram.string' => 'Поле Telegram некорректное',
            'phone.string' => 'Поле телефон некорректное',
            'note.string' => 'Поле заметка некорректное',

            'password.string' => 'Поле пароль некорректное',
            'password.required_with' => 'Пароли не совпадют',
            'password.same' => 'Пароли не совпадют'
        ];
    }
}
