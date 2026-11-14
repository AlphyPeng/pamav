
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

// Login route
Route::post('/login', [AuthController::class, 'login']);

// Vue SPA fallback
Route::get('{any?}', function () {
    return view('application');
})->where('any', '.*');
