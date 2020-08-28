<?php

namespace App\Models;

use App\Combination;
use App\DeclareResults;
use App\Mark;
use App\Payment;
use App\PpTrComment;
use App\Result;
use App\Schclass;
use App\Schstream;
use App\StudentFee;
use App\Subject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Student extends Authenticatable
{
    use Notifiable, HasApiTokens;
    protected $guard = 'student';
    protected $fillable = ['name', 'roll_number', 'password', 'schclass_id', 'schstream_id', 'combination_id', 'gender', 'amount_paid', 'image', 'last_seen_at', 'medical_form', 'admission_form'];

    protected $hidden = ['password', 'remember_token'];

    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'follows_id', 'user_id')
            ->withTimestamps();
    }

    public function follows()
    {
        return $this->belongsToMany(self::class, 'followers', 'user_id', 'follows_id')
            ->withTimestamps();
    }

    public function follow($userId)
    {
        $this->follows()->attach($userId);
        return $this;
    }
    public function exams()
    {
        return $this->hasMany('App\Exam', 'student_id');
    }

    public function unfollow($userId)
    {
        $this->follows()->detach($userId);
        return $this;
    }

    public function isFollowing($userId)
    {
        return (bool) $this->follows()->where('follows_id', $userId)->first(['follows_id']);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function studentFees()
    {
        return $this->hasMany(StudentFee::class);
    }
    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function ppComment()
    {
        return $this->hasMany(PpTrComment::class);
    }

    public function schclass()
    {
        return $this->belongsTo(Schclass::class);
    }

    // public function schstream()
    // {
    //     return $this->belongsTo(Schstream::class);
    // }
    public function students()
    {
        return $this->belongsTo('App\Schstream', 'schstream_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function combination()
    {
        return $this->belongsTo(Combination::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function declares()
    {
        return $this->hasMany(DeclareResults::class);
    }
}
