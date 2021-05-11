<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function mm()
    {
        return $this->belongsTo('App\Models\MemberMunicipality', 'mm_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Dropdown', 'category_id', 'id');
    }

    public function storage()
    {
        return $this->belongsTo('App\Models\Storage', 'storage_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Dropdown', 'status_id', 'id');
    }

    public function purchases()
    {
        return $this->hasMany('App\Models\AssetPurchase', 'asset_id');
    }

    public function information()
    {
        return $this->hasOne('App\Models\AssetInformation', 'asset_id');
    }

    public function locations()
    {
        return $this->hasMany('App\Models\AssetLocation', 'asset_id');
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
