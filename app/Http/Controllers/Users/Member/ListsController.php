<?php

namespace App\Http\Controllers\Users\Member;

use App\Models\AssetList;
use App\Models\AssetInfo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\ListResource;
use App\Http\Resources\ActionResource;
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
        ($request->input('trackercode') != 'n/a') ? $data->tracker_code = $request->input('trackercode') : '';
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
        $data =  AssetList::with('assetlocation.location','assetlocation.asset')->with('status')->where('asset_code', 'LIKE', '%'.$keyword.'%')
        ->orWhereHas('assetlocation', function ($query) use ($keyword){
            $query->whereHas('asset', function ($query) use ($keyword){
                $query->where('name', 'LIKE', '%'.$keyword.'%');
            });
        })
        ->paginate(10);
        return ResultResource::collection($data);
    }

    public function search2($category,$keyword){
        
        $member_id = \Auth::user()->member->mm->id;
        ($keyword == '-') ? $keyword = '' : $keyword;
        ($category == '-') ? $category = '' : $category;
        $data =  AssetList::with('assetlocation.location','assetlocation.asset')->with('status')
        ->orWhere('asset_code', 'LIKE', '%'.$keyword.'%')
        ->orWhereHas('assetlocation', function ($query) use ($keyword,$category){
            $query->whereHas('asset', function ($query) use ($keyword, $category){
                ($category != '') ? $query->where('category_id',$category) : '';
                ($keyword != '') ? $query->where('name','LIKE','%'.$keyword.'%') : '';
            });
        })
        ->paginate(10);
        return ResultResource::collection($data);
    }

    public function status(Request $request){
        $data = AssetList::where('id',$request->input('id'))->first();
        $data->status_id = $request->input('status');
        $data->save();
        return new ResultResource($data);
    }

    public function update(Request $request){

        $ids = $request->input('ids');
        $type = $request->input('type');
        $date = $request->input('date');

        foreach($ids as $id){
            $count = AssetInfo::where('asset_id',$id)->count();

            ($count == 1) ? $data = AssetInfo::where('asset_id',$id)->first() : $data = new AssetInfo;
            ($count == 0) ? $data->asset_id = $id : '';
            ($type == 'Maintenance') ? $data->maintenance = $date : $data->expiry = $date;
            $data->save();
        }

        return true;
    }

    public function check($type){

        $date = \Carbon\Carbon::now()->addDays(20)->format( 'Y-m-d' );

        if($type == 'M'){  
            $data = AssetInfo::
            with('asset:id,assetlocation_id,asset_code','asset.assetlocation:id,asset_id','asset.assetlocation.asset:id,name')
            ->where('maintenance', '<=' ,$date)->get();
        }else{
            $data = AssetInfo::
            with('asset:id,assetlocation_id,asset_code','asset.assetlocation:id,asset_id','asset.assetlocation.asset:id,name')
            ->where('expiry', '<=' ,$date)->get();
        }

        return ActionResource::collection($data);
    }
}
