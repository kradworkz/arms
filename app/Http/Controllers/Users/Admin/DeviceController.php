<?php

namespace App\Http\Controllers\Users\Admin;

use App\Models\Device;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\DeviceResource;
use App\Http\Requests\DeviceRequest;

class DeviceController extends Controller
{
    public function index($keyword){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data = Device::where('station', 'LIKE', '%'.$keyword.'%')->paginate(5);
        return DeviceResource::collection($data);
    }

    public function store(DeviceRequest $request){

        $data = new Device;
        $data->station =  ucwords(strtolower($request->input('station')));
        $data->coordinates = $request->input('coordinates');
        $data->data_logger = $request->input('datalogger');
        $data->remarks = $request->input('remarks');
        $data->type_id = $request->input('type');
        $data->status_id = $request->input('status');
        $data->municipality_id = $request->input('municipality');
        $data->save();

        return new DeviceResource($data);
    }
}
