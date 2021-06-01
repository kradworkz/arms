<?php

namespace App\Http\Controllers\Users\Member;

use App\Models\Location;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\LocationResource;
use App\Http\Requests\LocationRequest;

class StationController extends Controller
{
    public function index($keyword){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $member_id = \Auth::user()->member->mm->id;
        $data = Location::where('mm_id',$member_id)
        ->where('name', 'LIKE', '%'.$keyword.'%')
        ->paginate(5);
        return LocationResource::collection($data);
    }

    public function lists(){
        $data = Location::where('mm_id',\Auth::user()->member->mm->id)->get();
        return LocationResource::collection($data);
    }
    
    public function store(LocationRequest $request){
        $member_id = \Auth::user()->member->mm->id;
       
        $data = ($request->input('editable')) ? Location::findOrFail($request->input('id')) : new Location;
        $data->name = ucwords(strtolower($request->input('name')));
        $data->address = ucwords(strtolower($request->input('address')));
        $data->contact_no = $request->input('contact_no');
        $data->mm_id = $member_id; 
        $data->save();

        return new DefaultResource($data);
    }
}
