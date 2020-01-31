<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AjaxTest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = AjaxTest::orderBy('id','desc')->paginate(8);

        return view('ajax-crud',compact('users'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = $request->user_id;
        $user   =   AjaxTest::updateOrCreate(['id' => $userId],
                    ['name' => $request->name, 'email' => $request->email]);

        return Response::json($user);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $user  = AjaxTest::where($where)->first();

        return Response::json($user);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = AjaxTest::where('id',$id)->delete();

        return Response::json($user);
    }

    public function getCity()
    {
        return view('ajaxRequest');
    }

    public function postCity(Request $request)
    {
        $input = $request->all();

        // $this->validate($request,[
        //     'name' => 'required',
        //     'email' => 'required|unique:ajax_tests,email',
        //     'password' => 'required|confirmed|min:6',
        // ]);

        AjaxTest::create($request->all());

        return response()->json(['success'=>'Got Simple Ajax Request.']);
    }

    public function fetch()
    {
        if(isset($_POST['action']))
            {

                        $output = '';

                        if($_POST["action"] == 'country')
                        {
                                $result = DB::select("
                                SELECT state FROM cities
                                WHERE country = :country
                                GROUP BY state
                                ");
                                $output .= '<option value="">Select State</option>';
                                foreach($result as $row)
                                {
                                    $output .= '<option value="'.$row->state.'">'.$row->state.'</option>';
                                }
                        }
                    if($_POST["action"] == 'state')
                    {
                        $result = DB::select("
                        SELECT city FROM country_state_city
                        WHERE state = :state
                        ");
                        foreach($result as $row)
                        {
                            $output .= '<option value="'.$row->city.'">'.$row->city.'</option>';
                        }


                    }
                return $output;
            }
    }
}
