<?php

namespace App;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['student_id','fees','paid_by','term_id'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }
}
