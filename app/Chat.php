<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $guarded = [];
	protected $fillable = ['message','user_id'];
	
	public function user()
    {
        return $this->belongsTo(User::class);
    }
	
}
