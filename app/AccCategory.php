<?php

namespace App;

use App\Accounts\SchoolAccount;
use Illuminate\Database\Eloquent\Model;

class AccCategory extends Model
{
    protected $fillable = ['name','slug'];



    public function schoolAccounts()
    {
        return $this->hasMany(SchoolAccount::class);
    }



}
