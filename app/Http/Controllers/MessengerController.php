<?php

namespace App\Http\Controllers;

use App\Events\MessengerEvent;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessengerController extends Controller
{
   public function index(){
        
        $users = DB::select("SELECT A.id,A.name,A.email,A.image,count(is_read) as unread FROM users A LEFT JOIN messages B ON A.id = B.from AND B.to =".auth()->user()->id." WHERE A.id != ".auth()->user()->id." GROUP BY A.id,A.name,A.email,A.image ");
        
        return view('chat.messenger',compact('users'));
    }

    public function getMessages($user_id){
        $my_id = auth()->user()->id;

        Message::where(['from'=>$user_id,'to'=>$my_id])->update(['is_read'=>1]);
        $messages = Message::where(
            function($query) use($user_id,$my_id){
                $query->where('from',$my_id)->where('to',$user_id);
            }
        )->orWhere(
            function($query) use($user_id,$my_id){
                $query->where('from',$user_id)->where('to',$my_id);
            }
        )->get();
        return view('chat.messenger-index',compact('messages'));
    }

    public function sendMessage(Request $request){

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
    }
}
