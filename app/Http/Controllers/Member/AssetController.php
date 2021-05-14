<?php

namespace App\Http\Controllers\Member;

use App\Models\Asset;
use App\Models\AssetList;
use App\Models\AssetPurchase;
use App\Models\AssetLocation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StoreImage;
use App\Http\Resources\DefaultResource;
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
                $data->mm_id = $member_id;
                $data->save();

            }else{
                $lists = $request->input('lists'); // Adding thru array

                $data = new Asset; 
                $data->name =  ucwords(strtolower($request->input('name')));
                $data->category_id = $request->input('category');
                $data->mm_id = $member_id;
                if($data->save()){
                    $name = strtolower($request->input('name')).'-'.$data->id;
                    if($request->input('avatar') != ''){
                        $imageName = $strmg->strmg($request->input('avatar'),$name);
                    }else{
                        ($request->input('editable')) ? $imageName = $data->avatar : $imageName = 'default.jpg';
                    }
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
                    }
                }
            }
            // $member_id = \Auth::user()->member->mm->id;
            // $count = Asset::count();

            // $data = ($request->input('editable')) ? Asset::findOrFail($request->input('id')) : new Asset;
            // $data->code = \Auth::user()->member->mm->member->acronym.'-'.$member_id.'-'.str_pad(($count+1), 4, '0', STR_PAD_LEFT); 
            // $data->name =  ucwords(strtolower($request->input('name')));
            // $data->category_id = $request->input('category');
            // $data->storage_id = $request->input('storage');
            // $data->quantity = $request->input('quantity');
            // $data->status_id = 5;
            // $data->mm_id = $member_id;
            
            // if($data->save()){

            //     $name = strtolower($request->input('name')).'-'.$data->id;
            //     if($request->input('avatar') != ''){
            //         $imageName = $strmg->strmg($request->input('avatar'),$name);
            //     }else{
            //         ($request->input('editable')) ? $imageName = $data->avatar : $imageName = 'default.jpg';
            //     }
            //     $data->image = $imageName;
            //     $data->save();

            //     $data->purchase()->create([
            //         'quantity' => $request->input('quantity'),
            //         'price' => $request->input('price'),
            //         'vendor_id' => $request->input('vendor')
            //     ]); 
                
            //     if($request->input('extra')){
            //         $data->information()->create([
            //             'brand' => ($request->input('brand')!= '') ? $request->input('brand') : 'n/a',
            //             'serial_no' => ($request->input('serial_no')!= '') ? $request->input('serial_no') : 'n/a',
            //             'model' => ($request->input('model')!= '') ? $request->input('model') : 'n/a',
            //             'description' => ($request->input('description')!= '') ? $request->input('description') : 'n/a',
            //         ]); 
            //     }
            // }
        });
    }

    public function view($id){
       $data = Asset::with('category')
        ->with('information')->with('status')->with('storage')
        ->with('purchases')
        ->where('id',$id)->first();

        return new AssetResource($data);
    }

    public function purchases($id){
        $data = AssetPurchase::with('vendor')
         ->where('asset_id',$id)->paginate(5);
 
         return DefaultResource::collection($data);
     }

     public function locations($id){
        $data = AssetLocation::where('asset_id',$id)->paginate(5);
 
        return DefaultResource::collection($data);
     }
}
