<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PersonneController;

Route::get('/', function () {
    return view('welcome');
});


Route::apiResource('personnes', PersonneController::class);
//OR
// Route::prefix('personnes')->group(function () {
//     Route::get('/', [PersonneController::class, 'index']);
//     Route::post('/', [PersonneController::class, 'store']);
//     Route::get('/{id}', [PersonneController::class, 'show']);
//     Route::put('/{id}', [PersonneController::class, 'update']);
//     Route::delete('/{id}', [PersonneController::class, 'destroy']);
// });
