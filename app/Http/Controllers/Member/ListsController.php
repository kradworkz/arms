<?php

namespace App\Http\Controllers\Member;

use App\Models\AssetList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\ListResource;
use App\Http\Requests\TrackerRequest;

class ListsController extends Controller
{
    public function index($id){

        $data = AssetList::with('status')->where('assetlocation_id',$id)->paginate(10);
        return ListResource::collection($data);
    }

    public function store(TrackerRequest $request){
        $data = AssetList::where('id',$request->input('id'))->first();
        $data->tracker_code = $request->input('trackercode');
        $data->save();

        return new DefaultResource($data);
    } 

    public function coordinates($id){
        $data = AssetList::select('coordinates')->where('id',$id)->first();
        return $data;
    }
}
