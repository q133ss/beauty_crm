<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsController\UpdateRequest;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth()->user();
        return view('settings', compact('user'));
    }

    public function update(UpdateRequest $request)
    {
        $fields = [
            'sleep_time',
            'telegram_text',
            'push_text',
            'tg_nick'
        ];
        foreach ($fields as $field){
            if($request->$field != null) {
                Auth()->user()->updateSetting($field, $request->$field);
            }
        }

        return to_route('settings.index')->withSuccess('Настройки сохранены');
            //name
            //phone
            //email
    }
}
