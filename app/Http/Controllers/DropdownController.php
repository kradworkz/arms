<?php

namespace App\Http\Controllers;

use App\Models\Dropdown;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\DropdownResource;
use App\Http\Requests\DropdownRequest;

class DropdownController extends Controller
{
    public function index($classification,$keyword)
    {
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data = Dropdown::where('name','LIKE','%'.$keyword.'%')->where('classification',$classification)->paginate(5);
        return DefaultResource::collection($data);
    }

    public function lists($classification,$type)
    {
        $query = Dropdown::query();
        ($type != '-') ? $query->where('type',$type) : '';
        $data = $query->where('classification',$classification)->get();

        return DefaultResource::collection($data);
    }

    public function store(DropdownRequest $request)
    {
        $data = new Dropdown;
        $data->name =  ucwords(strtolower($request->input('name')));
        $data->type = ($request->input('type')) ? $request->input('type') : 'n/a';
        $data->classification = $request->input('selected');
        $data->color = $request->input('color');
        $data->save();

        return new DefaultResource($data);
    }

    public function count($classification,$type)
    {
        ($type == '-') ? $type = '' : $type;
        $query = Dropdown::query();
        ($type != '') ? $query->where('type',$type) : '';
        $data = $query->where('classification',$classification)->get();

        return DropdownResource::collection($data);
    }
    

    // public function index($classification,$keyword){
    //     ($keyword == '-') ? $keyword = '' : $keyword;
    //     $data = Drop)->where('name','LIKE','%'.$keyword.'%')down::where('classification',$classification->paginate(10);
    //     return DefaultResource::collection($data);
    // }

    // public function lists($type,$classification){
    //     $classification = ($classification == 1) ? 'Category' : 'Status';
    //     $data = Dropdown::where('type',$type)->where('classification',$classification)->get();
    //     return DefaultResource::collection($data);
    // }

    // public function dropdown($classification){
    //     $classification = ($classification == 1) ? 'Category' : 'Status';
    //     $data = Dropdown::where('classification',$classification)->get();
    //     return DefaultResource::collection($data);
    // }


    // public function reports(){
    //     $data = Dropdown::where('type','Asset')->where('classification','Status')->get();
    //     return DropdownResource::collection($data);
    // }

    // public function store(DropdownRequest $request){

    //     $data = new Dropdown;
    //     $data->name =  ucwords(strtolower($request->input('name')));
    //     $data->type = ($request->input('type')) ? $request->input('type') : 'n/a';
    //     $data->classification = ($request->input('selected') == 1) ? 'Category' : 'Status';
    //     $data->color = $request->input('color');
    //     $data->save();

    //     return new DefaultResource($data);
    // }
}
