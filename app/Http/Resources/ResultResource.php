<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
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
            'asset_code' => $this->asset_code,
            'tracker_code' => $this->tracker_code,
            'coordinates' => $this->coordinates,
            'name' => $this->assetlocation->asset->name,
            'image' => $this->assetlocation->asset->image,
            'location' => $this->assetlocation->location->name,
            'address' => $this->assetlocation->location->address,
            'status' => $this->status,
            'category' => $this->assetlocation->asset->category->name,
        ];
    }
}
