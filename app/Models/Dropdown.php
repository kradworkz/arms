<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dropdown extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function getColorAttribute($value)
    {
        if($value == 'violet' ){
            return 'primary';
        }else if($value == 'blue'){
            return 'info';
        }else if($value == 'red'){
            return 'danger';
        }else if($value == 'yellow'){
            return 'warning';
        }else if($value == 'black'){
            return 'dark';
        }
        else{
            return 'success';
        }
    }

    public function lists()
    {
        $member = \Auth::user()->member->mm->id;
        return $this->hasMany('App\Models\AssetList', 'status_id')
        ->where('status_id',$this->id)
        ->whereHas('assetlocation', function ($query) use ($member){
            $query->whereHas('asset', function ($query) use ($member){
                $query->where('mm_id',$member);
            });
        })
        ->count();
    }
}
