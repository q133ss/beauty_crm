<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Day;
use App\Models\Record;
use App\Models\RecordStatus;
use App\Models\Role;
use App\Models\Salon;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\StuffPost;
use App\Models\Time;
use App\Models\User;
use App\Models\WorkTime;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        $salons = [
            [
                'work_days' => json_encode([1,2,3,4,5]),
                'description' => 'S Class Beauty — это многопрофильный центр с панорамным видом на воронежское водохранилище, где вам предоставят полный спектр услуг красоты.',
                'prepayment' => true,
                'percent' => 15
            ],
            [
                'work_days' => json_encode([1,2,3,4,5]),
                'description' => 'Философия Green SPA — это совершеннейшая гармония человека и природы. Основа нашей методики строится на балансе духовного и физического начала, который невозможен без правильного питания и благостного образа мыслей. Здесь, в Green SPA, мы строим мост между внутренним и внешним миром посредством огромного спектра процедур и услуг, направленных на очищение организма и релаксацию.',
                'prepayment' => false
            ]
        ];

        foreach ($salons as $salon){
            Salon::create([
                'work_days' => $salon['work_days'],
                'description' => $salon['description'],
                'prepayment' => $salon['prepayment']
            ]);
        }

        //salon times
        $getSalons = Salon::get();
        foreach ($getSalons as $salon) {
            foreach ($salon->workDays() as $day) {
                WorkTime::create([
                    'day_id' => $day,
                    'salon_id' => $salon->id,
                    'start' => Carbon::createFromFormat('H:i', '09:00'),
                    'end' => Carbon::createFromFormat('H:i', '18:00'),
                    'breaks' => json_encode([
                        Carbon::createFromFormat('H:i', '12:00').'-'.Carbon::createFromFormat('H:i', '13:00'),
                        Carbon::createFromFormat('H:i', '15:00').'-'.Carbon::createFromFormat('H:i', '15:10')
                    ])
                ]);
            }
        }

        $services = [
            [
                'name' => 'Нарщивание 3д',
                'description' => 'Наращу крутые реснички!',
                'price' => 2000,
                'work_time' => '03:00',
                'salon_id' => rand(1,2),
                'category_service_id' => $cat_id
            ],
            [
                'name' => 'Классика',
                'description' => 'Сделаю крутую классику!',
                'price' => 1200,
                'work_time' => '02:00',
                'salon_id' => 1,
                'category_service_id' => $cat_id
            ],
            [
                'name' => 'Снять классику',
                'description' => 'Снямим классику!',
                'price' => 100,
                'work_time' => '00:10',
                'salon_id' => 1,
                'parent_id' => 2,
                'category_service_id' => $cat_id
            ]
        ];

        foreach ($services as $service){
            Service::create([
                'name' => $service['name'],
                'description' => $service['description'],
                'price' => $service['price'],
                'salon_id' => $service['salon_id'],
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
                'salon_id' => rand(1,2),
                'client_id' => $client_id,
                'service_id' => $record['service_id'],
                'time' => $record['time'],
                'date' => $record['date']
            ]);
        }

        $stuff_posts = [
            'Владелец',
            'Мастер',
            'Администратор'
        ];

        foreach ($stuff_posts as $post) {
            StuffPost::create(
                [
                    'name' => $post
                ]
            );
        }

        DB::table('user_salon')->insert([
            'user_id' => 1,
            'salon_id' => 1,
            'post_id' => 1
        ]);

        DB::table('user_salon')->insert([
            'user_id' => 1,
            'salon_id' => 2,
            'post_id' => 1
        ]);

    }
}
