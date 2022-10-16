<?php

use App\Http\Controllers\UserControler;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::get("/",function(){
    return response()->json([
        'data' => '',
        'message' => "DIGA API v1, running",
        'status' => 200
    ]);
});

Route::post("/register",[UserControler::class,"register"]);
Route::post("/login",[UserControler::class,"login"]);

Route::post("/movie/create",[MovieController::class,"store"]);


Route::get("/authTest",[UserControler::class,"authTest"]);
