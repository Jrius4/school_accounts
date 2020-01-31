<?php

namespace App\Accounts;

use Illuminate\Database\Eloquent\Model;

class Inflow extends Model
{
    protected $fillable = ['source_identifier','amount'];
}
