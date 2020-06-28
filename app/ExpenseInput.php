<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExpenseInput extends Model
{
    protected $fillable = ['name','quantity','units','rate','amount','description'];

    public function expenseTotal(){
        $exp = array_sum($this->get()->pluck('amount')->toArray());
        return $exp;
    }
}
