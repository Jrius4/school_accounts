<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassFee extends Model
{
    protected $fillable = ['schclass_id','fees_amount'];

    public function schclass()
    {
       return $this->belongsTo(Schclass::class);
    }
}
