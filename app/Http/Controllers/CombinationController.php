<?php

namespace App\Http\Controllers;

use App\Combination;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CombinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $combinations = Combination::latest()->get();
        return view('manage-combinations.index',compact('combinations'));
    }

    public function getOlevelCombinations()
    {
        return view('manage-combinations.create-o-level');
    }

    public function storeOlevelCombinations(Request $request)
    {
        $rules = [
            'student_name'=>'required',
            'first_subject'=>'required',
            'second_subject'=>'required',
            'third_subject'=>'required',
            'level'=>'required',
            'combination_name'=>'required|unique:combinations',
            'subsidiary'=>'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return response()->json(['errors'=>$validator->messages()]);

        }
        $subjects = new Subject();
        $comb = Combination::create(
                            array(
                                        'first_subject'=>$subjects->find([$request['first_subject']])->first()->name,
                                        'second_subject'=>$subjects->find([$request['second_subject']])->first()->name,
                                        'third_subject'=>$subjects->find([$request['third_subject']])->first()->name,
                                        'level'=>$request['level'],
                                        'combination_name'=>$request['combination_name'],
                                        'subsidiary'=>$request['subsidiary']
                                    )
                    );
        return response()->json(['success'=>$comb->where('combination_name',$request['combination_name'])->first()->get()]);
    }

    public function getAlevelCombinations()
    {
        return view('manage-combinations.create-a-level');
    }


    public function storeAlevelCombinations(Request $request)
    {
        $rules = [
            'first_subject'=>'required',
            'second_subject'=>'required',
            'third_subject'=>'required',
            'level'=>'required',
            'combination_name'=>'required|unique:combinations',
            'subsidiary'=>'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return response()->json(['errors'=>$validator->messages()]);

        }
        $subjects = new Subject();
        $comb = Combination::create(
                            array(
                                        'first_subject'=>$subjects->find([$request['first_subject']])->first()->name,
                                        'second_subject'=>$subjects->find([$request['second_subject']])->first()->name,
                                        'third_subject'=>$subjects->find([$request['third_subject']])->first()->name,
                                        'level'=>$request['level'],
                                        'combination_name'=>$request['combination_name'],
                                        'subsidiary'=>$request['subsidiary']
                                    )
                    );
        return response()->json(['success'=>$comb->where('combination_name',$request['combination_name'])->first()->get()]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Combination  $combination
     * @return \Illuminate\Http\Response
     */
    public function show(Combination $combination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Combination  $combination
     * @return \Illuminate\Http\Response
     */
    public function edit(Combination $combination)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Combination  $combination
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Combination $combination)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Combination  $combination
     * @return \Illuminate\Http\Response
     */
    public function destroy(Combination $combination)
    {
        //
    }
}
