@extends('layouts.main-dashboard')

@section('dashboard')

 <nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Followers</li>
    </ol>
</nav>


<section class="content">
    <div class="container-fluid">
        <comment-component :user="{{auth()->user()}}"/>


    </div>
    <div class="container row">
        <div class="col-md-8 mx-auto">
            <form action="{{route('comment')}}" method="post">
                @csrf
                <div class="">
                    <div class="form-group d-block">
                        <textarea name="body" class="form-control" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group d-block">
                        <input type="submit" class="btn btn-block btn-info" value="submit"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
{{--
<div class="container" id="app">
    <h4>Web Sockets</h4>
    <div class="col-md-8 mx-auto d-block" v-for="comment in comments">
        <h4> @{{comment.user.name}}...</h4>
        <p>
            @{{comment.body}}
            <br/>
            <small>on @{{comment.created_at}}</small>
        </p>

    </div>
    <div class="col-md-8 mx-auto form-group d-block" v-if="user">
        <textarea row="3" name="body" placeholder="Leave a comment" v-model="commentBox" class="form-control col-12"></textarea>
        <button class="btn btn-block btn-dark" @click.prevent="postComment">Save Comment</button>
    </div>
    <div class="col-md-8 mx-auto form-group d-block" v-else>
        <h4>You must logged in to submit a comment</h4>
        <a href={{route('login')}} class="btn btn-block btn-success">Login Now &gt;&gt;&gt;</a>
    </div>
</div>
@section('others-scripts')
<!--Scripts Others-->
<script type="text/javascript">
    Echo.channel('home')
    .listen('NewMessage',e=>{
        console.log(e.message)
    })
    const app = new Vue({
        el:'#app',
        data:{
            comments:{},
            commentBox:'',
            user:{!! Auth::check()? Auth::user()->toJson():'null'!!},
        },
        mounted(){
            this.getComments();
            this.listen();
        },
        methods:{
            getComments(){
                axios.get('/api/comments/').then((response)=>{
                    this.comments = response.data
                }).catch(err=>console.log(err))
            },
            postComment(){
                axios.post('/api/comment/',{body:this.commentBox},{
                    header:{
                        Authorization:`Bearer ${localStorage.getItem('access_token')}`
                    },
                }).then((response)=>{
                    this.comments.unshift(response.data);
                    this.commentBox = '';
                }).catch(err=>console.log(err))
            },
            listen(){
                Echo.channel('comments')
                .listen('NewComment',(comment)=>{
                    this.comments.unshift(comment);
                })
            }
        }
    })
</script>
@endsection

</section>
 --}}


@endsection
