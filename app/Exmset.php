<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exmset extends Model
{
    protected $fillable = ['set_name','grade','set_percentage'];


    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function declares()
    {
        return $this->hasMany(DeclareResults::class);
    }
}
