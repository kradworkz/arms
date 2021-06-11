<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    public function status()
    {
        return $this->belongsTo('App\Models\Dropdown', 'status_id', 'id');
    }

    public function municipality()
    {
        return $this->belongsTo('App\Models\LocationMunicipality', 'municipality_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Dropdown', 'type_id', 'id');
    }
}
