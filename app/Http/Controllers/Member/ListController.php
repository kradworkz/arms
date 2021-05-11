<?php

namespace App\Http\Controllers\Member;

use App\Models\Storage;
use App\Models\Vendor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;

class ListController extends Controller
{
    public function index($type,$keyword){
        ($keyword == '-') ? $keyword = '' : $keyword;
        if($type == 1){
            $query = Storage::query();
        }else{
            $query = Vendor::query();
        }
        $data = $query->where('name','LIKE','%'.$keyword.'%')->paginate(10);

        return DefaultResource::collection($data);

    }

    public function lists($type){
        
        if($type == 1){
            $query = Storage::query();
            $query->where('mm_id',\Auth::user()->member->mm->id);
        }else{
            $query = Vendor::query();
        }
        $data = $query->get();

        return DefaultResource::collection($data);
    }

    public function location(Request $request){

        $type = $request->input('selected');
        $member_id = \Auth::user()->member->mm->id;

        $data = ($type == 'Storage') ? new Storage : new Vendor;
        $data->name = ucwords(strtolower($request->input('name')));
        $data->address = ucwords(strtolower($request->input('address')));
        $data->contact_no = $request->input('contact_no');
        ($type == 'Storage') ? $data->mm_id = $member_id : ''; 
        $data->save();
    }

}
