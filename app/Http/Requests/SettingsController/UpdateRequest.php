<?php

namespace App\Http\Requests\SettingsController;

use Illuminate\Foundation\Http\FormRequest;

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
            'sleep_time' => 'integer',
            'telegram_text' => 'string|max:255',
            'push_text' => 'string|max:255',
            'tg_nick' => 'nullable|string|max:255',

            'name' => 'required|string|max:255',
            'phone' => 'required|min:16|regex:/[+]{1}[0-9]{1}[(]{1}[0-9]{3}[)]{1}[0-9]{3}[-]{1}[0-9]{2}[-]{1}[0-9]{2}/',
            'email' => 'required|email'
        ];
    }

    public function messages()
    {
        return [
            'sleep_time.integer' => 'Количество дней должно быть целым числом',

            'telegram_text.string' => 'Текст для Telegram должен быть строкой',
            'telegram_text.max' => 'Текст для Telegram должен иметь не более 255 символов',

            'push_text.string' => 'Текст для push-уведомлений должен быть строкой',
            'push_text.max' => 'Текст для push-уведомлений должен иметь не более 255 символов',

            'tg_nick.string' => 'Имя пользователя в Telegram должно быть строкой',
            'tg_nick.max' => 'Имя пользователя в Telegram должно иметь не более 255 символов',

            'name.required' => 'Введите имя',
            'name.string' => 'Неверное имя',
            'email.email' => 'Email не корректный',
            'email.required' => 'Введите Email',
            'phone.required' => 'Введите телефон пользователя',
            'phone.regex' => 'Поле телефон некорректное',
            'phone.min' => 'Поле телефон некорректное'
        ];
    }
}
