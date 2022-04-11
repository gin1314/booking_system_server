<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\WebhooksController;
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
        $router
            ->get('/{booking}', [BookingController::class, 'getBooking'])
            ->where('booking', '[0-9]+');
        $router
            ->get('/', [BookingController::class, 'getAll'])
            ->middleware(['auth:api']);
        $router
            ->post('/', [BookingController::class, 'create']);
        // ->middleware(['auth:api']);

        $router
            ->post('/confirm/{booking}', [
                BookingController::class,
                'confirmBooking'
            ])
            ->where('booking', '[0-9]+');

        $router
            ->post('/complete/{booking}', [
                BookingController::class,
                'completeBooking'
            ])
            ->where('booking', '[0-9]+');

        $router
            ->post('/assign/{booking}', [
                BookingController::class,
                'assignBooking'
            ])
            ->where('booking', '[0-9]+');

        $router
            ->post('/cancel/{booking}', [
                BookingController::class,
                'cancelBooking'
            ])
            ->where('booking', '[0-9]+');
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

Route::group(
    [
        'prefix' => 'user'
    ],
    function ($router) {
        $router->get('/', [Usercontroller::class, 'getAll']);
        $router
            ->post('/', [Usercontroller::class, 'create']);

        $router
            ->put('/{user}', [
                Usercontroller::class,
                'update'
            ])
            ->where('user', '[0-9]+');

        $router
            ->delete('/{user}', [
                Usercontroller::class,
                'delete'
            ])
            ->where('user', '[0-9]+');
    }
);

Route::group(
    [
        'prefix' => 'files'
    ],
    function ($router) {
        // $router
        //     ->get('/dock-receipt/{dockReceipt}', [
        //         FileController::class,
        //         'findFilesByDockReceipt'
        //     ])
        //     ->middleware(['auth:api']);

        // $router
        //     ->delete('{file}', [
        //         FileController::class,
        //         'deleteFile'
        //     ])
        //     ->middleware(['auth:api'])
        //     ->where('file', '[0-9]+');

        // $router
        //     ->get('/bol/{bol}', [FileController::class, 'findFilesByBol'])
        //     ->middleware(['auth:api']);

        $router
            ->post('/booking/{booking}/upload', [
                FileController::class,
                'addBookingFile'
            ])
            ->middleware(['auth:api']);

        // $router
        //     ->post('/bol/{bol}/upload', [FileController::class, 'addBolFile'])
        //     ->middleware(['auth:api']);

        // $router
        //     ->post('/avatar/{user}/upload', [
        //         FileController::class,
        //         'addAvatarFile'
        //     ])
        //     ->middleware(['auth:api']);
    }
);

Route::group(
    [
        'prefix' => 'invoices'
    ],
    function ($router) {
        $router
            ->post('/gcash/create/{booking}', [
                InvoiceController::class,
                'create'
            ])
            ->where('booking', '[0-9]+');
    }
);

Route::group(
    [
        'prefix' => 'webhooks'
    ],
    function ($router) {
        $router
            ->post('/gcash/success', [
                WebhooksController::class,
                'gcashSuccess'
            ]);

        $router
            ->post('/gcash/fail', [
                WebhooksController::class,
                'gcashFail'
            ]);
    }
);
