<?php

namespace App\Http\Resources;

use App\Model\ClassStream;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SchoolClassResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => "".$this->id."",
            'title' => "".$this->name."",
            'value' => $this->slug,
            'children' => ClassStreamResource::collection($this->classStreames)
        ];
        // return [
        //     'id' => $this->id,
        //     'name' => $this->name,
        //     'email' => $this->email,
        //     'posts' => PostResource::collection($this->posts),
        //     'created_at' => $this->created_at,
        //     'updated_at' => $this->updated_at,
        // ];
        // return parent::toArray($request);
    }
}
