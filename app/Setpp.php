<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setpp extends Model
{
    protected $fillable = ['paper_id','subject_id','percentage'];

    public function paper()
    {
        return $this->belongsTo(Paper::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
