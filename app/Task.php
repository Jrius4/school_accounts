<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name','details','color','start','end','user_id'];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
