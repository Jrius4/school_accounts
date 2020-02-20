<?php

namespace App;

use App\Models\Staff;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','slug','image','username','staff_id','some_form','is_class_teacher','schclass_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function staff(){
        return $this->belongsTo(Staff::class);
    }
    public function schClasses()
    {
        return $this->belongsToMany(Schclass::class);
    }
    public function ppComment()
    {
        return $this->hasMany(PpTrComment::class);
    }

    public function schClass()
    {
        return $this->belongsTo(Schclass::class);
    }
    public function schStreams()
    {
        return $this->belongsToMany(Schstream::class);
    }
    public function hasClasses()
    {
        return $this->hasMany(Schclass::class);
    }

    public function setPasswordAttribute($value)
    {
        if (! empty($value)) $this->attributes['password'] = crypt($value, '');
    }

    public function getImageUrlAttribute($value)
    {
        $imageUrl = "";

        if ( ! is_null($this->image))
        {
            $directory = config('cms.image.directory');
            $imagePath = public_path() . "/{$directory}/" . $this->image;
            if (file_exists($imagePath)) $imageUrl = asset("{$directory}/" . $this->image);
        }

        return $imageUrl;
    }


    public function subjects(){
        return $this->belongsToMany(Subject::class);
    }
    public function subject(){
        return $this->belongsTo(Subject::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }





}
