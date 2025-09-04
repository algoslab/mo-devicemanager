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

    public function renewDevice(Request $request){
        $validated = $request->validate([
            'update_id' => 'required|string',
            'validity' => 'required|string',
        ]);
        // Save to database
        Device::updateOrCreate(
            [ 'id' => $validated['update_id'] ],  // search condition
            [ 'validity' => $validated['validity']] // values to insert or update
        );
        return response()->json(['success' => true]);
    }

    

    public function showDevice(){
        $model = Device::orderBy('id', 'desc')->get();
        return  DataTables::of($model)
                ->addColumn('action', function($row){
                    $html = "<select >
                            <option value='0'>SELECT</option>
                            <option  value='1'>Edit</option>
                            <option onclick=\"fillForm($row->id,$row->serial, '$row->validity')\" data-bs-toggle='modal' data-bs-target='#renewModal' value='2'>Renew</option>
                            <option value='3'>Delete</option>
                        </select>";
                    return $html;
                })
                ->escapeColumns([])
                ->make(true);
    }
}
