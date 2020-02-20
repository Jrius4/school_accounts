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
        // $roles = Role::pluck('display_name','id');
        // dd($roles);
        return view('manage-users.create')->with(compact('user','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $rules = [
    //         'name'=>'required',
    //         'username'=>'required|unique:users',
    //         'email'=>'email|nullable',
    //         'password'=>'required|confirmed',
    //         'roles'=>'acceptable',
    //         'file'=>'max:1024',
    //         'image'=>'mimes:jpg,jpeg,bmp,png|max:1024',
    //     ];


    //     $this->validate($request,$rules);
    //     // $array = $request->input('roles');
    //     $array2=[];

    //     $roles = Role::get();

    //     // dd($array,$array2);

    //     // dd($request->input('roles'));
    //     $user = new User();
    //     if($request->input('roles')!=null){
    //         foreach($request->input('roles') as $item)
    //     {
    //         array_push($array2 ,$roles->where('display_name',$item)->first()->id);
    //     }
    //     // dd($request->input('roles'));

    //         $user->create($request->all())->roles()->attach(array_slice($array2,0));
    //         // dd($user->with('roles')->where('username',$request->input('username'))->first());
    //     }
    //     else{
    //        $user->create($request->all());
    //     }



    //     return redirect(route('users.index'))->with('message','user created successfully');
    // }

    public function store (Request $request){
        $rules = [
            'name'=>'required',
            'username'=>'required|unique:users',
            'email'=>'email|nullable|unique:users',
            'password'=>'required|confirmed',
            'some_form'=>'max:1024',
            'image'=>'mimes:jpg,jpeg,bmp,png|max:1024',
        ];
        // return response()->json($request->all());
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->messages()]);
        }
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

        return response()->json(['message'=>"user created successfully"]);

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
    public function edit(User $user)
    {
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
