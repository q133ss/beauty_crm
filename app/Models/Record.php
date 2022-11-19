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
            '01' => 'января',
            '02' => 'февраля',
            '03' => 'марта',
            '04' => 'апреля',
            '05' => 'мая',
            '06' => 'июня',
            '07' => 'июля',
            '08' => 'августа',
            '09' => 'сентября',
            '10' => 'октября',
            '11' => 'ноября',
            '12' => 'декабря'
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

    public function salon()
    {
        return $this->hasOne(Salon::class, 'id', 'salon_id');
    }

    public function checkUser()
    {
        //Получаем слон
        //Проверяем юзера на принадлежность к салону
        //и все
        return $this->join('salons','salons.id','records.salon_id')
                    ->where('records.id', $this->id)
                    ->join('user_salon', 'user_salon.salon_id', 'salons.id')
                    ->where('user_salon.user_id', Auth()->id())
                    ->exists();
    }
}
