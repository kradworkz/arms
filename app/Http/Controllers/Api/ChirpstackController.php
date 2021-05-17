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
        $a = \json_decode($decoded);
        $aa = \json_decode($a);

        $date = new \DateTime;
        $date->modify('-1 minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');
        $device = DeviceData::where('code',$aa->uniqueid)->where('status',$aa->status)->where('created_at','>=', $formatted_date)->count();
        
        if($device == 0){
            $wew = new DeviceData;
            $wew->coordinates = json_encode($aa->gps);
            $wew->status = $aa->status;
            $wew->code = $aa->uniqueid;
            $wew->save();

            broadcast(new AssetLocation($wew));
            return new DefaultResource($wew);
        }else{
            return '';
        }
    }

    public function test(){
        $data = "haha";
        broadcast(new AssetLocation($data));
    }
}
