<?php

use App\Http\Controllers\DeviceController;
use Illuminate\Support\Facades\Route;

Route::get('/device-manager', [DeviceController::class, 'index']);
Route::post('/device-save-update', [DeviceController::class, 'deviceSaveUpdate'])->name('deviceSaveUpdate');
Route::post('/device-renew', [DeviceController::class, 'renewDevice'])->name('renewDevice');
Route::post('/device-delete', [DeviceController::class, 'deviceDelete'])->name('deviceDelete');

Route::get('/device-show', [DeviceController::class, 'showDevice'])->name('showDevice');


