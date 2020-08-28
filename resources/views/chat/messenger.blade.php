@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Messenger</li>
    </ol>
</nav>


<section class="content">

<section class="container-fluid">

    <div class="row">
        <div class="col-md-4">
            <div class="user-wrapper">
                <ul class="users">
                    @foreach ($users as $user)
                        <li class="user" id="{{$user->id}}">
                            @if($user->unread)
                                <span class="pending">{{$user->unread}}</span>
                            @endif
                            <div class="media">
                                <div class="media-left">
                                    @if(isset($user->image))
                                        <img src="{{asset('files/'.$user->image)}}"  alt="" class="media-object">
                                    @else
                                        <img src="{{asset('files/'.'user_all.png')}}"  alt="" class="media-object">
                                    @endif

                                </div>
                                <div class="media-body">
                                    <p class="name">{{($user->first_name)." ".$user->last_name}}</p>
                                    <p class="email">{{$user->email}}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-md-8" id="messenger">

        </div>


    </div>

</section>



@endsection




@section('style')

<style>
    .breadcrumb{

        background: #fdffffc7;
    }
    .users,.messages{
        padding: 0;
        margin: 0;
    }
    .message, .user{
        list-style: none;

    }
    .user-wrapper, .messenger-wrapper{
        border:1px solid #dddddd;
        overflow-y: auto;

    }
    .user-wrapper{
        height: 600px;
    }

    .user{
        cursor: pointer;
        padding: 5px 0;
        position: relative;
        margin-bottom: 0;
    }
    .user:hover{
        background: #eeeeee
    }
    .user:last-child{
        margin-bottom: 0px;
    }
    .pending{
        position: absolute;
        left:13px;
        top: 9px;
        background: #b610ff;
        margin: 0;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        line-height: 18px;
        padding-left:5px;
        color: #ffffff;
        font-size: 11px;
    }
    .media-left{
        margin: 0 10px;
    }
    .media-left img{
        width: 64px;
        border-radius: 64px;
    }
    .media-body p{
        margin: 6px 0;
    }
    .messenger-wrapper{
        padding: 10px;
        height: 536px;
        background: #eeeeee;
    }
    .messages .message{
        margin-bottom: 15px;
    }
    .messages .message:last-child{
        margin-bottom: 0px;
    }
    .recieved,.sent{
        width: 45%;
        padding: 3px 10px;
        border-radius:10px;
    }
    .recieved{
        background: #ffffff;
    }
    .sent{
        background: #3bebff;
        float: right;

    }
    .sent .date{
        text-align: right;
    }
    .message p{
        margin: 5px 0px;
    }
    .date{
        color: #777777;
        font-size: 11px;
    }
    .active-messenger{
        background: #eeeeee;
    }
    input[type=text]{
        width: 100%;
        padding: 12px 20px;
        margin: 15px 0 0 0;
        display: inline-block;
        border-radius: 4px;
        box-sizing: border-box;
        outline: none;
        border: 1px solid #cccccc;
    }
    input[type=text]:focus{
        border: 1px solid #aaaaaa
    }

</style>

@endsection

@section('others-scripts')
    @include('chat.messenger-script')
@endsection

