<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Day;
use App\Models\Record;
use App\Models\RecordStatus;
use App\Models\Role;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Time;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'admin',
            'master',
            'user'
        ];

        foreach ($roles as $role){
            Role::create([
                'name' => $role
            ]);
        }

        \App\Models\User::create([
            'name' => 'admin',
            'email' => 'admin@email.net',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'email_verified_at' => Carbon::now(),
            'role_id' => Role::where('name', 'admin')->pluck('id')->first()
        ]);

        \App\Models\User::create([
            'name' => 'master',
            'email' => 'master@email.net',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role_id' => Role::where('name', 'master')->pluck('id')->first()
        ]);

        \App\Models\User::create([
            'name' => 'user',
            'email' => 'user@email.net',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role_id' => Role::where('name', 'user')->pluck('id')->first()
        ]);

        $days = [
            'Понедельник' => 'Пн',
            'Вторник' => 'Вт',
            'Среда' => 'Ср',
            'Четверг' => 'Чт',
            'Пятница' => 'Пт',
            'Суббота' => 'Сб',
            'Воскресенье' => 'Вс'
        ];

        foreach ($days as $day => $short){
            Day::create([
                'name' => $day,
                'short_name' => $short
            ]);
        }

        $service_cats = [
            'Наращивание ресниц',
            'Маникюр'
        ];

        foreach ($service_cats as $service) {
            ServiceCategory::create([
                'name' => $service
            ]);
        }

        $cat_id = ServiceCategory::where('name', 'Наращивание ресниц')->pluck('id')->first();
        $admin_id = User::where('name','admin')->pluck('id')->first();

        $services = [
            [
                'name' => 'Нарщивание 3д',
                'description' => 'Наращу крутые реснички!',
                'price' => 2000,
                'work_time' => '03:00',
                'user_id' => $admin_id,
                'category_service_id' => $cat_id
            ],
            [
                'name' => 'Классика',
                'description' => 'Сделаю крутую классику!',
                'price' => 1200,
                'work_time' => '02:00',
                'user_id' => $admin_id,
                'category_service_id' => $cat_id
            ]
        ];

        foreach ($services as $service){
            Service::create([
                'name' => $service['name'],
                'description' => $service['description'],
                'price' => $service['price'],
                'user_id' => $service['user_id'],
                'work_time' => $service['work_time'],
                'category_service_id' => $service['category_service_id']
            ]);
        }

        $client_id = User::where('name', 'user')->pluck('id')->first();

        $record_statuses = [
            'not_processed',
            'confirmed',
            'rejected'
        ];

        foreach ($record_statuses as $status){
            RecordStatus::create([
                'name' => $status
            ]);
        }

        $records = [
            [
                'user_id' => $admin_id,
                'client_id' => $client_id,
                'service_id' => rand(1,2),
                'time' => Carbon::now(),
                'date' => new Carbon('2022-09-22')
            ],
            [
                'user_id' => $admin_id,
                'client_id' => $client_id,
                'service_id' => rand(1,2),
                'time' => Carbon::now(),
                'date' => new Carbon('2022-11-03')
            ],
            [
                'user_id' => $admin_id,
                'client_id' => $client_id,
                'service_id' => rand(1,2),
                'time' => Carbon::now(),
                'date' => new Carbon('2022-12-11')
            ],
            [
                'user_id' => $admin_id,
                'client_id' => $client_id,
                'service_id' => rand(1,2),
                'time' => Carbon::now(),
                'date' => new Carbon('2020-03-12')
            ],
        ];

        foreach ($records as $record){
            Record::create([
                'user_id' => $record['user_id'],
                'client_id' => $record['client_id'],
                'service_id' => $record['service_id'],
                'time' => $record['time'],
                'date' => $record['date']
            ]);
        }

    }
}
