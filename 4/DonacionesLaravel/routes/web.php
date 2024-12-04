<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonanteController;
use App\Http\Controllers\CampañaController;
use App\Http\Controllers\MétodoPagoController;
use App\Http\Controllers\DonacionController;

Route::get('/', function () {
    return redirect()->route('donantes.index');
});

Route::resource('donantes', DonanteController::class);
Route::resource('campañas', CampañaController::class);
Route::resource('métodospago', MétodoPagoController::class);
Route::resource('donaciones', DonacionController::class);

