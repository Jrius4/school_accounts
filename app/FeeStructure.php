<?php

namespace App;

use App\Accounts\SchoolAccount;
use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    protected $fillable = ['structure_name','amount','school_account_id'];

    public function schoolAccount()
    {
        return $this->belongsTo(SchoolAccount::class);
    }
}
