<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Events\NewComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class CommentController extends Controller
{
    public function index(){
        // DB::statement('truncate table comments');
        $comments = new Comment();
        $comments = $comments->with('user')->latest()->get();
        return response()->json($comments);
    }

    public function store(Request $request){

        
        
        if(Auth::check()){
            $comment =  Comment::create(array(
                'body'=>$request['body'],
                'user_id'=>Auth::user()->id,
            ));

            $comment = Comment::where('id',$comment->id)->with('user')->first();
            broadcast(new NewComment($comment))->toOthers();
            return response()->json($comment);
        }
        else{
            $comment = "Authorized";
            return response()->json($comment);
        }

        

      


    }

    public function storeComment(Request $request){

        
        
        if(Auth::check()){
            $comment =  Comment::create(array(
                'body'=>$request['body'],
                'user_id'=>Auth::user()->id,
            ));

            $comment = Comment::where('id',$comment->id)->with('user')->first();
            broadcast(new NewComment($comment))->toOthers();
            return redirect()->back()->with(['comment'=>$comment]);
        }
        else{
            $comment = "Authorized";
            return response()->json($comment);
        }

        

      


    }
}
