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
        return $this->hasOne(WorkTime::class, 'salon_id', 'id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'salon_id', 'id');
    }

    public function records()
    {
        return $this->hasMany(Record::class, 'salon_id', 'id');
    }
}
