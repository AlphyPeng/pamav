<?php

use Illuminate\Support\Facades\Route;

Route::get('{any?}', function () {
    return view('application');
})->where('any', '.*');

use App\Http\Controllers\Auth\AuthController;

Route::post('/login', [AuthController::class, 'login']);
