<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetList extends Model
{
    use HasFactory;

    public function asset()
    {
        return $this->belongsTo('App\Models\Asset', 'asset_id', 'id');
    }
    
    public function storage()
    {
        return $this->belongsTo('App\Models\Storage', 'storage_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Dropdown', 'status_id', 'id');
    }

    public function trackers()
    {
        return $this->hasMany('App\Models\AssetTracker', 'assetlist_id');
    }

    public function trackercount()
    {
        return $this->hasMany('App\Models\AssetTracker', 'assetlist_id')->count();
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
