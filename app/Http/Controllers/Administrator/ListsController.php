<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Storage;
use App\Models\Category;
use App\Models\Vendor;
use App\Models\Status;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;

class ListsController extends Controller
{
    public function index($type,$keyword){
        ($keyword == '-') ? $keyword = '' : $keyword;
        if($type == 1){
            $query = Storage::query();
        }else if($type == 2){
            $query = Vendor::query();
        }else if($type == 3){
            $query = Category::query();
        }else{
            $query = Status::query();
        }
        $data = $query->where('name','LIKE','%'.$keyword.'%')->paginate(10);

        return DefaultResource::collection($data);

    }

    public function store(Request $request){

        $type = $request->input('selected');

        if($type == 1){
            $data = new Storage;
        }else if($type == 2){
            $data = new Vendor;
        }else if($type == 3){
            $data = new Category;
        }else{
            $data = new Status;
        }

        $data->name =  ucwords(strtolower($request->input('name')));
        ($request->input('address')) ? $data->address = ucwords(strtolower($request->input('address'))) : '';
        ($request->input('contact_no')) ? $data->contact_no = $request->input('contact_no') : '';
        ($request->input('type')) ? $data->type = $request->input('type') : '';
        $data->save();

        return new DefaultResource($data);
    }
}
