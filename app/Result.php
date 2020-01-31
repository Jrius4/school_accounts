<?php

namespace App;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['teacher_id','student_id','schclass_id','paper_id','term_id','exmset_id','term_id','mark','grade','comments','year'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function schclass()
    {
        return $this->belongsTo(Schclass::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function paper()
    {
        return $this->belongsTo(Paper::class);
    }

    public function exmset()
    {
        return $this->belongsTo(Exmset::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }
}
