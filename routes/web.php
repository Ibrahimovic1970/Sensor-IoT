<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/sensor', [SensorController::class, 'index'])->name('sensor.index');
Route::get('/sensor/create', [SensorController::class, 'create'])->name('sensor.create');
Route::post('/sensor', [SensorController::class, 'store'])->name('sensor.store');
Route::delete('/sensor/{id}', [SensorController::class, 'destroy'])->name('sensor.destroy');