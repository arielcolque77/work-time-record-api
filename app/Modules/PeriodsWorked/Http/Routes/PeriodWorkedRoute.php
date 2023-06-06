<?php

namespace App\Modules\PeriodsWorked\Http\Routes;

use App\Modules\PeriodsWorked\Http\Controllers\PeriodWorkedController;
use Illuminate\Support\Facades\Route;

Route::controller(PeriodWorkedController::class)->group(function () {
    Route::prefix('periods-worked')->group(function () {
        Route::get('/', 'index');
        Route::get('/worker/{worker_id}', 'indexByWorker');
        Route::post('/', 'store');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'delete');
    });
});
