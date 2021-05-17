<?php

namespace App\Http\Controllers\Api;

use App\Models\DeviceData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\PacketResource;
use App\Events\AssetLocation;

class ChirpstackController extends Controller
{
    public function index(){
        header("Content-type: application/json");
        $json = file_get_contents("php://input");

        $obj = json_decode($json);
        $decoded = json_encode($obj->objectJSON);
        $array = \json_decode($decoded);

        $data = new DeviceData;
        $data->random = 'rmdno';
        $data->coordinates = $array->gps;
        $data->status = $array->status;
        $data->code = $array->uniqueid;
        $data->save();

        broadcast(new AssetLocation($data));
        return new DefaultResource($data);
    }

    public function test(){
        $data = "haha";
        broadcast(new AssetLocation($data));
    }
}
