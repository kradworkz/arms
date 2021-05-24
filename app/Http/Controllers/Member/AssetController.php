<?php

namespace App\Http\Controllers\Member;

use App\Models\Asset;
use App\Models\AssetList;
use App\Models\AssetLocation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StoreImage;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\ViewResource;
use App\Http\Resources\AssetResource;
use App\Http\Resources\ListResource;
use App\Http\Requests\AssetRequest;

class AssetController extends Controller
{
    public function index($keyword){
        $member_id = \Auth::user()->member->mm->id;
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data =  AssetLocation::with('asset')->with('location')
        ->whereHas('asset', function ($query) use ($keyword){
            $query->where('name', 'LIKE', '%'.$keyword.'%');
        })
        ->orWhereHas('location', function ($query) use ($keyword){
            $query->where('name', 'LIKE', '%'.$keyword.'%');
        })
        ->paginate(5);
        return AssetResource::collection($data);
    }

    public function store(StoreImage $strmg, AssetRequest $request){
        \DB::transaction(function () use ($request,$strmg){
            $member_id = \Auth::user()->member->mm->id;

            $data = new Asset; 
            $data->name =  ucwords(strtolower($request->input('name')));
            $data->category_id = $request->input('category');
            $data->mm_id = $member_id;
            $data->image = ($request->input('avatar') != '') ? $strmg->strmg($request->input('avatar'),strtolower($request->input('name'))) : 'default.jpeg';

            if($data->save()){
                $this->locations($request);
                return new DefaultResource($data);
            }
            
        });
    }

    public function locations(Request $request){
        $id = ($request->input('id') == '') ? \DB::getPdo()->lastInsertId() : $request->input('id');
        $lists = $request->input('lists'); 

        foreach($lists as $list)
        {   
            $location = new AssetLocation;
            $location->quantity = $list['quantity'];
            $location->location_id = $list['location']['id'];
            $location->asset_id = $id;
            if($location->save()){
                if($request->input('trackable')){
                   $this->lists($location->id,$list['quantity']);
                }
            }
        }
        return true;
    }

    public function lists($id,$quantity){
        $count = AssetLocation::where('id',$id)->count();
        for($count+1; $count<=$quantity; $count++){
            $data = new AssetList;
            $data->asset_code = \Auth::user()->member->mm->member->acronym.'-'.$id.'-'.str_pad(($count), 4, '0', STR_PAD_LEFT); ;
            $data->assetlocation_id = $id;
            $data->status_id = 1;
            $data->save();
        }
        return true;
    }

    public function view($id){
        $data = AssetLocation::with('asset')->where('id',$id)->first();
        return new ViewResource($data);
    }

    public function status(Request $request){
        $data = AssetList::where('id',$request->input('id'))->first();
        $data->status_id = $request->input('status');
        $data->save();
        return new ListResource($data);
    }

}
