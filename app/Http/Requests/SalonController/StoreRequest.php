<?php

namespace App\Http\Requests\SalonController;

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
        //dd($this);
        return [
            'name' => 'string|required',
            'description' => 'string|required',
            'percent' => 'integer',
            'status' => 'integer|required',

            'start_time-1' => 'required|date_format:"H:i"',
            'end_time-1' => 'required|date_format:"H:i"',
            'start_break_1' => 'array',
            'stop_break_1' => 'array',
            'start_time-2' => 'required|date_format:"H:i"',
            'end_time-2' => 'required|date_format:"H:i"',
            'start_break_2' => 'array',
            'stop_break_2' => 'array',
            'start_time-3' => 'required|date_format:"H:i"',
            'end_time-3' => 'required|date_format:"H:i"',
            'start_break_3' => 'array',
            'stop_break_3' => 'array',
            'start_time-4' => 'required|date_format:"H:i"',
            'end_time-4' => 'required|date_format:"H:i"',
            'start_break_4' => 'array',
            'stop_break_4' => 'array',
            'start_time-5' => 'required|date_format:"H:i"',
            'end_time-5' => 'required|date_format:"H:i"',
            'start_break_5' => 'array',
            'stop_break_5' => 'array',
            'start_time-6' => 'required|date_format:"H:i"',
            'end_time-6' => 'required|date_format:"H:i"',
            'start_break_6' => 'array',
            'stop_break_6' => 'array',
            'start_time-7' => 'required|date_format:"H:i"',
            'end_time-7' => 'required|date_format:"H:i"',
            'start_break_7' => 'array',
            'stop_break_7' => 'array',

            'stuff_name' => 'array',
            'stuff_phone' => 'array',
            'stuff_email' => 'array',
            'stuff_post' => 'array'
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'Неверный формат названия',
            'name.required' => 'Введите название',
            'description.string' => 'Неверный формат описания',
            'description.required' => 'Введите описание',
            'percent.integer' => 'Неверный формат процента предоплаты',
            'status.integer' => 'Неверный формат статуса',
            'status.required' => 'Укажите статус',

            'start_time-1.' => 'Укажите начало рабочего дня в понедельник',
            'start_time-1.date_format' => 'Неверный формат начала рабочего дня в понедельник',
            'end_time-1.required' => 'Укажите конец рабочего дня в понедельник',
            'end_time-1.date_format' => 'Неверный формат конца рабочего дня в понедельник',
            'start_break_1.array' => 'Ошибка, попробуйте еще раз',
            'stop_break_1.array' => 'Ошибка, попробуйте еще раз',

            'start_time-2.required' => 'Укажите начало рабочего дня во вторник',
            'start_time-2.date_format' => 'Неверный формат начала рабочего дня во вторник',
            'end_time-2.required' => 'Укажите конец рабочего дня во вторник',
            'end_time-2.date_format' => 'Неверный формат конца рабочего дня во вторник',

            'start_break_2.array' => 'Ошибка, попробуйте еще раз',
            'stop_break_2.array' => 'Ошибка, попробуйте еще раз',

            'start_time-3.required' => 'Укажите начало рабочего дня в среду',
            'start_time-3.date_format' => 'Неверный формат начала рабочего дня в среду',

            'end_time-3.required' => 'Укажите конец рабочего дня в среду',
            'end_time-3.date_format' => 'Неверный формат конца рабочего дня в среду',

            'start_break_3.array' => 'Ошибка, попробуйте еще раз',
            'stop_break_3.array' => 'Ошибка, попробуйте еще раз',

            'start_time-4.required' => 'Укажите начало рабочего дня в четверг',
            'start_time-4.date_format' => 'Неверный формат начала рабочего дня в четверг',

            'end_time-4.required' => 'Укажите конец рабочего дня в четверг',
            'end_time-4.date_format' => 'Неверный формат конца рабочего дня в четверг',

            'start_break_4.array' => 'Ошибка, попробуйте еще раз',
            'stop_break_4.array' => 'Ошибка, попробуйте еще раз',

            'start_time-5.required' => 'Укажите начало рабочего дня в пятницу',
            'start_time-5.date_format' => 'Неверный формат начала рабочего дня в пятницу',

            'end_time-5.required' => 'Укажите конец рабочего дня в четверг',
            'end_time-5.date_format' => 'Неверный формат конца рабочего дня в четверг',

            'start_break_5.array' => 'Ошибка, попробуйте еще раз',
            'stop_break_5.array' => 'Ошибка, попробуйте еще раз',

            'start_time-6.required' => 'Укажите начало рабочего дня в субботу',
            'start_time-6.date_format' => 'Неверный формат начала рабочего дня в субботу',

            'end_time-6.required' => 'Укажите конец рабочего дня в субботу',
            'end_time-6.date_format' => 'Неверный формат конца рабочего дня в субботу',

            'start_break_6.array' => 'Ошибка, попробуйте еще раз',
            'stop_break_6.array' => 'Ошибка, попробуйте еще раз',

            'start_time-7.required' => 'Укажите начало рабочего дня в воскресенье',
            'start_time-7.date_format' => 'Неверный формат начала рабочего дня в воскресенье',

            'end_time-7.required' => 'Укажите конец рабочего дня в воскресенье',
            'end_time-7.date_format' => 'Неверный формат конца рабочего дня в воскресенье',

            'start_break_7.array' => 'Ошибка, попробуйте еще раз',
            'stop_break_7.array' => 'Ошибка, попробуйте еще раз',

            'stuff_name.array' => 'Ошибка, попробуйте еще раз',
            'stuff_phone.array' => 'Ошибка, попробуйте еще раз',
            'stuff_email.array' => 'Ошибка, попробуйте еще раз',
            'stuff_post.array' => 'Ошибка, попробуйте еще раз'
        ];
    }
}
