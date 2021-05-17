<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Chirpstack;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\PacketResource;

class PacketController extends Controller
{
    public function index(){

        $data = Chirpstack::orderBy('created_at','DESC')->get();
        return PacketResource::collection($data);
    }
}
