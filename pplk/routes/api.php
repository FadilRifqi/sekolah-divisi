<?php

use App\Http\Controllers\User\UserController;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//crud user
Route::get('/user', [UserController::class,"getAll"]);
Route::get('/user/{id}', [UserController::class , 'get']);
Route::post('/user', [UserController::class ,'store']);
Route::put('/user/{id}', [UserController::class,'update']);
Route::delete('/user/{id}', [UserController::class,'delete']);


