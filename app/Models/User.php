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
        'socials',
        'note'
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

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'user_order');
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

    /**
     * Возвращает всех клиентов для текущего юзера
     * @return mixed
     */
    public function getClients()
    {
       return $this->whereIn('id', function ($query){
            $query->select('user_id')
                ->from('user_salon')
                ->whereIn('salon_id', $this->salons->pluck('id')->all())
                ->where('is_client', true)
                ->where('user_id', '!=', $this->id);
        })
        ->get();
    }

    /**
     * Возвращает дату последнего заказа
     * @return mixed
     */
    public function lastOrderDate()
    {
        return $this->join('orders', 'orders.client_id', 'users.id')
            ->where('orders.client_id', $this->id)
            ->orderBy('orders.created_at', 'DESC')
            ->pluck('orders.created_at')->first();
    }
}
