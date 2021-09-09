<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetList extends Model
{
    use HasFactory;

    public function assetlocation()
    {
        return $this->belongsTo('App\Models\AssetLocation', 'assetlocation_id', 'id');
    }

    public function borrowed()
    {
        return $this->hasMany('App\Models\MemberAsset', 'asset_id');
    }

    public function info()
    {
        return $this->hasOne('App\Models\AssetInfo', 'asset_id');
    }

    public function logs()
    {
        return $this->hasMany('App\Models\AssetLogs', 'asset_id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Dropdown', 'status_id', 'id');
    }
  
    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }
}
