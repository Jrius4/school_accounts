<?php

namespace App;

use App\Models\Staff;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use LaratrustUserTrait,HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','slug','image','username','staff_id','some_form','is_class_teacher',
        'schclass_id','biography','join_as','entry_date','former_school','last_seen_at','api_token',
        'wage_salary','wage_paid','wage_balance','wage_loan','wage_upfront'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','api_token'
    ];

    public function blogs(){
        return $this->hasMany(Blog::class,'code','id');
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }

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

    public function unfollow($userId)
    {
        $this->follows()->detach($userId);
        return $this;
    }

    public function isFollowing($userId)
    {
        return (boolean) $this->follows()->where('follows_id', $userId)->first(['follows_id']);
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->hasMany(Message::class);
    }

	public function messages()
	{
		return $this->hasMany(Chat::class);
	}

    public function comments(){
        return $this->hasMany('App\Comment');
    }
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
