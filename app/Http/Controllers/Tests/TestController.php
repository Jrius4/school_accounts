<?php

namespace App\Http\Controllers\Tests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\UserFollowed;
use App\User;
use App\Comment;
use App\Events\NotificationEvent;

class TestController extends Controller
{
    public $data;

    public function __construct()
    {
        $this->data = '';
    }
    public function index(){
        return view('tests.test-vue');
    }

    public function users()
    {
        $users = User::where('id',"!=",auth()->user()->id)->paginate(5);

        return view('tests.users.index',compact('users'));
    }

    public function follow(User $user)
    {
        $output = '';
        $data = null;
        $follower = auth()->user();
        if ($follower->id == $user->id) {
            return back()->withError("You can't follow yourself");
        }
        if(!$follower->isFollowing($user->id)) {
            $follower->follow($user->id);

            // sending a notification
            // array_push($this->data,json_encode(["user_id"=>auth()->user()->id]));
            $user->notify(new UserFollowed($follower));
            $output = $user->unreadNotifications()->paginate(5);
            $this->data = $output;
            $data = $this->data;
            broadcast(new NotificationEvent($data))->toOthers();
            return back()->withSuccess("You are now friends with {$user->name}");
        }
        return back()->withError("You are already following {$user->name}");
    }

    public function showUser(User $user){
        return view('tests.users.show-user',compact('user'));
    }

    public function showComment(Comment $comment){
        return view('tests.users.show-comment',compact('comment'));
    }

    public function unfollow(User $user)
    {
        $follower = auth()->user();
        if($follower->isFollowing($user->id)) {
            $follower->unfollow($user->id);
            return back()->withSuccess("You are no longer friends with {$user->name}");
        }
        return back()->withError("You are not following {$user->name}");
    }

    public function notifications()
    {
        return  response()->json(auth()->user()->unreadNotifications()->paginate(5));

    }

    public function allNotifications(){
        $allNotifications = "";
        $numberNotifications = 0;
        if(isset(request()->unread)){

            $allNotifications = auth()->user()->unreadNotifications()->paginate(5);
            $numberNotifications = auth()->user()->unreadNotifications()->count();
        }
        else if(isset(request()->already)){
            $allNotifications = auth()->user()->readNotifications()->paginate(5);
            $numberNotifications = auth()->user()->readNotifications()->count();
        }
        else if(request()->unread == null){
            $allNotifications = auth()->user()->notifications()->paginate(5);
            $numberNotifications = auth()->user()->notifications()->count();
        }

        return view('tests.users.all-notifications', compact('allNotifications','numberNotifications'));
        // return response()->json($allNotifications);
    }
}
