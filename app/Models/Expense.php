<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $guarded = [];

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
}
