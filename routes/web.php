<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Sensor CRUD + Fitur Tambahan
Route::get('/sensor', [SensorController::class, 'index'])->name('sensor.index');
Route::get('/sensor/create', [SensorController::class, 'create'])->name('sensor.create');
Route::post('/sensor', [SensorController::class, 'store'])->name('sensor.store');
Route::get('/sensor/{id}/edit', [SensorController::class, 'edit'])->name('sensor.edit');
Route::put('/sensor/{id}', [SensorController::class, 'update'])->name('sensor.update');
Route::delete('/sensor/{id}', [SensorController::class, 'destroy'])->name('sensor.destroy');

// Fitur Baru
Route::get('/sensor/export', [SensorController::class, 'export'])->name('sensor.export');
Route::post('/sensor/toggle-status', [SensorController::class, 'toggleStatus'])->name('sensor.toggle-status');