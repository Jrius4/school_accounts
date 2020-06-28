<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $connection = 'mysql2';
    protected $fillable = ['code','name'];

    public function user()
    {
        return $this->belongsTo(User::class,'code','id');
    }
}
