<?php

namespace App\Http\Controllers\Api;

use App\Models\Chirpstack;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;

class ChirpstackController extends Controller
{
    public function index(){
        header("Content-type: application/json");
        $json = file_get_contents("php://input");

        $obj = json_decode($json);

        $decoded = base64_decode(json_encode($obj->data));


        $data = new Chirpstack;
        $data->value = $decoded;
        $data->save();

        return new DefaultResource($data);
        
    }
}
