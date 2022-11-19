<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        'role_id'
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
}
