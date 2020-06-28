<?php

namespace App;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class DeclareResults extends Model
{
    protected $fillable= ['year','term_id','exmset_id','student_id','schclass_id','status','message'];

    // public function student()
    // {
    //     return $this->belongsTo(Student::class);
    // }

    // public function term()
    // {
    //     return $this->belongsTo(Term::class);
    // }

    // public function exmset()
    // {
    //     return $this->belongsTo(Exmset::class);
    // }

    // public function schclass()
    // {
    //     return $this->belongsTo(Schclass::class);
    // }

}
