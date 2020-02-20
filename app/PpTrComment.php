<?php

namespace App;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class PpTrComment extends Model
{
    protected $fillable = ['student_id','user_id','subject_id','body'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
