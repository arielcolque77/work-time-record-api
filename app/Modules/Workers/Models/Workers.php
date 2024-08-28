<?php

namespace App\Modules\Workers\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workers extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'color', 'code'];

    public function periodsWorked()
    {
        return $this->hasMany(\App\Modules\PeriodsWorked\Models\PeriodsWorked::class, "worker_id", "id");
    }
}
