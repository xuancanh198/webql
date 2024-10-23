<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Room\TypeRoomController;
use App\Http\Controllers\Admin\Staff\AuthController;;
Route::middleware(['admin.middleware'])->group(function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::post('/login', [AuthController::class, 'login']);
            Route::group(['prefix' => 'room'], function () {
                Route::apiResource('/typeRoom', TypeRoomController::class)->except(['show']);
            });
        });
});
