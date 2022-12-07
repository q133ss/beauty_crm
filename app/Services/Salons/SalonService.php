<?php
namespace App\Services\Salons;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class SalonService{
    public static function addUser($data)
    {
        $user_data = [
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => 'dhIHb2@djeoihfaser3I2j'
        ];

        $user = User::create($user_data);
        DB::table('user_salon')->insert([
            'user_id' => $user->id,
            'salon_id' => $data['salon_id'],
            'post_id' => $data['post_id'],
            'is_client' => false
        ]);

        return collect([
            'id' => $user->id,
            'name' => $user->name,
            'post' => $user->getSalonPost($data['salon_id'])
        ]);
    }
}
