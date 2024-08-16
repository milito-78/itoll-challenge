<?php

use App\Http\Controllers\Api\V1\Company\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('transporter.auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["prefix" => "companies"], function (){
    Route::prefix("v1")->middleware("company.auth")->group(function (){
        Route::prefix("orders")->group(function (){
            Route::get("",[OrderController::class, "paginate"]);
            Route::post("",[OrderController::class, "create"]);
            Route::put("/{order}/cancel",[OrderController::class, "cancel"]);
            Route::get("/{order}",[OrderController::class, "show"]);
        });
    });
});



Route::group(["prefix" => "transporters"], function (){
    Route::prefix("v1")->middleware("transporter.auth")->group(function (){
    });
});
