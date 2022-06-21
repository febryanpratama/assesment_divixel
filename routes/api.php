<?php

use App\Http\Controllers\OrderController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(OrderController::class)->group(function () {
    Route::prefix('ordered-qty')->group(function () {
        Route::get('/', 'orderQty');
        Route::post('/', 'AddorderQty');
    });

    Route::prefix('current-qty')->group(function () {
        Route::get('/');
        Route::post('/', 'AddCurrentQty');
    });
});
// Route::get('order_qty')
