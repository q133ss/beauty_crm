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

    public function scopeWithFilter($query, $filter, $sort = 'DESC', $orientation = 'ASC')
    {
        /*
         * У нас будут, основные фильтры по полям accepted, rejected..
         * Так же будут фильтры по всем
         * Не обработанные тоже отдельное поле
         *
         * Не обработанные и все!
         */

        if($filter != 'all'){
            $query->leftJoin('order_status', 'order_status.id', 'orders.order_status_id')
                ->where('order_status.code', $filter);
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
                ->pluck($field)
                ->first();
    }
}
