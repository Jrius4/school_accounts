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
    public function studentFees()
    {
        return $this->hasMany(StudentFee::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function declares()
    {
        return $this->hasMany(DeclareResults::class);
    }
}
