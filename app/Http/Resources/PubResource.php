<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PubResource extends JsonResource
{
    public function toArray($request)
    {   
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'color' => $this->color
        ];
    }
}
