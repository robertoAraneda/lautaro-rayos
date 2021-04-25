<?php

namespace App\Http\Resources\Object;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class EstablishmentObject extends JsonResource
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
            'id'                => $this->id,
            'description'       => $this->description,
            'shortname'         => $this->shortname,
            'createdAt'         => Carbon::parse($this->created_at)->format('d-m-Y H:i'),
        ];
    }
}
