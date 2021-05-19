<?php

namespace App\Http\Controllers\Api;

use App\Models\DeviceData;
use App\Models\AssetTracker;
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
        $tracker_id= json_encode($obj->devEUI);
        $decoded = json_encode($obj->objectJSON);
        $a = \json_decode($decoded);
        $aa = \json_decode($a);

        $date = new \DateTime;
        $date->modify('-1 minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');
        $device = DeviceData::where('code',$tracker_id)->where('status',$aa->status)->where('created_at','>=', $formatted_date)->count();
        
        if($device == 0){
            $wew = new DeviceData;
            $wew->coordinates = json_encode($aa->gps);
            $wew->status = $aa->status;
            $wew->code = $tracker_id;
            $wew->save();

            broadcast(new AssetLocation($wew));

            $data = AssetTracker::where('code',$aa->uniqueid)->first();
            $data->coordinates =  json_encode($aa->gps);
            $data->status = $aa->status;
            $data->save();

            return true;
            
        }else{
            return true;
        }
    }

    public function test(){
        $data = "haha";
        broadcast(new AssetLocation($data));
    }
}
