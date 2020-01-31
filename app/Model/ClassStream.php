<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\SchoolClass;

class ClassStream extends Model
{
    protected $table = 'streams';
    protected $fillable = ['name','slug'];

    public function setSlugAttribute($value)
    {
        if (! empty($value)) $this->attributes['slug'] = str_slug($this->name);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function schoolClasses()
    {
        return $this->belongsToMany(SchoolClass::class);
    }
}
