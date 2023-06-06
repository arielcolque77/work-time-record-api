<?php

namespace App\Modules\PeriodsWorked\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeriodsWorked extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'periods_worked';
    protected $fillable = [
        'worker_id',
        'start_time',
        'end_time',
    ];


    public function worker()
    {
        return $this->hasOne(\App\Modules\Workers\Models\Workers::class, "id", "worker_id");
    }
}
