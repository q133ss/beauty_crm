<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function workTime()
    {
        return mb_substr($this->work_time, 0, 5);
    }

    /**
     * Возвращает услуги для определенного салона/салонов
     * @param array $salon_ids
     * @return mixed
     */
    public static function getForSalon(array $salon_ids)
    {
        return self::whereIn('salon_id', $salon_ids);
    }
}
