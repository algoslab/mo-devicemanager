<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device; // Replace with your model
use App\Models\ExpiryMessage;
use Carbon\Carbon;

class DeviceManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function checkValidity($serial)
    {
        $device = Device::where('serial', $serial)->first();

        if ($device) {
            $createdAt = Carbon::parse($device->created_at);
            $validityInYears = (int) $device->validity;

            if($device->validity == 'লাইফটাইম'){
                $daysRemaining = 1; // 1 because $daysRemaining more than 1 = true, valids
            }else{
                $expiryDate = $createdAt->copy()->addYears($validityInYears);
                $daysRemaining = Carbon::now()->diffInDays($expiryDate, false); // false = can be negative
            }

            if($daysRemaining <= 0 ){
                $expiry = ExpiryMessage::find(1);
                $message = str_replace('{name}', $device->name, $expiry->message);
            }else{
                $message = true;
            }
            return response()->json([
                'message' => $message
            ]);
        } else {
            return response()->json([
                'message' => 'Device not found'
            ], 404);
        }


    }

    

}
