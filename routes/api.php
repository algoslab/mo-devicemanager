<?php 

use App\Http\Controllers\Api\DeviceManagerController;
use Illuminate\Support\Facades\Route;


Route::post('check-validity/{serial}', [DeviceManagerController::class, 'checkValidity']);
