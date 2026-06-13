<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginWebController;

Route::get('/login', [LoginWebController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginWebController::class, 'login']);

Route::middleware(['web.auth'])->group(function () {
    Route::get('/dashboard', [LoginWebController::class, 'dashboard']);
    Route::get('/logout', [LoginWebController::class, 'logout']);
    Route::post('/convert', [LoginWebController::class, 'convert']);
});

Route::get('/', function () {
    return response()->json([
        'app'   => 'Multi-Currency Payment API',
        'version' => '1.0',
        'status'  => 'running',
    ]);
});
