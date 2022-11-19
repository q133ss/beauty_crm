<?php
namespace App\Services\Records;

use App\Models\Record;
use App\Models\User;

class StoreService{
    public static function store($data)
    {
        $record_data = [
            'date' => $data['date'],
            'time' => $data['time'],
            'salon_id' => $data['salon_id'],
            'service_id' => $data['service_id']
        ];

        if($data['choice-client'] == 'old'){
            $record_data['client_id'] = $data['client_id'];
            $record_data['user_id'] = Auth()->id();
            Record::create($record_data);
        }else{
            $user_data = [
                'name' => $data['name'],
                'email' => $data['email'],
                'note' => $data['note'],
                'password' => $data['password'],
                'password_verify' => $data['password_verify']
            ];

            $socials = [
                'whatsapp' => $data['whatsapp'],
                'telegram' => $data['telegram'],
                'phone' => $data['phone']
            ];

            $user_data['socials'] = json_encode($socials);

            $user = User::create($user_data);

            //Создаем заявку
            $record_data['client_id'] = $user->id;
            $record_data['user_id'] = Auth()->id();
            Record::create($record_data);
        }
        return true;
    }
}
