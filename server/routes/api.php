<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Room\TypeRoomController;
use App\Http\Controllers\Admin\Room\FloorController;
use App\Http\Controllers\Admin\Room\ServiceController;
use App\Http\Controllers\Admin\Staff\AuthController;;
Route::middleware(['admin.middleware'])->group(function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::post('/login', [AuthController::class, 'login']);
            Route::group(['prefix' => 'room'], function () {
                Route::group(['prefix' => 'typeRoom'], function () {
                    Route::get('/', [TypeRoomController::class, 'index']);
                    Route::post('/', [TypeRoomController::class, 'store']);
                    Route::put('/{id}', [TypeRoomController::class, 'update']);
                    Route::delete('/{id}', [TypeRoomController::class, 'destroy']);
                });
                Route::group(['prefix' => 'floor'], function () {
                    Route::get('/', [FloorController::class, 'index']);
                    Route::post('/', [FloorController::class, 'store']);
                    Route::put('/{id}', [FloorController::class, 'update']);
                    Route::delete('/{id}', [FloorController::class, 'destroy']);
                });
                Route::group(['prefix' => 'service'], function () {
                    Route::get('/', [ServiceController::class, 'index']);
                    Route::post('/', [ServiceController::class, 'store']);
                    Route::put('/{id}', [ServiceController::class, 'update']);
                    Route::delete('/{id}', [ServiceController::class, 'destroy']);
                });
            });
        });
});
