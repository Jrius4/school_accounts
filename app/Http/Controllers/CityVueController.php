<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Resources\CityCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CityVueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::orderBy('id','desc')->get();

        // return response()->json(compact('cities'),$status=200);
        return CityCollection::collection($cities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $city = new City();
        $rules=array(
            'country'=>'required',
            'state'=>'required',
            'city'=>'required',
        );
        $validate = Validator::make($request->all(),$rules);
        if($validate->fails())
        {
            return response()->json(['errors'=>$validate->messages()],403);
        }
        $data = $request->all();
        $data['country'] = Str::camel($data['country']);
        $data['state'] = str_slug($data['state']);
        $data['city'] = Str::lower($data['city']);
        $city->create($data);

        return new CityCollection($city->get()->last());

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city = City::findOrFail($id);

        return new CityCollection($city);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);
        $data = $request->all();
        if(isset($data['country'])) $data['country'] = Str::camel($data['country']);
        if(isset($data['city'])) $data['city'] = Str::lower($data['city']);
        if(isset($data['state'])) $data['state'] = str_slug($data['state']);
        $city->update($data);

        // return response()->json(['message'=>"updated city successfully"],$status=202);
        return new CityCollection($city);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return response()->json(['message'=>"deleted city successfully"],202);
    }
}
