<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
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
            'station' => $this->station,
            'coordinates' => $this->coordinates,
            'datalogger' => $this->data_logger,
            'remarks' => $this->remarks,
            'type' => $this->type,
            'status' => $this->status,
            'municipality' => $this->municipality,
            'province' => $this->municipality->province,
        ];
    }
}
