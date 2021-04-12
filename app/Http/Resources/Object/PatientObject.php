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
        if(isset($this->birthdate)){
           $interval = date_diff(date_create(), date_create($this->birthdate));  
        }
       

        return [
            'id'                => $this->id,
            'rut'               => $this->rut,
            'bdup'              => $this->bdup,
            'names'             => $this->names,
            'lastname'          => $this->lastname,
            'motherLastname'    => $this->mother_lastname,
            'birthDate'         => $this->birthdate,
            'phone'             => $this->phone,
            'email'             => $this->email,
            'age'               => isset($this->birthdate) ? intval($interval->format('%Y')): -1,
        ];
    }
}
