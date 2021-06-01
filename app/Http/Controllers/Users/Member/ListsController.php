<?php

namespace App\Http\Controllers\Users\Member;

use App\Models\AssetList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\ListResource;
use App\Http\Resources\ResultResource;
use App\Http\Requests\TrackerRequest;

class ListsController extends Controller
{
    public function index($id,$keyword){
        $member_id = \Auth::user()->member->mm->id;
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data = AssetList::with('status')->where('assetlocation_id',$id)
        ->where(function ($query) use ($keyword){
            $query ->where('asset_code', 'LIKE', '%'.$keyword.'%')->orWhere('tracker_code', 'LIKE', '%'.$keyword.'%');
        })
        ->paginate(10);
        return ListResource::collection($data);
    }

    public function store(TrackerRequest $request){
        $data = AssetList::where('id',$request->input('id'))->first();
        $data->tracker_code = $request->input('trackercode');
        $data->asset_code = $request->input('assetcode');
        $data->save();

        return new DefaultResource($data);
    } 

    public function coordinates($id){
        $data = AssetList::select('coordinates')->where('id',$id)->first();
        return $data;
    }

    public function search($keyword){
        $member_id = \Auth::user()->member->mm->id;
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data =  AssetList::with('status')->where('asset_code', 'LIKE', '%'.$keyword.'%')
        ->orWhereHas('assetlocation', function ($query) use ($keyword){
            $query->whereHas('asset', function ($query) use ($keyword){
                $query->where('name', 'LIKE', '%'.$keyword.'%');
            });
        })
        ->paginate(3);
        return ResultResource::collection($data);
    }

    public function status(Request $request){
        $data = AssetList::where('id',$request->input('id'))->first();
        $data->status_id = $request->input('status');
        $data->save();
        return new ResultResource($data);
    }
}
