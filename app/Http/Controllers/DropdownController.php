<?php

namespace App\Http\Controllers;

use App\Models\Dropdown;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\DropdownResource;
use App\Http\Requests\DropdownRequest;

class DropdownController extends Controller
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

    public function reports($type){
        $classification = ($type == 1) ? 'Category' : 'Status';
        $data = Dropdown::where('classification',$classification)->get();
        return DropdownResource::collection($data);
    }

    public function store(DropdownRequest $request){

        $data = new Dropdown;
        $data->name =  ucwords(strtolower($request->input('name')));
        $data->type = ($request->input('type')) ? $request->input('type') : 'n/a';
        $data->classification = ($request->input('selected') == 1) ? 'Category' : 'Status';
        $data->color = $request->input('color');
        $data->save();

        return new DefaultResource($data);
    }
}
