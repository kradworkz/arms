<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetInformation extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable = ['brand','serial_no','model','description','asset_id'];

    public function asset()
    {
        return $this->belongsTo('App\Models\Asset', 'asset_id', 'id');
    }
}
