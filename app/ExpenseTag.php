<?php

namespace App;

use App\Accounts\Outflow;
use Illuminate\Database\Eloquent\Model;

class ExpenseTag extends Model
{
    protected $fillable = ['slug','name'];

    public function outflows(){
     return   $this->belongsToMany(Outflow::class);
    }

    public function outflow(){
       return $this->belongsTo(Outflow::class);
    }
}
