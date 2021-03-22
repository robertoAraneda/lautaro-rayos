<?php

namespace App\Http\Resources\Object;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientObject extends JsonResource
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
            'bdup'              => $this->bdup,
            'names'             => $this->names,
            'lastname'          => $this->lastname,
            'motherLastname'    => $this->mother_lastname,
            'birthDate'         => $this->birthdate,
            'phone'             => $this->phone,
            'email'             => $this->email
        ];
    }
}
