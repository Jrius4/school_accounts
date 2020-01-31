<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staffs';
    protected $fillable = ['name','slug'];


    public function getRouteKey()
    {
        return 'slug';
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
