<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function service()
    {
        return $this->hasOne(Service::class, 'id', 'service_id');
    }

    public function getDate()
    {
        $day = Carbon::parse($this->date)->format('d');
        $month = Carbon::parse($this->date)->format('m');
        $year = Carbon::parse($this->date)->format('Y');
        return $day .'.'. $month .'.'. $year;
    }

    public function getTime()
    {
        return mb_substr($this->time,0, 5);
    }

    /**
     * Возвращает заказы для определенного юзера (салона)
     * @param $user_id
     * @return mixed
     */
    public static function getForSalon($user_id)
    {
        return self::whereIn('orders.salon_id', function ($query) use ($user_id){
            $query->select('salon_id')
                ->from('user_salon')
                ->where('user_id', $user_id);
        });
    }

    /**
     * Фильтры
     * @param $query
     * @param $filter
     * @param $sort
     * @param $orientation
     * @return mixed
     */
    public function scopeWithFilter($query, $filter, $sort = 'id', $orientation = 'DESC')
    {
        if($filter != 'all'){
            $query->leftJoin('order_status', 'order_status.id', 'orders.order_status_id')
                ->where('order_status.code', $filter)
                ->orderBy('orders.'.$sort, $orientation)
                ->select('orders.*');
        }else{
            $query->orderBy('orders.'.$sort, $orientation);
        }
        return $query;
    }

    public function client()
    {
        return $this->hasOne(User::class, 'id', 'client_id');
    }

    public function status($field)
    {
        return $this->join('order_status', 'order_status.id', 'orders.order_status_id')
                ->where('order_status.id', $this->order_status_id)
                ->pluck($field)
                ->first();
    }

    /**
     * Проверяет, доступен ли этот заказ для юзера (салона)
     * @param $user_id
     * @return mixed
     */
    public function checkAccess($user_id)
    {
        return $this->join('user_salon', 'user_salon.salon_id', 'orders.salon_id')
                    ->where('user_salon.user_id', $user_id)
                    ->exists();
    }
}
