<?php

namespace App\Accounts;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['source_identifier','destination_identifier','amount'];
}
