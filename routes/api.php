<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TimeSlotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'auth'
    ],
    function ($router) {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
    }
);

Route::group(
    [
        'prefix' => 'booking'
    ],
    function ($router) {
        $router->get('/{booking}', [BookingController::class, 'getBooking']);
        $router->get('/', [BookingController::class, 'getAll']);
        $router->post('/', [BookingController::class, 'create']);
    }
);

Route::group(
    [
        'prefix' => 'timeslot'
    ],
    function ($router) {
        $router->get('/', [TimeSlotController::class, 'getAll']);
    }
);
