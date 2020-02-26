<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeclareResults extends Model
{
    protected $fillable= ['year','team_id','student_id','schclass_id','status'];
}
