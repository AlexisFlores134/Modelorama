<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\MercanciaController;
use App\Http\Controllers\Api\LoginController;
Route::post('login', [LoginController::class, 'store']);

Route::options('{all:.*}', function () {
    return response()->json();
});

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('categorias', CategoriaController::class);
    Route::apiResource('mercancias', MercanciaController::class);
});

/*
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
*/
