<?php

namespace App\Accounts;

use Illuminate\Database\Eloquent\Model;

class SchoolAccount extends Model
{
    protected $fillable = ['account_name','amount'];
}
