<?php

namespace App;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class StudentFee extends Model
{
    protected $fillable = ['student_id','fees','to_pay','paid','term_id','year'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }
}
