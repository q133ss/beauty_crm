<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Day;
use App\Models\Role;
use App\Models\Time;
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

        $times = [
            '00:00',
            '00:30',

            '01:00',
            '01:30',

            '02:00',
            '02:30',

            '03:00',
            '03:30',

            '04:00',
            '04:30',

            '05:00',
            '05:30',

            '06:00',
            '06:30',

            '07:00',
            '07:30',

            '08:00',
            '08:30',

            '09:00',
            '09:30',

            '10:00',
            '10:30',

            '11:00',
            '11:30',

            '12:00',
            '12:30',

            '13:00',
            '13:30',

            '14:00',
            '14:30',

            '15:00',
            '15:30',

            '16:00',
            '16:30',

            '17:00',
            '17:30',

            '18:00',
            '18:30',

            '19:00',
            '19:30',

            '20:00',
            '20:30',

            '21:00',
            '21:30',

            '22:00',
            '22:30',

            '23:00',
            '23:30'
        ];

        foreach ($times as $time){
            Time::create([
                'time' => $time
            ]);
        }
    }
}
