<?php

namespace App\Http\Controllers;

use App\Models\AssetList;
use App\Models\Dropdown;
use Illuminate\Http\Request;
use App\Http\Resources\ListResource;
use App\Http\Resources\PubResource;
use App\Http\Resources\DropdownResource;
use App\Http\Resources\DefaultResource;

class PublicController extends Controller
{
    public function index($id,$keyword){
        ($keyword == '-') ? $keyword = '' : $keyword;
    
        $query = AssetList::query();
        $query = $query->with('status')->with(['assetlocation.asset','assetlocation.location'])->where('asset_code', 'LIKE', '%'.$keyword.'%')->where('coordinates','!=',NULL);
        if($id != '-'){
            $query = $query->whereHas('assetlocation', function ($query) use ($id){
                $query->whereHas('asset', function ($query) use ($id){
                    $query->where('category_id',$id);
                });
            });
        }
        $data = $query->get();

        return ListResource::collection($data);
    }

    public function status(){
        $data = Dropdown::where('type','Asset')->where('classification','Status')->get();
        return PubResource::collection($data);
    }

    public function category(){
        $data = Dropdown::where('classification','Category')->get();
        return DropdownResource::collection($data);
    }
}
