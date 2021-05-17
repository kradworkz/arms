<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Asset;
use App\Models\DeviceData;
use Illuminate\Http\Request;
use App\Events\AssetLocation;
use App\Http\Resources\DefaultResource;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->type == "Administrator"){
            return view('user_admin.index');    
        }else if(Auth::user()->type == "Member"){
            return view('user_member.index');
        }else{
            return view('user_top.index');
        }
    }

    public function test(){
        // $data = '{
        //     "id" => 1,
        //     "gps" => "[123131,2313131]",
        //     "code" => "adsada",
        //     "status" => 2,
        //     "created_at" => "123131"
        // }';
        // $data = json_encode($data);
        // $test = broadcast(new AssetLocation($data));
        // $data = "{\"gps\":[6.940501,122.071357],\"status\":2,\"uniqueid\":1001}";
        // return \json_encode($data,JSON_UNESCAPED_SLASHES);

        // $data = Chirpstack::where('id',1)->first();
        

        // $json = json_decode($data->value);
        // $a = \json_decode($json);
        // return $a->gps;

        $data = "{\"gps\":[6.940501,122.071357],\"status\":2,\"uniqueid\":1001}";
        $decoded = json_encode($data);
        $a = \json_decode($decoded);
        $array = \json_decode($a);
      

        $wew = new DeviceData;
        $wew->coordinates = json_encode($array->gps);
        $wew->status = $array->status;
        $wew->code = $array->uniqueid;
        $wew->save();

        broadcast(new AssetLocation($wew));
        return '';
    }


}
