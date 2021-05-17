<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PacketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        $json = \json_decode($this->value);
        $array = \json_decode($json);
        return [
            'id' => $this->id,
            'uniqueid' => $array->uniqueid,
            'gps' => $array->gps,
            'status' => $array->status,
            'created_at' => $this->created_at,
        ];
    }
}
