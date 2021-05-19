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
            'code' => $this->code,
            'quantity' => $this->quantity,
            'name' => $this->asset->name,
            'image' => $this->asset->image,
            'status' => $this->status->name,
            'storage' => $this->storage->name,
        ];
    }
}
