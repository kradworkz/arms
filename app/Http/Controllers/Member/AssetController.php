<?php

namespace App\Http\Controllers\Member;

use App\Models\Asset;
use App\Models\AssetList;
use App\Models\AssetPurchase;
use App\Models\AssetTracker;
use App\Models\AssetLocation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StoreImage;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\ViewResource;
use App\Http\Resources\AssetResource;
use App\Http\Requests\AssetRequest;

class AssetController extends Controller
{
    public function index($keyword){
        $member_id = \Auth::user()->member->mm->id;
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data =  AssetList::with('asset')->with('status')->with('storage')->paginate(20);
        return AssetResource::collection($data);
    }

    public function store(StoreImage $strmg, AssetRequest $request){
        
        \DB::transaction(function () use ($request,$strmg){
            $member_id = \Auth::user()->member->mm->id;
            $count = AssetList::count();

            if($request->input('editable')) // Updating thru an ID
            { 
                $data = Asset::findOrFail($request->input('id'));
                $data->name =  ucwords(strtolower($request->input('name')));
                $data->save();

            }else{
                $lists = $request->input('lists'); // Adding thru array

                if($request->input('avatar') != ''){
                    $imageName = $strmg->strmg($request->input('avatar'),strtolower($request->input('name')));
                }else{
                    ($request->input('editable')) ? $imageName = $data->avatar : $imageName = 'default.jpg';
                }

                $data = new Asset; 
                $data->name =  ucwords(strtolower($request->input('name')));
                $data->category_id = $request->input('category');
                $data->mm_id = $member_id;
                $data->image = $imageName;

                if($data->save()){
                    if(!empty($lists)){
                        $c = 0;
                        foreach($lists as $list)
                        {   
                            $cc = $count + $c;
                            $assetlist = new AssetList;
                            $assetlist->code = \Auth::user()->member->mm->member->acronym.'-'.$member_id.'-'.str_pad(($cc+1), 4, '0', STR_PAD_LEFT); 
                            $assetlist->quantity = $list['quantity'];
                            $assetlist->status_id = $list['status']['id'];
                            $assetlist->storage_id = $list['storage']['id'];
                            $assetlist->asset_id = $data->id;
                            $assetlist->save();
                            $c++;
                        }
                    }
                    return new DefaultResource($data);
                }
            }
        });
    }

    public function view($id){
        $data = Asset::with('category')->where('id',$id)->first();
        return new ViewResource($data);
    }

    public function track(Request $request){
        $data = new AssetTracker;
        $data->code = $request->input('code');
        $data->assetlist_id = $request->input('assetlist_id');
 
        return new DefaultResource($data);
    } 

    public function checkTrack($id){
        $data = AssetTracker::where('assetlist_id',$id)->count();
        return $data;
    }

    public function purchases($id){
        $data = AssetPurchase::with('vendor')
         ->where('asset_id',$id)->paginate(5);
 
         return DefaultResource::collection($data);
     }

     public function locations($id){
        $data = AssetList::where('asset_id',$id)->paginate(5);
 
        return AssetResource::collection($data);
     }
}
