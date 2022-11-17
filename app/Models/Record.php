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

    /**
     * @return HasOne
     */
    public function time()
    {
        return $this->hasOne(Time::class, 'id', 'time_id');
    }

    public function service()
    {
        return $this->hasOne(Service::class, 'id', 'service_id');
    }

    public function status()
    {
        return $this->hasOne(RecordStatus::class, 'id', 'record_status_id');
    }
}
