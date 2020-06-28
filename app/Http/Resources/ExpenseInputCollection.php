<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

// use Illuminate\Http\Resources\Json\ResourceCollection;

class ExpenseInputCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
                'id'=>$this->id,
                'name'=>$this->name,
                'quantity'=>$this->quantity,
                'units'=>$this->units,
                'rate'=>$this->rate,
                'description'=>$this->description,
                'amount'=>$this->amount,
        ];
    }

    // public function with(){
    //     return [
    //         'total'=>$this->expenseTotal()
    //     ];
    // }
}
