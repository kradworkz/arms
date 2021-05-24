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
        $data = AssetList::where('id',$request->input('id'));
        $data->tracker_code = $request->input('trackercode');
        $data->save();

        return new DefaultResource($data);
    } 

    public function count($id){
        $data = AssetTracker::where('assetlist_id',$id)->count();
        return $data;
    }

    public function coordinates($id){
        $data = AssetTracker::select('coordinates')->where('id',$id)->first();
        return $data;
    }
}
