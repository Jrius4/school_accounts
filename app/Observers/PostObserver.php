<?php
namespace App\Observers;

use App\Comment;
use App\Events\NotificationEvent;
use App\Notifications\NewPost;

class PostObserver{

    public $data;

    public function __construct()
    {
        $this->data = '';
    }

    public function created(Comment $post){
        $user = $post->user;
        foreach($user->followers as $follower)
        {
            // array_push($this->data,json_encode(["user_id"=>auth()->user()->id,"broadcasting"=>"comments"]));
            $follower->notify(new NewPost($user,$post));
            $output = $follower->unreadNotifications()->paginate(5);
            // array_merge($this->data,$output);
            $this->data=$output;
            $data = $this->data;
            broadcast(new NotificationEvent($data))->toOthers();
        }
    }
}
