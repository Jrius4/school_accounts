<?php

namespace App\Accounts;

use App\AccCategory;
use App\FeeStructure;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Model;

class SchoolAccount extends Model
{
    protected $fillable = ['account_name','account_slug','acc_category_id','amount','set_minium_balance'];

    public function accCategory()
    {
        return $this->belongsTo(AccCategory::class);
    }

    public function feeStructures()
    {
        return $this->hasMany(FeeStructure::class);
    }
    public function accTest()
    {
        $arr = array(
            'fees'=>'4500000',
            'sports-fees'=>'4500000',
        );
        $str = json_encode($arr,true);
        $str2 = json_decode($str,true);
        // str_re
        // $arr_json = compact($arr);
        // $arr_str = explode
        // $test = str_getcsv('hello world,kill me');
        return compact('str','str2');
    }
}
