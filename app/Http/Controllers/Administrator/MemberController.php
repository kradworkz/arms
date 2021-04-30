<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Member;
use App\Models\MemberMunicipality;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StoreImage;
use App\Http\Resources\DefaultResource;

class MemberController extends Controller
{
    public function index($keyword){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data =  Member::where('name','LIKE','%'.$keyword.'%')->paginate(10);
        return DefaultResource::collection($data);
    }

    public function list(){
        $data =  Member::get();
        return DefaultResource::collection($data);
    }

    public function store(StoreImage $strmg, Request $request){

        $data = ($request->input('editable')) ? Member::findOrFail($request->input('id')) : new Member;
        $data->name  = ucwords($request->input('name'));
        $data->acronym = strtoupper($request->input('acronym'));
        $data->type = 'Agency';
        if($data->save()){
            $name = strtolower($request->input('acronym')).'-'.$data->id;
            if($request->input('avatar') != ''){
                $imageName = $strmg->strmg($request->input('avatar'),$name);
            }else{
                ($request->input('editable')) ? $imageName = $data->Member->avatar : $imageName = 'avatar.jpg';
            }
            $data->avatar = $imageName;
            $data->save();
        }

        return new DefaultResource($data);
    }

    public function lgu($keyword){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data =  MemberMunicipality::with('member')->with('municipality')
        ->whereHas('municipality',function ($query) use ($keyword) {
            $query->where('member_id',1)->where('name', 'LIKE', '%'.$keyword.'%');
        })->paginate(10);
        return DefaultResource::collection($data);
    }
}
