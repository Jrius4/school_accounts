<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Backend\BackendController;
use App\Http\Resources\SchoolClassResource;
use App\Schstream;
use App\Schclass;
use App\Role;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = new User();
        $roles = new Role();
        return view('manage-teachers.index',compact('teachers','roles'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $teacher)
    {
        $roles = Role::pluck('display_name','id');
        $subjects = Subject::pluck('name','id');
        $classes = Schclass::pluck('name','id');
        $streams = new Schstream();


        return view('manage-teachers.create',compact('teacher','roles','subjects','classes','streams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('manage-teachers.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $teacher)
    {
        $roles = Role::pluck('display_name','id');
        $subjects = Subject::pluck('name','id');
        $classes = Schclass::pluck('name','id');
        $streams = new Schstream();


        return view('manage-teachers.edit',compact('teacher','roles','subjects','classes','streams'));
    }


    public function getAssignedSubjectsToTeacher()
    {
        return view('manage-teachers.assign-subject-to-teacher');
    }

    public function storeAssignedSubjectsToTeacher(Request $request)
    {
        $user = new User();
        $subjects = new Subject();
        $validator = Validator::make($request->all(),[
            'subjects' => 'required',
            'teacher' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json(['errors'=>$validator->messages()]);
        }

        $teacher = $user->find($request['teacher'])->subjects()->detach(Subject::find(explode(',',$request['hidden_subjects'])));
        $teacher = $user->find($request['teacher'])->subjects()->attach(Subject::find(explode(',',$request['hidden_subjects'])));
        return response()->json('done');

        // return response()->json(['success'=>$request->all()]);
    }

    public function getAssignedClassToTeacher()
    {
        return view('manage-teachers.assign-class-to-teacher');
    }

    public function storeAssignedClassToTeacher(Request $request)
    {
        $user = new User();
        $schclass = new Schclass();
        $validator = Validator::make($request->all(),[
            'streams' => 'required',
            'schclasses' => 'required',
            'teacher' => 'required',
            'is_class_teacher'=>'nullable'
        ]);

        if($validator->fails())
        {
            return response()->json(['errors'=>$validator->messages()]);
        }
        if($request['is_class_teacher']!=null)
        {
            $teacher = $user->find($request['teacher'])->update(array('is_class_teacher'=>$request['is_class_teacher']));
            if($request['is_class_teacher']==true)
            {
                if(Schclass::find($request['schclasses'])->user != null)
                {
                    Schclass::find($request['schclasses'])->user->update(array('schclass_id'=>null));
                }
                $teacher = $user->find($request['teacher'])->update(array('schclass_id'=>$request['schclasses']));
            }

        }
        $teacher = $user->find($request['teacher'])->schClasses()->detach(Schclass::find($request['schclasses']));
        $teacher = $user->find($request['teacher'])->schClasses()->attach(Schclass::find($request['schclasses']));
        $teacher = $user->find($request['teacher'])->schStreams()->detach(Schstream::find(explode(',',$request['hidden_streams'])));
        $teacher = $user->find($request['teacher'])->schStreams()->attach(Schstream::find(explode(',',$request['hidden_streams'])));
        return response()->json('done');
    }

    public function createAssignClassTeacherToClasses()
    {
        return view('manage-teachers.assign-class-to-teacher');
    }



    public function manageAssignedClassToTeacher()
    {
        $roles = new Role();
        $teachers = $roles->with('users')->whereName('teacher')->first()->users()->get();
        return view('manage-teachers.manageAssignedClassToTeacher',compact('teachers'));
    }

    public function manageAssignedSubjectToTeacher()
    {
        $roles = new Role();
        $teachers = $roles->with('users')->whereName('teacher')->first()->users()->get();
        return view('manage-teachers.manageAssignedSubjectToTeacher',compact('teachers'));
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

    public function getSubjects(){
        $output = "";
        $roles = new Subject();
        $roles = $roles->pluck('name');
        foreach($roles as $row){
            $output .= '<option value="'.$row.'">'.$row.'</option>';
        }
        return $output;
    }

    public function getRoles()
    {
        $output = "";
        $roles = new Role();
        $roles = $roles->pluck('display_name');
        foreach($roles as $row){
            $output .= '<option value="'.$row.'">'.$row.'</option>';
        }
        return $output;
    }
    public function getClasses()
    {
        $classes = Schclass::paginate(Schclass::count());
        return SchoolClassResource::collection($classes);
    }

    public function getTeacherClasses()
    {
        $output = "";
        $roles = new Role();
        $roles = $roles->pluck('display_name');
        foreach($roles as $row){
            $output .= '<option value="'.$row.'">'.$row.'</option>';
        }
        return $output;
    }

    public function getTeacherClassesStreams()
    {
        $output = "";
        $roles = new Role();
        $roles = $roles->pluck('display_name');
        foreach($roles as $row){
            $output .= '<option value="'.$row.'">'.$row.'</option>';
        }
        return $output;
    }
    public function postRoles(Request $request)
    {
        $rules = [
            "email"=>"email|nullable|unique:users",
            "hidden_classes"=>"required",
            "hidden_role"=>"required",
            "hidden_subject"=>"required",
            "name"=>"required|min:4",
            "username"=>"required|min:5|unique:users",
            "password"=>"confirmed|required|min:6",
            "file"=>"nullable|file",
            "image"=>"nullable|image",
        ];

        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return response()->json(['errors'=>$validator->messages()]);
        }

        $classes=$request['hidden_classes'];
        $classes_array = explode(",",$classes);


        return response()->json(['data' => [$request->all(),'classes'=>$classes_array]]);
    }



}
