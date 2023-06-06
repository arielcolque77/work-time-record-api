<?php

namespace App\Modules\Workers\Http\Routes;

use App\Modules\Workers\Http\Controllers\WorkerController;
use Illuminate\Support\Facades\Route;

Route::controller(WorkerController::class)->group(function () {
    Route::prefix('workers')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'delete');
    });
});
