<?php

namespace App\Http\Controllers\Member;

use App\Models\AssetTracker;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;

class TrackerController extends Controller
{
    public function index($id){
        $data = AssetTracker::where('assetlist_id',$id)->paginate(5);
        return DefaultResource::collection($data);
    }

    public function store(Request $request){
        $data = new AssetTracker;
        $data->tracker_code = $request->input('trackercode');
        $data->asset_code = $request->input('assetcode');
        $data->assetlist_id = $request->input('id');
        $data->save();

        return new DefaultResource($data);
    } 

    public function count($id){
        $data = AssetTracker::where('assetlist_id',$id)->count();
        return $data;
    }
}
