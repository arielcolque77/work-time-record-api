<?php

namespace App\Modules\WorkerHourlySalaries\Http\Routes;

use App\Modules\WorkerHourlySalaries\Http\Controllers\WorkerHourlySalaryController;
use Illuminate\Support\Facades\Route;

Route::controller(WorkerHourlySalaryController::class)->group(function () {
    Route::prefix('hourly-salary')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('{id}', 'show');
        Route::get('worker/{workerId}', 'showCurrentByWorker');
        Route::get('months/worker/{workerId}', 'getMonthlyPrice');
        Route::get('months/worker/{workerId}/year', 'getMonthlyPriceByYear');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'delete');
    });
});
