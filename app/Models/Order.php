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
}
