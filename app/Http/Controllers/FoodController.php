<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foods = '';
        return view('files.index',compact('foods'));
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
        if($request->hasFile('file')) {

            // Upload path
            $destinationPath = 'files/';

            // Create directory if not exists
            if (!file_exists($destinationPath)) {
               mkdir($destinationPath, 0755, true);
            }


            // Get file extension
            $extension = $request->file('file')->getClientOriginalExtension();

            // Valid extensions
            $validextensions = array("jpeg","jpg","png","pdf");

            // Check extension
            if(in_array(strtolower($extension), $validextensions)){

              // Rename file
              $fileName = str_slug(Carbon::now()->toDayDateTimeString()).rand(11111, 99999) .'.' . $extension;

              // Uploading file to given path
              $request->file('file')->move($destinationPath, $fileName);

            }

            File::create(array('file'=>$request['file']));
        }
    }

    public function uploadfiles(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
