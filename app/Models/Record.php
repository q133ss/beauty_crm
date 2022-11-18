<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Record extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeWithFilter($query, $filter = 1)
    {
        $filters = [
            'all',
            'processed'
        ];
        if(!in_array($filter, $filters)){
            $query->where('record_status_id', $filter)->orderBy('date', 'DESC');
        }elseif($filter == 'all'){
            $query->orderBy('date','DESC');
        }elseif($filter == 'processed'){
            $query->where('record_status_id', '!=', 1)->orderBy('date', 'DESC');
        }
        return $query;
    }

    /**
     * @return HasOne
     */
    public function client()
    {
        return $this->hasOne(User::class, 'id', 'client_id');
    }

    public function service()
    {
        return $this->hasOne(Service::class, 'id', 'service_id');
    }

    public function status()
    {
        return $this->hasOne(RecordStatus::class, 'id', 'record_status_id');
    }

    public function timeFormatted()
    {
        return mb_substr($this->time, 0, 5);
    }

    public function date()
    {
        $months = [
            1 => 'января',
            2 => 'февраля',
            3 => 'марта',
            4 => 'апреля',
            5 => 'мая',
            6 => 'июня',
            7 => 'июля',
            8 => 'августа',
            9 => 'сентября',
            10 => 'октября',
            11 => 'ноября',
            12 => 'декабря'
        ];

        $day = Carbon::parse($this->date)->format('j');
        $month = Carbon::parse($this->date)->format('m');
        $year = Carbon::parse($this->date)->format('Y');

        return $day.' '.$months[$month].' '.$year;
    }

    public function getDate()
    {
        $day = Carbon::parse($this->date)->format('d');
        $month = Carbon::parse($this->date)->format('m');
        $year = Carbon::parse($this->date)->format('Y');
        return $day .'.'. $month .'.'. $year;
    }
}
