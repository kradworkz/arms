<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'asset' => $this->asset_code,
            'tracker' => ($this->tracker_code == null) ? 'n/a' : $this->tracker_code,
            'coordinates' => ($this->coordinates == null) ? 'n/a' : $this->coordinates,
            'status' => $this->status,
        ];
    }
}
