<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'end_subscription',
        'role_id',
        'phone',
        'telegram',
        'socials'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function getAvatar(){
        return $this->morphOne(File::class, 'fillable')->where('category', 'avatar');
    }

    public function avatar()
    {
        return $this->getAvatar ? $this->getAvatar->src : '/images/no-avatar.png';
    }

    public function salon()
    {
        return $this->belongsToMany(Salon::class, 'user_salon');
    }

    /**
     * @return mixed
     */
    public function recordsIds()
    {
        return $this->join('user_salon', 'user_salon.user_id', 'users.id')
                    ->where('user_salon.user_id', $this->id)
                    ->join('salons', 'salons.id', 'user_salon.salon_id')
                    ->join('records', 'records.salon_id', 'salons.id')
                    ->pluck('records.id')
                    ->all();
    }

    /**
     * @return mixed
     */
    public function services()
    {
        return $this->join('user_salon', 'user_salon.user_id', 'users.id')
                    ->where('users.id', $this->id)
                    ->where('user_salon.user_id', $this->id)
                    ->join('salons', 'salons.id', 'user_salon.salon_id')
                    ->join('services', 'services.salon_id', 'salons.id')
                    ->select('services.*')
                    ->get();
    }

    public function clients()
    {
        $client_ids = $this->join('user_salon', 'user_salon.id', 'users.id')
                    ->where('users.id', $this->id)
                    ->join('salons', 'salons.id', 'user_salon.salon_id')
                    ->join('user_order', 'user_order.salon_id', 'salons.id')
                    ->join('orders', 'orders.id', 'user_order.order_id')
                    ->pluck('orders.client_id')
                    ->all();

        return $this->whereIn('id', $client_ids)->get();
    }

    public function clientsSalonFilter($salon_id)
    {
        $client_ids = $this->join('user_salon', 'user_salon.id', 'users.id')
            ->where('users.id', $this->id)
            ->join('salons', 'salons.id', 'user_salon.salon_id')
            ->join('user_order', 'user_order.salon_id', 'salons.id')
            ->where('salons.id', $salon_id)
            ->join('orders', 'orders.id', 'user_order.order_id')
            ->pluck('orders.client_id')
            ->all();

        return $this->whereIn('id', $client_ids)->get();
    }

    public function clientsFilter($client_id)
    {
        $client_ids = $this->join('user_salon', 'user_salon.id', 'users.id')
            ->where('users.id', $this->id)
            ->join('salons', 'salons.id', 'user_salon.salon_id')
            ->join('user_order', 'user_order.salon_id', 'salons.id')
            ->join('orders', 'orders.id', 'user_order.order_id')
            ->where('client_id', $client_id)
            ->pluck('orders.client_id')
            ->all();

        return $this->whereIn('id', $client_ids)->get();
    }

    /**
     * Проверяет, относиться-ли клиент к юзеру
     * Нужно для того, что бы нельзя было смотреть чужих клиентов
     * @param $client_id
     * @return bool
     */
    public function checkClient($client_id)
    {
        $records = $this->join('user_salon', 'user_salon.user_id', 'users.id')
            ->where('users.id', $this->id)
            ->join('records', 'records.salon_id', 'user_salon.salon_id')
            ->where('records.client_id', $client_id)
            ->exists();

        $orders = $this->join('user_salon', 'user_salon.user_id', 'users.id')
            ->where('users.id', $this->id)
            ->join('user_order', 'user_order.salon_id', 'user_salon.id')
            ->join('orders', 'orders.id', 'user_order.order_id')
            ->where('orders.client_id', $client_id)
            ->exists();

        if($records || $orders) {
            return true;
        }

        return false;
    }

    public function clientsSearch($request)
    {
        #TODO Сделать регистронезависимый поиск
        $client_ids = $this->join('user_salon', 'user_salon.id', 'users.id')
            ->where('users.id', $this->id)
            ->join('salons', 'salons.id', 'user_salon.salon_id')
            ->join('user_order', 'user_order.salon_id', 'salons.id')
            ->join('orders', 'orders.id', 'user_order.order_id')
            ->where('orders.date', 'LIKE', '%'.$request.'%')
            ->orWhere('orders.time', 'LIKE', '%'.$request.'%')
            ->orWhere('salons.name', 'LIKE', '%'.$request.'%')
            ->pluck('orders.client_id')
            ->all();

        return $this->whereIn('id', $client_ids)
            ->orWhere('name', 'LIKE', '%'.$request.'%')
            ->orWhere('phone', 'LIKE', '%'.$request.'%')
            ->get();
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'user_order');
    }

    /**
     * Возвращает послений заказ
     * @return string
     */
    public function lastOrder()
    {
        return $this->join('user_order', 'user_order.user_id','users.id')
                    ->join('orders', 'orders.id', 'user_order.order_id')
                    ->orderBy('orders.created_at','DESC')
                    ->select('orders.*')
                    ->first();
    }

    public function lastOrderSalon()
    {
        return DB::table('orders')
            ->leftJoin('salons', 'salons.id', '=', 'orders.salon_id')
            ->where('salons.id',$this->lastOrder()->id)
            ->select('salons.*')
            ->first();
    }

    /**
     * Возвращет массив с контактными даннами
     * @return mixed
     */
    public function socials()
    {
        return json_decode($this->socials);
    }

    /**
     * Возвращает сумму по полю
     * Нужно для статистики
     * @param $client_id
     * @param $field
     * @return mixed
     */
    public function getSum($client_id, $field)
    {
        return $this->join('user_order', 'user_order.user_id','users.id')
            ->where('users.id', $client_id)
            ->join('orders', 'orders.id', 'user_order.order_id')
            ->where('orders.client_id', $client_id)
            ->sum($field);
    }

    /**
     * Возвращает сумму времени
     * Затраченного на работу
     * @param $client_id
     * @return string
     */
    public function getSumWorkTime($client_id)
    {
        $times = $this->join('user_order', 'user_order.user_id','users.id')
            ->where('users.id', $client_id)
            ->join('orders', 'orders.id', 'user_order.order_id')
            ->where('orders.client_id', $client_id)
            ->pluck('work_time')
            ->all();

        $time_sum = [];
        foreach ($times as $time){
            $time_sum[] = strtotime($time);
        }

        return date('H:i',array_sum($time_sum));
    }

    public function salons()
    {
        return $this->belongsToMany(Salon::class, 'user_salon', 'user_id', 'salon_id');
    }
}
