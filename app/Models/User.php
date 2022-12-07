<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
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

    public function getClientSum($client_id, $field)
    {
        $query = $this->join('user_order', 'user_order.user_id','users.id')
                ->where('users.id', $client_id)
                ->join('orders', 'orders.id', 'user_order.order_id')
                ->where('orders.client_id', $client_id)
                ->pluck($field)
                ->all();
        return array_sum($query);
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

    /**
     * Проверяет, относиться ли салон к клиенту
     * @param $salon_id
     * @return mixed
     */
    public function checkSalon($salon_id)
    {
        return $this->join('user_salon', 'user_salon.user_id', 'users.id')
                    ->where('user_salon.salon_id', $salon_id)
                    ->where('user_salon.user_id', $this->id)
                    ->where('user_salon.is_client', false)
                    ->exists();
    }

    private function isJoined($query, $table){
        $joins = collect($query->getQuery()->joins);
        return $joins->pluck('table')->contains($table);
    }

    public function checkClient($client_id)
    {
        return $this->where('id', function ($query) use ($client_id){
            $query->select('user_id')
                ->from('user_salon')
                ->whereIn('salon_id', $this->salons->pluck('id')->all())
                ->where('user_id', $client_id)
                ->where('is_client', true)
                ->limit(1);
        })->exists();
    }

    private function filterSort($query, $sort, $orientation, $request){
        if($sort != 'lastOrder') {
            return $query->orderBy('users.' . $sort, $orientation)->get();
        }else{
            //TODO да-да, я знаю)
            //Сортировка по последнему заказу
            $user_ids = $query->get()->pluck('id')->all();
            $users = $this->whereIn('id', $user_ids);
            $users->orderBy('id', $orientation);
            return $users->get();
        }
    }

    public function scopeWithFilter($query, Request $request, $filter, $sort = 'id', $orientation = 'DESC')
    {
        switch ($filter){
            case('salon'):
                //Проверяем, фильтр по всем салонам или по конкретному
                if($request->salon_id != 'all') {
                    $query->leftJoin('user_salon', 'user_salon.user_id', 'users.id')
                        ->where('user_salon.is_client', true)
                        ->where('user_salon.user_id', '!=', Auth()->id())
                        ->where('user_salon.salon_id', $request->salon_id);
                }else{
                    //Если все салоны
                    if(!$this->isJoined($query, 'user_salon')) {
                        $query->leftJoin('user_salon', 'user_salon.user_id', 'users.id');
                    }
                    $query->where('user_salon.is_client', true)
                        ->where('user_salon.user_id', '!=', Auth()->id())
                        ->whereIn('user_salon.salon_id', Auth()->user()->salons->pluck('id')->all());
                }

            case 'search':
                $query->where('users.name', 'LIKE', '%'.$request->search.'%');
//                    ->orWhere('users.note', 'LIKE', '%'.$request->search.'%')
//                    ->orWhere('users.phone', 'LIKE', '%'.$request->search.'%')
//                    ->orWhere('users.telegram', 'LIKE', '%'.$request->search.'%')
//                    ->orWhere('users.socials', 'LIKE', '%'.$request->search.'%');
        }
        return $this->filterSort($query, $sort, $orientation, $request);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class, 'user_id', 'id')->orderBy('date', 'DESC');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'user_id', 'id')->orderBy('date', 'DESC');
    }

    public function settings()
    {
        return $this->hasMany(Setting::class, 'user_id', 'id');
    }

    public function getSetting($key)
    {
        return $this->settings->where('key', $key)->pluck('value')->first();
    }

    public function updateSetting($key, $value)
    {
        if($this->settings->where('key', $key)->first()) {
            $setting = $this->settings->where('key', $key)->first();
        }else{
            $setting = Setting::create(['key' => $key, 'value' => $value, 'user_id' => $this->id]);
        }
        return $setting->update(['value' => $value]);
    }

    public function getStuffPosts()
    {
        return StuffPost::whereIn('salon_id',$this->salons->pluck('id')->all())->get();
    }

    public function getSalonPost($salon_id)
    {
        if($this->checkSalon($salon_id)){
            return $this->leftJoin('user_salon', 'user_salon.user_id', 'users.id')
                ->where('users.id', $this->id)
                ->where('user_salon.salon_id', $salon_id)
                ->leftJoin('stuff_posts', 'stuff_posts.id', 'user_salon.post_id')
                ->pluck('stuff_posts.name')
                ->first();
        }else{
            return 'Ошибка';
        }
    }

}
