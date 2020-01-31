<?php

namespace App;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class Schstream extends Model
{
    protected $fillable = ['name','slug'];


    public function schoolClasses()
    {
        return $this->belongsToMany(Schclass::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(Schclass::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }


}
