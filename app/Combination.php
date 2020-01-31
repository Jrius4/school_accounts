<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Combination extends Model
{
    protected $fillable = ['level','first_subject','second_subject','third_subject','subsidiary','combination_name'];
}
