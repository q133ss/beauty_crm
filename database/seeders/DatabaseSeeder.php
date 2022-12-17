<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Day;
use App\Models\Order;
use App\Models\Role;
use App\Models\Salon;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\StuffPost;
use App\Models\User;
use App\Models\WorkTime;
use App\Services\TranslitService;
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
            'phone' => '89518677086',
            'role_id' => Role::where('name', 'admin')->pluck('id')->first()
        ]);

        \App\Models\User::create([
            'name' => 'master',
            'email' => 'master@email.net',
            'phone' => '899999999',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role_id' => Role::where('name', 'master')->pluck('id')->first()
        ]);

        \App\Models\User::create([
            'name' => 'user',
            'email' => 'user@email.net',
            'phone' => '8989888898989',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role_id' => Role::where('name', 'user')->pluck('id')->first()
        ]);

        for($i = 0; $i < 10; $i++){
            \App\Models\User::create([
                'name' => 'user'.$i,
                'email' => 'user'.$i.'@email.net',
                'phone' => '89515151'.$i,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'role_id' => Role::where('name', 'user')->pluck('id')->first()
            ]);
        }

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
                'name' => 'Салон 1',
                'work_days' => json_encode([1,2,3,4,5]),
                'description' => 'S Class Beauty — это многопрофильный центр с панорамным видом на воронежское водохранилище, где вам предоставят полный спектр услуг красоты.',
                'prepayment' => true,
                'percent' => 15
            ],
            [
                'name' => 'Бьюти сервис',
                'work_days' => json_encode([1,2,3,4,5]),
                'description' => 'Философия Green SPA — это совершеннейшая гармония человека и природы. Основа нашей методики строится на балансе духовного и физического начала, который невозможен без правильного питания и благостного образа мыслей. Здесь, в Green SPA, мы строим мост между внутренним и внешним миром посредством огромного спектра процедур и услуг, направленных на очищение организма и релаксацию.',
                'prepayment' => false
            ]
        ];

        foreach ($salons as $salon){
            Salon::create([
                'name' => $salon['name'],
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
                    'start' => Carbon::createFromFormat('H:i', '09:00')->format('H:i'),
                    'end' => Carbon::createFromFormat('H:i', '18:00')->format('H:i'),
                    'breaks' => json_encode([
                        Carbon::createFromFormat('H:i', '12:00')->format('H:i').'-'.Carbon::createFromFormat('H:i', '13:00')->format('H:i'),
                        Carbon::createFromFormat('H:i', '15:00')->format('H:i').'-'.Carbon::createFromFormat('H:i', '15:10')->format('H:i')
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


        #TODO Убать все что связанно с records


        //Статусы заказа
        DB::table('order_status')->insert([
            ['name' => 'Не обработана', 'code' => 'not_processed'],
            ['name' => 'Подтверждена', 'code' => 'confirmed'],
            ['name' => 'Отклонена', 'code' => 'rejected'],
            ['name' => 'Ожидание оплаты', 'code' => 'waiting_for_payment'],
            ['name' => 'Завершена', 'code' => 'сompleted'],
            ['name' => 'Не оплачена', 'code' => 'not_paid']
        ]);

        $orders = [
            [
                'user_id' => $admin_id,
                'client_id' => $client_id,
                'time' => Carbon::now(),
                'date' => new Carbon('2022-09-22')
            ],
            [
                'user_id' => $admin_id,
                'client_id' => $client_id,
                'time' => Carbon::now(),
                'date' => new Carbon('2022-11-03')
            ],
            [
                'user_id' => $admin_id,
                'client_id' => $client_id,
                'time' => Carbon::now(),
                'date' => new Carbon('2022-12-11')
            ],
            [
                'user_id' => $admin_id,
                'client_id' => $client_id,
                'time' => Carbon::now(),
                'date' => new Carbon('2020-03-12')
            ],
        ];

        foreach ($orders as $order){
            $service = Service::inRandomOrder()->first();
            Order::create([
                'service_name' => $service->name,
                'price' => $service->price,
                'order_status_id' => DB::table('order_status')->where('id', rand(1,6))->pluck('id')->first(),
                'master_id' => $order['user_id'],
                'salon_id' => rand(1,2),
                'client_id' => $client_id,
                'service_id' => $service->id,
                'work_time' => $service->work_time,
                'time' => $order['time'],
                'date' => $order['date'],
                'prepayment_percentage' => 0
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
                    'name' => $post,
                    'slug' => TranslitService::RusToLat($post),
                    'salon_id' => rand(1,2)
                ]
            );
        }

        DB::table('user_salon')->insert([
            'user_id' => 1,
            'salon_id' => 1,
            'post_id' => 1,
            'is_client' => false
        ]);

        DB::table('user_salon')->insert([
            'user_id' => 1,
            'salon_id' => 2,
            'post_id' => 1,
            'is_client' => false
        ]);

        //Finances
        $expenses_types = ['аренда', 'материалы', 'курсы', 'другое'];

        for($i = 0; $i<100; $i++){
            \App\Models\Income::create([
                'type' => rand(1,2),
                'sum' => rand(499.0, 3500.0),
                'date' => Carbon::now()->subDays(rand(1,256)),
                'user_id' => 1
            ]);

            if($i < 70) {
                \App\Models\Expense::create([
                    'type' => $expenses_types[rand(0, 3)],
                    'sum' => rand(499.0, 3500.0),
                    'date' => Carbon::now()->subDays(rand(1, 256)),
                    'user_id' => 1
                ]);
            }
        }

        $settings = [
            [
                'key' => 'sleep_time',
                'value' => '60',
                'user_id' => 1
            ],
            [
                'key' => 'telegram_text',
                'value' => 'Здравствуйте {name}, вы давно не пользовались нашими услугами. Мы предлогаем вам скидку в размере 20% на следующий заказ по промокоду «wellcomeback». С уважением, салон красоты {salon_name}',
                'user_id' => 1
            ],
            [
                'key' => 'push_text',
                'value' => 'Вы давно не пользовались нашими услугами. Мы предлогаем вам скидку в размере 20% на следующий заказ',
                'user_id' => 1
            ],
        ];

        foreach ($settings as $setting){
            \App\Models\Setting::create($setting);
        }
    }
}
