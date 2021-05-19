<?php

namespace App\Http\Controllers\Member;

use App\Models\Location;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;

class LocationController extends Controller
{
    public function index($keyword){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data = Location::where('name','LIKE','%'.$keyword.'%')->paginate(10);
        return DefaultResource::collection($data);
    }

    public function lists(){
        $data = Location::where('mm_id',\Auth::user()->member->mm->id)->get();
        return DefaultResource::collection($data);
    }

    public function store(Request $request){
        $member_id = \Auth::user()->member->mm->id;
        $data = new Location;
        $data->name = ucwords(strtolower($request->input('name')));
        $data->address = ucwords(strtolower($request->input('address')));
        $data->contact_no = $request->input('contact_no');
        $data->mm_id = $member_id; 
        $data->save();

        return new DefaultResource($data);
    }
}
