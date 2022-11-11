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

    public function scopeWithFilter($query, $filter = 'is_actual')
    {
        switch ($filter) {
            case 'is_actual':
                $query->where('date', '>=', Carbon::now())->orderBy('date', 'DESC');
            default:
                $query->orderBy('date', 'DESC');
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

    /**
     * @return HasOne
     */
    public function time()
    {
        return $this->hasOne(Time::class, 'id', 'time_id');
    }

    public function isView()
    {
        if($this->view == true)
            return true;

        return false;
    }
}
