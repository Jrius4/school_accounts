<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{

    protected $fillable = ['name'];
    public function examSet()
    {
        return $this->hasMany(Exmset::class);
    }
    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
