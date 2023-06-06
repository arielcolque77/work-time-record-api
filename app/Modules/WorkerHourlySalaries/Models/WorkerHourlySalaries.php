<?php

namespace App\Modules\WorkerHourlySalaries\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkerHourlySalaries extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'worker_id',
        'salary',
        'since',
    ];


    public function worker()
    {
        return $this->hasOne(\App\Modules\Workers\Models\Workers::class, "id", "worker_id");
    }
}
