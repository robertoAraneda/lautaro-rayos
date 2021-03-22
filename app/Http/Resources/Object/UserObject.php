<?php

namespace App\Http\Resources\Object;

use Illuminate\Http\Resources\Json\JsonResource;

class UserObject extends JsonResource
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
            'rut'               => $this->rut,
            'name'              => $this->name,
            'lastname'          => $this->lastname,
            'motherLastname'    => $this->mother_lastname,
            'phone'             => $this->phone,
            'email'             => $this->email
        ];
    }
}
