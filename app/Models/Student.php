<?php

namespace App\Models;

use App\Combination;
use App\Mark;
use App\PpTrComment;
use App\Result;
use App\Schclass;
use App\Schstream;
use App\Subject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use Notifiable;
    protected $guard = 'admin';
    protected $fillable = ['name','roll_number','password','schclass_id','schstream_id','combination_id','gender','amount_paid','image','medical_form','admission_form'];

    protected $hidden = ['password','remember_token'];

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
    public function ppComment()
    {
        return $this->hasMany(PpTrComment::class);
    }
    public function schclass()
    {
        return $this->belongsTo(Schclass::class);
    }

    public function schstream()
    {
        return $this->belongsTo(Schstream::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function combination()
    {
        return $this->belongsTo(Combination::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }


}
