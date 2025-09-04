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

        Device::updateOrCreate(
                [ 'id' => $request->update_id ],  // search condition
                $validated // values to insert or update
            );

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

    public function deviceDelete(Request $request){
        $device = Device::find($request->id);

        if ($device) {
            $device->delete();
        }
    }

    

    public function showDevice(){
        $model = Device::orderBy('id', 'desc')->get();
        return  DataTables::of($model)
                ->editColumn('phone', function($row){
                    return "$row->phone ✔";
                })
                ->editColumn('validity', function($row){
                    if($row->validity=='লাইফটাইম'){
                        $validity = $row->validity;
                    }else{
                        $validity = $row->validity." বছর";
                    }
                    return $validity;
                })
                ->addColumn('action', function($row){
                    $html = "<select class='form-select form-select-sm bg-info'>
                            <option value='0'>Action</option>
                            <option value='1' onclick=\"editForm($row->id,'$row->serial', '$row->validity', '$row->phone', '$row->name')\" data-bs-toggle='modal' data-bs-target='#addDeviceModal'>Edit</option>
                            <option value='2' onclick=\"fillForm($row->id,'$row->serial', '$row->validity')\" data-bs-toggle='modal' data-bs-target='#renewModal' >Renew</option>
                            <option value='3' onclick=\"deviceDelete($row->id)\">Delete</option>
                        </select>";
                    return $html;
                })
                ->escapeColumns([])
                ->make(true);
    }
}
