<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'app'   => 'Multi-Currency Payment API',
        'version' => '1.0',
        'status'  => 'running',
    ]);
});
