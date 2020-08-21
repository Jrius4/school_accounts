<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'indexno','student_name','subject_name',
        'comment', 'set_id', 'term_id', 'point', 'papers', 'grade',
        'total', 'user_id', 'subject_id', 'student_id',
        'b_o_t', 'm_o_t', 'e_o_t', 'overall','year','schclass_id'
    ];

    public function student()
    {
        return $this->belongsTo('App\Models\Student','student_id');
    }
    public function schclass()
    {
        return $this->belongsTo('App\Schclass','schclass_id');
    }
}
