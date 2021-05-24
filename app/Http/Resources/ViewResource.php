<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ViewResource extends JsonResource
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
            'quantity' => $this->quantity,
            'name' => $this->asset->name,
            'image' => $this->asset->image,
            'category' => $this->asset->category->name,
            'location' => $this->location->name,
            'available' => $this->available(),
            'tracker' => $this->tracker(),
        ];
    }
}
