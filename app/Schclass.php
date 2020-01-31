<?php

namespace App;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class Schclass extends Model
{
    protected $fillable = ['name','slug','level'];

    public function setSlugAttribute($value)
    {
        if (! empty($value)) $this->attributes['slug'] = str_slug($this->name);
    }
    public function classStreames()
    {
        return $this->belongsToMany(Schstream::class);
    }
    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function classStream()
    {
        return $this->belongsTo(Schstream::class);
    }
    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }




    public function subjects(){
        return $this->belongsToMany(Subject::class);
    }
    public function subject(){
        return $this->belongsTo(Subject::class);
    }
}
