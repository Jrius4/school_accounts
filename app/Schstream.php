<?php

namespace App;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class Schstream extends Model
{
    protected $fillable = ['name', 'slug'];

    public function setSlugAttribute($value)
    {
        if (!empty($value)) $this->attributes['slug'] = str_slug($this->name);
    }


    public function schoolClasses()
    {
        return $this->belongsToMany(Schclass::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function students()
    {
        return $this->hasMany('App\Models\Student', 'schstream_id');
    }

    public function schoolClass()
    {
        return $this->belongsTo(Schclass::class);
    }
}
