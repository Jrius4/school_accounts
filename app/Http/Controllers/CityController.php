<?php

namespace App\Http\Controllers;

use App\City;
use App\CityInfo;
use App\Http\Controllers\Backend\BackendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends BackendController
{
    public function index()
    {
        $cities = new City();
        $cityInfo = new CityInfo();
        $result=DB::select('SELECT country FROM cities GROUP BY country ORDER BY country ASC');
        // return response()->json($result);

        return view('cities.index',compact('cities','cityInfo','result'));
    }
    public function store(Request $request)
    {
        return response()->json(['message'=>$request->all()]);
    }

    public function fetchCity(Request $request)
    {
        $cities = new City();
        if($request['action']!=null)
        {
            $output = '';
            if($request['action']=='country')
            {
                $result = $cities->select('state')->where('country',$request['query'])->groupBy('state')->get();
                $output .= '<option value="">Select State</option>';
                    foreach($result as $row)
                    {
                        $output .= '<option value="'.$row['state'].'">'.$row['state'].'</option>';
                    }
            }

            if($request['action']=='state')
            {
                $result = $cities->select('city')->where('state',$request['query'])->groupBy('city')->get();

                    foreach($result as $row)
                    {
                        $output .= '<option value="'.$row['city'].'">'.$row['city'].'</option>';
                    }
            }

            return $output;
        }

    }
}

