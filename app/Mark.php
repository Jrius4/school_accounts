<?php

namespace App;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $fillable = ['student_id','subject_id','grade','final_mark','teacher_comment','points'];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
