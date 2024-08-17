<?php

use App\Http\Controllers\Api\V1\Company\OrderController as CompanyOrderController;
use App\Http\Controllers\Api\V1\Transporter\OrderController as TransporterOrderController;
use App\Http\Controllers\Api\V1\Transporter\TransporterController;
use App\Http\Controllers\Api\V1\Company\TransporterController as CompanyTransporterController;
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
            Route::get(""                   ,[CompanyOrderController::class, "paginate"]);
            Route::post(""                  ,[CompanyOrderController::class, "create"]);
            Route::put("/{order}/cancel"    ,[CompanyOrderController::class, "cancel"]);
            Route::get("/{order}"           ,[CompanyOrderController::class, "show"]);
        });

        Route::prefix("transporters")->group(function (){
            Route::get("/{transporter}/track-location", [CompanyTransporterController::class, "trackLocation"]);
        });
    });
});



Route::group(["prefix" => "transporters"], function (){
    Route::prefix("v1")->middleware("transporter.auth")->group(function (){
        Route::prefix("orders")->group(function (){
            Route::get("/acceptable"            ,[TransporterOrderController::class, "acceptablePaginate"]);
            Route::post("/{order}/accept"       ,[TransporterOrderController::class, "accept"]);
            Route::put("/{order}/change-status" ,[TransporterOrderController::class, "changeStatus"]);
            Route::get("/{order}"               ,[TransporterOrderController::class, "show"]);
        });

        Route::post("/track-location", [TransporterController::class , "storeTrackLocation"]);
    });
});
