<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
            $user = Auth::user()->id;
            $tasks = Task::where('user_id',$user)->paginate(10);
        }
        else{
            $tasks = ['unauthorized access'];
        }


       return response()->json(compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::check()){

            $inputs = $request->all();
            $rules = [
                'title'=>'required',
                'start'=>'required',
                'end'=>'required',
            ];
            $validator = Validator::make($inputs,$rules);
            if($validator->fails()){
                $tasks = [
                    'failed'=>true,
                    'message'=>$validator->errors()
                ];

                return response()->json([$tasks]);
            }
            $tasks = new Task();
            $user = Auth::user()->id;
            $tasks->create([
                'title'=>$request->title,
                'detail'=>$request->detail,
                'start'=>$request->start,
                'end'=>$request->end,
                'user_id'=>$user,
            ]);

            $tasks = [
                'success'=>true,
                'message'=>'create successfully',
            ];
            return response()->json(compact('tasks'));

        }
        else{
            $tasks = ['unauthorized access'];
            return response()->json(compact('tasks'));
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = new Task();
        if($task->where('id',$id)->exists()){
            $tasks = $task->find($id);
        }
        else{
            $tasks = ['task no found'];
        }
        return response()->json(compact('tasks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if(Auth::check()){
        $task = new Task();
        if($task->where('id',$id)->exists()){
            $tasks = $task->find($id);
            $tasks->title = isset($request->title)?$request->title:$tasks->title;
            $tasks->detail = isset($request->detail)?$request->detail:$tasks->detail;
            $tasks->start = isset($request->start)?$request->start:$tasks->start;
            $tasks->end = isset($request->end)?$request->end:$tasks->end;
            $tasks->save();

            $tasks = [
                'message'=>'saved successfully',
            ];
        }
        else{
            $tasks = ['task no found'];
        }
        return response()->json(compact('tasks'));

        }
        else{
            $tasks = ['unauthorized'];
            return response()->json(compact('tasks'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::check())
        {
            $task = new Task();
            if($task->where('id',$id)->exists() && Auth::user()->id == $task->where('id',$id)->first()->user_id){
                $tasks = $task->find($id);
                $tasks->delete();
                $tasks = ["deleted successfully"];
            }
            else{
                $tasks = ['task no found'];
            }
            return response()->json(compact('tasks'));
        }
    }
}
