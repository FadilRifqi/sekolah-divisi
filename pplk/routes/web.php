<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return response()->json([
        "nama"=>"Fadil",
        "umur"=>17
    ], 200);
});

Route::post('/user', [UserController::class,'post']);