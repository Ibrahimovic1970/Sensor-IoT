<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\DeviceController;


Route::get('/', fn() => view('welcome'));

Route::get('/sensor', [SensorController::class, 'index'])->name('sensor.index');
Route::get('/sensor/create', [SensorController::class, 'create'])->name('sensor.create');
Route::post('/sensor', [SensorController::class, 'store'])->name('sensor.store');
Route::get('/sensor/{id}/edit', [SensorController::class, 'edit'])->name('sensor.edit');
Route::put('/sensor/{id}', [SensorController::class, 'update'])->name('sensor.update');
Route::delete('/sensor/{id}', [SensorController::class, 'destroy'])->name('sensor.destroy');
Route::post('/sensor/toggle-status', [SensorController::class, 'toggleStatus'])->name('sensor.toggle-status');
Route::get('/sensor/export', [SensorController::class, 'export'])->name('sensor.export');
Route::get('/device', [DeviceController::class, 'index'])->name('device.index');
Route::get('/device/create', [DeviceController::class, 'create'])->name('device.create');
Route::post('/device', [DeviceController::class, 'store'])->name('device.store');
Route::get('/device/{id}/edit', [DeviceController::class, 'edit'])->name('device.edit');
Route::put('/device/{id}', [DeviceController::class, 'update'])->name('device.update');
Route::delete('/device/{id}', [DeviceController::class, 'destroy'])->name('device.destroy');