<?php

namespace App;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name','level','subject_code','subject_compulsory'];

    public function paperSets()
    {
        return $this->hasMany(Setpp::class);
    }
    public function ppComment()
    {
        return $this->hasMany(PpTrComment::class);
    }
    public function marks()
    {
        return $this->hasOne(Mark::class);
    }
    public function papersIn()
    {
        return $this->hasMany(Paper::class);
    }
    public function papers()
    {
        return $this->belongsToMany(Paper::class);
    }
    public function schoolClasses(){
        return $this->belongsToMany(Schclass::class);
    }
    public function schoolClass(){
        return $this->belongsTo(Schclass::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }


    public function user(){
        return $this->belongsTo(User::class);
    }
    public function results()
    {
        return $this->hasMany(Result::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }



}
