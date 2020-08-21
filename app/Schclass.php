<?php

namespace App;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class Schclass extends Model
{
    protected $fillable = ['name','slug','level','user_id'];

    public function setSlugAttribute($value)
    {
        if (! empty($value)) $this->attributes['slug'] = str_slug($this->name);
    }

    public function exams()
    {
        return $this->hasMany('App\Exam','schclass_id');
    }

    public function classFee()
    {
        return $this->hasOne(ClassFee::class);
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
        return $this->belongsTo(User::class);
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
    public function declares()
    {
        return $this->hasMany(DeclareResults::class);
    }
}
