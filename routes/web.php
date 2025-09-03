<?php

use App\Http\Controllers\DeviceController;
use Illuminate\Support\Facades\Route;

Route::get('/device-manager', [DeviceController::class, 'index']);
Route::post('/device-save-update', [DeviceController::class, 'deviceSaveUpdate'])->name('deviceSaveUpdate');

