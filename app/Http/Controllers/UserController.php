<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Backend\BackendController;
// use App\Http\Requests\Request as RequestsRequest;
// use App\Http\Requests\UserUpdateRequest;
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

    public function __construct()
    {
        parent::__construct();
        $this->uploadPath = public_path('files/');
    }

    public function index()
    {
        $users = User::orderBy('updated_at','asc')->get();
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
        // dd($request->all());
        $user = new User();
        $user->name = $request['name'];
        $user->username = $request['username'];
        $user->password = $request['password'];
        $user->biography = $request['biography'];
        $user->join_as = $request['join_as'];
        $user->entry_date = $request['entry_date'];
        $user->former_school = $request['former_school'];
        if($request['email']!=null){
            $user->email = $request['email'];
        }
        if($request->file('image')!=null){
            $imageName = str_slug(date('c')."_".$request["name"],"_").".".$request->file("image")->getClientOriginalExtension();
            $fullImagePath = $imageName;
            $uploadImagePath = $this->uploadPath;
            $request->file('image')->move(
                $uploadImagePath, $imageName
            );

            $user->image = $fullImagePath;
        }
        if($request->file('some_form')!=null){

            $fileName = str_slug(date('c')."_".$request["name"],"_").".".$request->file("some_form")->getClientOriginalExtension();
            $fullFilePath = $fileName;
            $uploadFilePath = $this->uploadPath;
            $request->file('some_form')->move(
                $uploadFilePath, $fileName
            );

            $user->some_form = $fullFilePath;
        }
        // $slug_array = array('slug'=>str_slug($request['username']));
        // $merged_data = array_merge($data,$slug_array);
        $user->slug = str_slug($request['name'],'_');
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
    public function show(User $user)
    {
        return view('manage-users.show',compact('user'));
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
        $roles = Role::get();
        return view('manage-users.edit',compact('user','roles'));
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

        $user = User::findOrFail($id);
        $rules = [
            'name'=>'required',
            // 'username'=>'required',
            'email'=>'email|nullable',
            'password'=>'nullable|confirmed',
            'roles'=>'required',
            'some_form'=>'file|mimes:pdf,docx,png,jpg,jpeg|max:1024|nullable',
            'image'=>'image|mimes:jpg,jpeg,bmp,png|max:1024|nullable',
        ];
        $request->validate($rules);
        // dd($request->all());

        $user->update(['slug'=>str_slug($request['username'])]);


        ;
        if($request['password']!=null)
        {
            $request->validate(['password'=>'confirmed']);
            $user->update(['password'=>$request['password']]);
        }
        if($request['some_form']!=null)
        {
            $request->validate(['some_form'=>'file|mimes:pdf,docx,png,jpg,jpeg|max:5120']);

            $this->removeImage($user->some_form);
            $fileName = str_slug(date('c')."_".$request["username"],"_").".".$request->file("some_form")->getClientOriginalExtension();
            $fullFilePath = $fileName;
            $uploadFilePath = $this->uploadPath;
            // dd(array($uploadFilePath,$fullFilePath,$fileName));
            $request->file('some_form')->move(
                $uploadFilePath, $fileName
            );
            $user->update(['some_form' => $fullFilePath]);

        }
        if($request['image']!=null)
        {
            $request->validate(['image'=>'image|mimes:jpg,jpeg,bmp,png|max:1024']);

            $this->removeImage($user->image);
            $imageName = str_slug(date('c')."_".$request["username"],"_").".".$request->file("image")->getClientOriginalExtension();
            $fullImagePath = $imageName;
            $uploadImagePath = $this->uploadPath;
            $request->file('image')->move(
                $uploadImagePath, $fullImagePath
            );
            $user->update(['image' => $fullImagePath]);
        }
        $user->update(array(
            'name'=>$request['name'],
            // 'username'=>$request['username'],
            'email'=>$request['email'],
            'name'=>$request['name'],
            'biography'=>$request['biography'],
            'join_as'=>$request['join_as'],
            'entry_date'=>$request['entry_date'],
            'former_school'=>$request['former_school'],
        ));
        if($request['hidden_roles']!=null){

            $roles_array = explode(',',$request['hidden_roles']);
            $user->roles()->detach(Role::find($user->roles()->pluck('id')->toArray()));
            $user->roles()->attach(Role::find($roles_array));

        }

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

        $user->delete();
        return redirect(route('users.index'))->with('message','user deleted successfully');

    }

    private function removeImage($image)
    {
        if ( ! empty($image) )
        {
            $imagePath     = $this->uploadPath . '/' . $image;


            if ( file_exists($imagePath) ) unlink($imagePath);
        }
    }
}
