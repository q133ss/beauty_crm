<?php
namespace App\Services\Clients;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class StoreService{
    public static function store($data){
        $data['password'] = '$2y$10$a2IpUNpkjO0rOi5byk0.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

        $socials = [];
        foreach ($data['social_name'] as $key => $name){
            if(!empty($name)) {
                $socials[$name] = $data['social_val'][$key];
            }
        }
       $data['socials'] = json_encode($socials);

        $user = User::create($data);
        DB::table('user_salon')->insert(
            ['user_id' => $user->id, 'salon_id' => $data['salon_id'], 'is_client' => true]
        );
        return true;
    }
}
