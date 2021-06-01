<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
            'name' => ($this->member->type == 'LGU') ? $this->municipality->name : $this->member->name,
            'acronym' => $this->member->acronym,
            'type' => $this->member->type,
        ];
    }
}
