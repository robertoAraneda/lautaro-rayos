<?php

namespace App\Http\Resources\Collection;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TypeReportCollection extends ResourceCollection
{


      /**
   * The resource that this resource collects.
   *
   * @var string
   */
    public $collects = 'App\Http\Resources\Object\TypeReportObject';
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'array' => $this->collection,
            'length' => $this->collection->count()
        ];
    }
}
