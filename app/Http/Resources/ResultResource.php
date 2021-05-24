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
            'status' => $this->status,
            'name' => $this->assetlocation->asset->name,
            'image' => $this->assetlocation->asset->image,
        ];
    }
}
