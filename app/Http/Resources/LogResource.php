<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
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
            'status' => $this->status->name,
            'remarks' => ($this->created_at != $this->updated_at) ? 'Completed' : $this->remarks,
            'created_at' => ($this->created_at != $this->updated_at) ? $this->updated_at : $this->created_at,
        ];
    }
}
