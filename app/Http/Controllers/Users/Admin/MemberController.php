<?php

namespace App\Http\Controllers\Users\Admin;

use App\Models\Member;
use App\Models\MemberMunicipality;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StoreImage;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\MemberResource;
use App\Http\Requests\MemberRequest;

class MemberController extends Controller
{
    public function index($keyword)
    {
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data =  Member::where('name','LIKE','%'.$keyword.'%')->paginate(10);
        return DefaultResource::collection($data);
    }

    public function lists()
    {
        $data =  Member::get();
        return DefaultResource::collection($data);
    }

    public function store(StoreImage $strmg, MemberRequest $request)
    {
        $data = ($request->input('editable')) ? Member::findOrFail($request->input('id')) : new Member;
        $data->name  = ucwords($request->input('name'));
        $data->acronym = strtoupper($request->input('acronym'));
        $data->type = 'Agency';
        if($data->save()){
            $name = strtolower($request->input('acronym')).'-'.$data->id;
            if($request->input('avatar') != ''){
                $imageName = $strmg->strmg($request->input('avatar'),$name);
            }else{
                ($request->input('editable')) ? $imageName = $data->avatar : $imageName = 'avatar.jpg';
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
    
    public function search(Request $request){
        $keyword = $request->input('keyword');
        $data =  MemberMunicipality::with('member')->with('municipality')
        ->where('id','!=',\Auth::user()->member->mm->id)
        ->whereHas('member', function($query) use ($keyword){
            $query->where('name', 'LIKE', '%'.$keyword.'%')->orWhere('acronym','LIKE','%'.$keyword.'%');
        })->orWhereHas('municipality', function($query) use ($keyword){
            $query->where('name', 'LIKE', '%'.$keyword.'%');
        })->take(5)->get();
        return MemberResource::collection($data);
    }

}
