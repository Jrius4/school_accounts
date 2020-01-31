<?php

namespace App\Routine;

use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    protected $fillable = ['name','number_students','student_class_id'];

}
