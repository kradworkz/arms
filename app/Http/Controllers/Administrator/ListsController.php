<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Dropdown;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;

class ListsController extends Controller
{
    public function index($type,$keyword){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $classification = ($type == 1) ? 'Category' : 'Status';
        $data = Dropdown::where('classification',$classification)->where('name','LIKE','%'.$keyword.'%')->paginate(10);
        return DefaultResource::collection($data);
    }

    public function lists($type){
        $classification = ($type == 1) ? 'Category' : 'Status';
        $data = Dropdown::where('classification',$classification)->get();
        return DefaultResource::collection($data);
    }

    public function store(Request $request){

        $data = new Dropdown;
        $data->name =  ucwords(strtolower($request->input('name')));
        $data->type = ($request->input('type')) ? $request->input('type') : 'n/a';
        $data->classification = ($request->input('selected') == 1) ? 'Category' : 'Status';
        $data->save();

        return new DefaultResource($data);
    }
}
