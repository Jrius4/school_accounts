<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Paper extends Model
{
    protected $fillable = ['paper_name','subject_id','paper_abbrev'];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }
    public function paperSets()
    {
        return $this->hasOne(Setpp::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
