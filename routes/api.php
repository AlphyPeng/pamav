<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::patch('/change-theme/{theme}', [ProfileController::class, 'changeTheme']);
});

require __DIR__ . '/api/auth.php';
require __DIR__ . '/api/admin.php';
