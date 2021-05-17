<?php

namespace App\Http\Controllers\Administrator;

use App\Models\DeviceData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\PacketResource;

class PacketController extends Controller
{
    public function index(){

        $data = DeviceData::orderBy('created_at','DESC')->get();
        return PacketResource::collection($data);
    }
}
