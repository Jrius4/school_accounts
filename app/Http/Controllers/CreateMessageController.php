<?php

namespace App\Http\Controllers;

use App\Events\AboutTheUser;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Events\MessengerEvent;

class CreateMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
            $messages = Message::get();
            return view('messages.index',compact('messages'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::check())
        {
            $users = User::latest()->where('id','!=',auth()->user()->id)->get();
            return view('messages.create',compact('users'));
        }
        return view('auth.login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return response()->json([$request->reciever_id,$request->message]);
        if(Auth::check()){

        $from = auth()->user()->id;
        $to = $request->reciever_id;
        $message = $request->message;

        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0;
        $data->save();
        $data= $data->where('to',$to)->orWhere('from',$from)->get()->last()->toArray();
        // $data = ['to'=>$data->to,'from'=>$data->from,'message'=>$data->message,'is_read'=>$data->is_read,'created_at'=>$data->created_at,'updated_at'=>$data->updated_at];

        broadcast(new MessengerEvent($data));

        return redirect()->back()->with(['message'=>'Message sent to '.auth()->user()->name]);

            // $name = Auth::user();
            // $message = Message::create(array(
            //     'sender_id'=>Auth::user()->id,
            //     'message'=>$request->input('message')
            // ));

            // if($name){
            //     //step one:fire the event
            //     event(New AboutTheUser($name));
            // }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        if(Auth::check()){
            $message = Message::find($message->id);

            return view('messages.show',['message'=>$message]);
        }

        return view('auth.login');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    // }
}
