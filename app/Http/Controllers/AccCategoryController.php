<?php

namespace App\Http\Controllers;

use App\AccCategory;
use Illuminate\Http\Request;

class AccCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accCategories = AccCategory::latest()->get();
        return view('fianance.accountant.category.index',compact('accCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fianance.accountant.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'name'=>'required|unique:acc_categories'
        );
        $request->validate($rules);
        $cat = new AccCategory();
        $cat->name = $request['name'];
        $cat->slug = ($request['name']!=null?str_slug($request['name']):null);
        if($cat->save())
        {
            return redirect()->back()->with(array('message'=>'account category created successfully'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AccCategory  $accCategory
     * @return \Illuminate\Http\Response
     */
    public function show(AccCategory $accCategory)
    {

        return view('fianance.accountant.category.show', compact('accCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AccCategory  $accCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(AccCategory $accCategory)
    {
        return view('fianance.accountant.category.edit');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AccCategory  $accCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccCategory $accCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AccCategory  $accCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccCategory $accCategory)
    {
        $id = $accCategory->id;
        $acc = new AccCategory();
        if($id == $acc->where('name','Main Account')->first()->id || $id == $acc->where('name','Student')->first()->id){
            return redirect()->route('acc-category.index')->with(['action-message'=>'out of delete zone']);
        }
        $accCategory->delete();

        return redirect()->route('acc-category.index')->with(['action-message'=>'deleted successfully']);
    }
}
