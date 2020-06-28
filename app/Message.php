<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	protected $guarded = [];
    protected $fillable = ['message','from','to','is_read'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
