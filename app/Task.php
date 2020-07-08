<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title','detail','start','end','user_id'];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
