<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Backend\BackendController;
use App\Http\Requests\UserUpdateRequest;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->latest()->get();
        return view('manage-users.index')->with(compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        $roles = Role::get();

        return view('manage-users.create')->with(compact('user','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store (Request $request){
        // dd($request->all());
        $rules = [
            'name'=>'required',
            'username'=>'required|unique:users',
            'email'=>'email|nullable|unique:users',
            'password'=>'required|confirmed',
            'roles'=>'required',
            'password'=>'required|confirmed',
            'password'=>'required|confirmed',
            'some_form'=>'required|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:2048',
            'image'=>'required|image|mimes:jpg,jpeg,bmp,png|max:1024',
        ];


        $request->validate($rules);
        $data = $request->all();
        $user = new User();
        $user->name = $request['name'];
        $user->username = $request['username'];
        $user->password = $request['password'];
        if($request['email']!=null){
            $user->email = $request['email'];
        }
        if($request->file('image')!=null){
            $imageName = str_slug($request["name"],"__").".".$request->file("image")->getClientOriginalExtension();
            $fullImagePath = $imageName;
            $uploadImagePath = public_path('images/');
            $request->file('image')->move(
                $uploadImagePath, $imageName
            );

            $user->image = $fullImagePath;
        }
        if($request->file('some_form')!=null){

            $fileName = str_slug($request["name"],"__").".".$request->file("some_form")->getClientOriginalExtension();
            $fullFilePath = $fileName;
            $uploadFilePath = public_path('files/');
            $request->file('some_form')->move(
                $uploadFilePath, $fileName
            );

            $user->some_form = $fullFilePath;
        }
        $slug_array = array('slug'=>str_slug($request['username']));
        $merged_data = array_merge($data,$slug_array);
        $user->slug = $merged_data['slug'];
        $user->save();
        if($request['hidden_roles']!=null){

            $roles_array = explode(',',$request['hidden_roles']);
            $user->where('username',$request['username'])->first()->roles()->attach(Role::find($roles_array));

        }

        return redirect()->route('users.index')->with('message','user created successfully');


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
        $user = User::findOrFail($id);
        $roles = Role::pluck('display_name','id');
        return view('manage-users.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect(route('users.index'))->with('message','user updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // dd($user);
        $user->delete();
        return redirect(route('users.index'))->with('message','user deleted successfully');

    }
}
