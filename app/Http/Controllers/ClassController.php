<?php

namespace App\Http\Controllers;

use App\Role;
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

    public function getAllstreams()
    {
        $schstream=Schstream::get();
        return view('manage-classes.get-all-streams',compact('schstream'));
    }
    public function deleteStream($id)
    {
        $schstream = Schstream::findOrFail($id);
        foreach($schstream->schoolclasses()->get() as $res)
        {
            $res->classStreames()->detach($schstream);
        }
        $schstream->delete();
        return redirect('all-streams')->with(['message'=>'deleted successfully']);
    }

    public function createStream()
    {
        $schclasses = Schclass::get();
        return view('manage-classes.create-stream',compact('schclasses'));
    }
    public function editStream($id)
    {
        $schclasses = Schclass::get();
        $schstream = Schstream::findOrFail($id);
        return view('manage-classes.edit-stream',compact('schclasses','schstream'));
    }
    public function updateStream(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'classes' => 'required',
            'stream_id' => 'required',
        ]);
        $schstream = Schstream::findOrFail($request['stream_id']);
        foreach($schstream->schoolclasses()->get() as $res)
        {
            $res->classStreames()->detach($schstream);
        }
        if($validator->fails())
        {
            return response()->json(['errors'=>$validator->messages()]);
        }
        $schstream->name = $request['name'];
        $schstream->slug = str_slug($request['name']);
        if($schstream->save())
        {
            $schstream->schoolClasses()->attach(Schclass::find(explode(',',$request['schclasses_hidden'])));
            return response()->json('success');
        }

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
        // return response()->json('success');

    }



    public function storeStream(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:schstreams',
            'classes' => 'required',
        ]);
        if($validator->fails())
        {
            return response()->json(['errors'=>$validator->messages()]);
        }
        Schstream::create(array('name'=>$request['name'],'slug'=>str_slug($request['name'])))->schoolClasses()->attach(Schclass::find(explode(',',$request['schclasses_hidden'])));


        // return response()->json(['message'=>Schstream::with('schoolClasses')->latest()->get()]);
        return response()->json('success');

    }

    public function createAssignClassTeacherToClasses()
    {
        $schclasses = Schclass::get();
        $teachers = Role::whereName('teacher')->first()->users()->get();
        return view('manage-classes.create-assign-class-to-classteacher',compact('schclasses','teachers'));
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
                // if(Schclass::find($request['schclasses'])->user !== null)
                // {
                //     Schclass::find($request['schclasses'])->user->update(array('schclass_id'=>null));
                // }
                Schclass::findOrFail($request['schclasses'])->update(['user_id'=>$request['teacher']]);
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
        // return response()->json(['response'=>$request->all()]);

        if($request['action']!==null)
        {
            $output ='';
            if($request["action"] == "schclasses12")
            {
                $output.='<option value="">Select a stream</option>';
                $result = $classes->where('id',$request['query'])->first()->classStreames()->get();
                foreach($result as $row)
                {
                    $output.='<option value="'.$row['id'].'">'.$row['name'].'</option>';
                }
            }
            if($request["action"] == "schclasses34")
            {
                $output.='<option value="">Select a stream</option>';
                $result = $classes->where('id',$request['query'])->first()->classStreames()->get();
                foreach($result as $row)
                {
                    $output.='<option value="'.$row['id'].'">'.$row['name'].'</option>';
                }

            }
            if($request["action"] == "schclasses56")
            {
                $output.='<option value="">Select a stream</option>';
                $result = $classes->where('id',$request['query'])->first()->classStreames()->get();
                foreach($result as $row)
                {
                    $output.='<option value="'.$row['id'].'">'.$row['name'].'</option>';
                }

            }
            return $output;
        }
        else{
            return response()->json(['errors'=>'please select a class']);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Schclass $schclass)
    {
        return view('manage-classes.create', compact('schclass'));
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
            'name'=> 'required',
            'level'=> 'required',
        );
        $request->validate($rules);
        $schclass= new Schclass();
        $schclass->name = $request['name'];
        $schclass->slug = str_slug($request['name']);
        $schclass->level = $request['level'];
        if($schclass->save())
        {
            return redirect()->route('classes.index')->with(['message'=>'Class Created Successfully']);
        }
        else{
            return redirect()->route('classes.create')->with(['message'=>'Class Failed']);

        }
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
        $schclass=Schclass::findOrFail($id);
        return view('manage-classes.edit',compact('schclass'));
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
        $schclass = Schclass::findOrFail($id);
        $rules = array(
            'name'=> 'required',
            'level'=> 'required',
        );
        $request->validate($rules);
        $schclass->name = $request['name'];
        $schclass->slug = str_slug($request['name']);
        $schclass->level = $request['level'];
        if($schclass->save())
        {
            return redirect()->route('classes.index')->with(['message'=>'Class Updated Successfully']);
        }
        else{
            return redirect()->route(['classes.edit',$schclass->id])->with(['message'=>'Class Failed']);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schclass = Schclass::findOrFail($id);
        $schclass->delete();
        return redirect()->route('classes.index')->with(['message'=>'Class deleted Successfully']);

    }
}
