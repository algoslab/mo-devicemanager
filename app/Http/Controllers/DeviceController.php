<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DeviceController extends Controller
{
    public function index(){
        return view('device-manager.index');
    }

    public function deviceSaveUpdate(Request $request){
        $validated = $request->validate([
            'serial' => 'required|string',
            'name' => 'required|string',
            'phone' => 'required|string',
            'validity' => 'required|string',
        ]);
        // Save to database
        $device = Device::create($validated);

        return response()->json(['success' => true]);
    }

    public function showDevice(){
        $model = Device::orderBy('id', 'desc')->get();
        return  DataTables::of($model)
                ->addColumn('action', function($row){
                    return 'action';
                })
                ->escapeColumns([])
                ->make(true);
    }
}
