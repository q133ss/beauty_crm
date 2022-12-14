<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function workDays()
    {
        return json_decode($this->work_days);
    }

    public function workTime()
    {
        return $this->hasMany(WorkTime::class, 'salon_id', 'id');
    }

    public function getWorkTime($day_id)
    {
        return $this->workTime->where('day_id', $day_id)->first();
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'salon_id', 'id');
    }

    public function records()
    {
        return $this->hasMany(Record::class, 'salon_id', 'id');
    }

    public function employees()
    {
        return $this->belongsToMany(User::class, 'user_salon');
    }
}
