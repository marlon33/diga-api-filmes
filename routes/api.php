<?php

use App\Http\Controllers\UserControler;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TagController;
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
Route::get("/movie/list",[MovieController::class,"listMovies"]);
Route::put("/movie/update",[MovieController::class,"update"]);

Route::post("/tag/create",[TagController::class,"store"]);


Route::get("/authTest",[UserControler::class,"authTest"]);
