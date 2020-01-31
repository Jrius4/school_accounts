<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exmset extends Model
{
    protected $fillable = ['set_name','grade'];


    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
