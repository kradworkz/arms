<?php

namespace App\Http\Controllers\Administrator;

use App\Models\User;
use App\Models\Agency;
use App\Models\MemberMunicipality;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StoreImage;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;
use Illuminate\Validation\Rules\Password;
use App\Jobs\EmailNewAccount;

class UserController extends Controller
{

    public function index($keyword){

        // ($keyword == '-') ? $keyword = '' : $keyword;
        // $users =  User::where('type','Member')
        // ->where('name', 'LIKE', '%'.$keyword.'%')
        // ->orWhereHas('member',function ($query) use ($keyword) {
        //     $query->whereHas('mm', function ($query) use ($keyword) {
        //         $query->whereHas('member', function($query) use ($keyword){
        //             $query->where('name', 'LIKE', '%'.$keyword.'%')->orWhere('acronym','LIKE','%'.$keyword.'%');
        //         })->orWhereHas('municipality', function($query) use ($keyword){
        //             $query->where('name', 'LIKE', '%'.$keyword.'%');
        //         });
        //     });
        // })->paginate(10);
        ($keyword == '-') ? $keyword = '' : $keyword;
        $users =  User::where('type','Member')
        ->where('name', 'LIKE', '%'.$keyword.'%')
        ->orWhereHas('member',function ($query) use ($keyword) {
            $query->whereHas('mm', function ($query) use ($keyword) {
                $query->whereHas('member', function($query) use ($keyword){
                    $query->where('name', 'LIKE', '%'.$keyword.'%')->orWhere('acronym','LIKE','%'.$keyword.'%');
                })->orWhereHas('municipality', function($query) use ($keyword){
                    $query->where('name', 'LIKE', '%'.$keyword.'%');
                });
            });
        })->paginate(10);

        return UserResource::collection($users);
    }

    public function store(StoreImage $strmg, UserRequest $request){
        
        $data = ($request->input('editable')) ? User::findOrFail($request->input('id')) : new User;
        $data->name = ucwords(strtolower($request->input('name')));
        $data->email = strtolower($request->input('email'));
        $data->password = bcrypt(123456789);
        $data->type = 'Member';
        
        if($data->save()){

            $member = $request->input('member');
            $municipality = $request->input('municipality');

            $name = strtolower($request->input('name')).'-'.$data->id;
            if($request->input('avatar') != ''){
                $imageName = $strmg->strmg($request->input('avatar'),$name);
            }else{
                ($request->input('editable')) ? $imageName = $data->avatar : $imageName = 'avatar.jpg';
            }
            $data->avatar = $imageName;
            $data->save();

            if(!$request->input('editable')){
                $mm = MemberMunicipality::where('member_id',$member)->where('municipality_id',$municipality)->get();
                if(count($mm) < 1){
                    $mm = new MemberMunicipality;
                    $mm->member_id = $member;
                    $mm->municipality_id = $municipality;
                    $mm->save();
                }
                $mm->user()->create([
                    'user_id' => $data->id,
                ]);

                EmailNewAccount::dispatch($data->id)->delay(now()->addSeconds(10));
            }
        }
    }

    public function password(Request $request){

        if (!(\Hash::check($request->get('current_password'), \Auth::user()->password))) {
            return response()->json(['error' => "Password doesn't match."], 401);
        }

        if(strcmp($request->get('current_password'), $request->get('password')) == 0){
            return response()->json(['error' => 'Please choose a different password'], 401);
        }

        $validatedData = $request->validate([
            'current_password' => 'required',
            'password' => ['required','confirmed',Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
        ]);

        User::find(auth()->user()->id)->update(['password'=> \Hash::make($request->input('password'))]);

        if(\Auth::user()->status == 'Inactive'){
            User::find(auth()->user()->id)->update(['status'=> 'Active']);
            return response()->json(['success' => 'First Attempt'], 200);
        }else{
            return response()->json(['success' => 'Password changed successfully !'], 200);
        }

    }
}
