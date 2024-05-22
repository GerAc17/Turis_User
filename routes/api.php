<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ViajesController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::controller(ViajesController::class)->group(function () {
    Route::get('/viajes', 'index');
    Route::post('/viaje', 'store');
    Route::put('/viaje/{id}', 'update');
    Route::delete('/viaje/{id}', 'destroy');
    Route::get('/viaje/create', 'create');
    Route::post('/viajes/get-view', 'show_viajes');
    Route::get('/viaje/inscribirse/{id}', 'subscribe');
    Route::get('/viaje/desinscribirse/{id}/{nombreUsuario}', 'unsubscribe');
    Route::post('/viaje/confirmar-desinscripcion', 'confirm_unsubscribe');
    Route::post('/viaje/append-viajero', 'append_viajero');
    Route::get('/viaje/edit/{id}', 'edit');
    Route::post('/viaje/update', 'show_update');
    Route::post('/viaje/create', 'show_create');
    Route::get('/viaje/delete/{id}', 'confirm_delete');
    Route::post('/viaje/delete', 'destroy_viaje');
});