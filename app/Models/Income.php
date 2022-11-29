<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    public function getDate()
    {
        return Carbon::parse($this->date)->format('d-m-Y');
    }

    public static function takeLastMonth($user_id)
    {
        return self::where('user_id', $user_id)->where('date', '>', now()->subMonth())->get();
    }

    public static function groupByMonth($user_id)
    {
        return self::orderBy('date','DESC')
        ->get()
            ->groupBy(function($incomes) {
                return Carbon::parse($incomes->date)->format('m-Y'); // А это то-же поле по нему мы и будем группировать
            });
    }

    public static function getMonth($number){
        $months = [
            '01' => 'Январь',
            '02' => 'Февраль',
            '03' => 'Март',
            '04' => 'Апрель',
            '05' => 'Май',
            '06' => 'Июнь',
            '07' => 'Июль',
            '08' => 'Август',
            '09' => 'Сентябрь',
            '10' => 'Октябрь',
            '11' => 'Ноябрь',
            '12' => 'Декабрь'
        ];

        return $months[$number];
    }
}
