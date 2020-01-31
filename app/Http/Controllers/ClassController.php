<?php

namespace App\Http\Controllers;

use App\Schclass;
use App\Schstream;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Schclass::orderBy('id','asc')->with('classStreames')->get();
        return view('manage-classes.index', compact('classes'));
    }

    public function createClass()
    {
        return view('manage-classes.create-class');
    }

    public function createStream()
    {
        return view('manage-classes.create-stream');
    }

    public function storeClass(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'level' => 'required',
        ]);
        if($validator->fails())
        {
            return response()->json(['errors'=>$validator->messages()]);
        }
        $data = $request->all();
        $slug = array('slug'=>str_slug($request['name']));
        $data = array_merge($data,$slug);
        Schclass::create($data);

        return response()->json(['message'=>$request->all()]);

    }
    public function storeStream(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'schclasses' => 'required',
        ]);
        if($validator->fails())
        {
            return response()->json(['errors'=>$validator->messages()]);
        }
        Schstream::create(array('name'=>$request['name'],'slug'=>str_slug($request['name'])))->schoolClasses()->attach(Schclass::find(explode(',',$request['schclasses_hidden'])));


        return response()->json(['message'=>Schstream::with('schoolClasses')->latest()->get()]);
    }

    public function createAssignClassTeacherToClasses()
    {
        return view('manage-classes.create-assign-class-to-classteacher');
    }

    public function storeAssignClassTeacherToClasses(Request $request)
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



    public function fetchStreams(Request $request)
    {
        $classes = new Schclass();
        if($request['action']!=null)
        {
            $output = '';
            if($request['action']=='schclasses')
            {
                $result = $classes->with('classStreames')->where('id',$request['query'])->first()->classStreames()->get();;


                    foreach($result as $row)
                    {
                        $output .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                    }
            }
            if($request['action']=='schclasses1')
            {
                $result = $classes->with('classStreames')->where('id',$request['query'])->first()->classStreames()->get();;
                $output .= '<option value='.null.'>'."select a stream".'</option>';

                    foreach($result as $row)
                    {
                        $output .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                    }
            }

            if($request['action']=='schclasses2')
            {
                $result = $classes->with('classStreames')->where('id',$request['query'])->first()->classStreames()->get();;
                $output .= '<option value='.null.'>'."select a stream".'</option>';

                    foreach($result as $row)
                    {
                        $output .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                    }
            }
            if($request['action']=='schclasses3')
            {
                $result = $classes->with('classStreames')->where('id',$request['query'])->first()->classStreames()->get();;
                $output .= '<option value='.null.'>'."select a stream".'</option>';
                    foreach($result as $row)
                    {
                        $output .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                    }
            }
            return $output;
        }



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
