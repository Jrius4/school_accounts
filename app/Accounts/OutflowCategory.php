<?php

namespace App\Accounts;

use Illuminate\Database\Eloquent\Model;

class OutflowCategory extends Model
{
    protected $fillable = ['name','slug'];

    public function outflows()
    {
        return $this->hasMany(Outflow::class);
    }
}
