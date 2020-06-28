@extends('app')

@section('content')

    <div class="flex-center position-ref full-height">

        <div class="content">
            <h2 class="title m-b-md" style="background: #0e3d08;color:white;padding:8pt">
                Listings
            </h2>

            <div class="row">
                <div class="col-8 mx-auto">
                    <form action="" name="publish" method="POST">
                        <input type="hidden" name="sender" value="{{isset(Auth::user()->id)?1:8}}">
                        <div class="form-group d-block">
                            <input type="text" name="reciever" placeholder="Enter Sender" class="form-control col-12"/>
                        </div>
                        <div class="from-group d-block">
                            <textarea  class="form-control col-12"  name="message" cols="30" rows="6" placeholder="Enter Message"></textarea>
                        </div>
                            <div class="form-group d-block my-2">
                                <input class="btn btn-block btn-success col-12" type="submit" value="Send"/>
                            </div>
                    </form>
                </div>
                <div class="col-8 mx-auto" id="messages"></div>
                @if ($listings != null)
                    @foreach($listings as $listing)
                        <article class="col-md-10">
                            <h4><a style="color: #0e3d08;" class="" href="{{ url('details/' . $listing->id) }}">{{ $listing->title }}</a></h4>
                            <img src="{{ $listing->image }}" width="250" class="pull-left img-responsive thumb img-thumbnail" />
                            <p>
                                {{ substr($listing->description, 0, 50) }}
                            </p>
                        </article>
                        <hr/>
                    @endforeach
                @endif

            </div>
        </div>
    </div>

@endsection
@section('script')
<script type="text/javascript">
    var conn = new WebSocket('ws://schools.dev.com:8090');
    conn.addEventListener('open',function(event){
        console.log('Connection established!');
        conn.send('Hello server!');
        // conn.send(JSON.stringify({command: "register", userId: 1}));


        // conn.send(JSON.stringify({command: "register", userId: 1}));

        // conn.send(JSON.stringify({command: "register", userId: 9}));

        // conn.send(JSON.stringify({command: "message", from:"9", to: "1", message: "Hello"}));
        // conn.send(JSON.stringify({command: "subscribe", channel: "global"}));
        // conn.send(JSON.stringify({command: "groupchat", message: "hello glob", channel: "global"}));

    });
    conn.addEventListener('message',function (event) {
        console.log('message from server:',event.data);
        let message = event.data;
        let messageElem = document.createElement('div');
        // console.log(JSON.parse(message))
        messageElem.textContent= JSON.parse(message).message;
        document.getElementById('messages').prepend(messageElem)
    })

    conn.addEventListener('close',function(event){
        if(event.wasClean){
            alert(`[close] Connection closed cleanly, code:${event.code} reason=${event.reason}`)
        }else{
            alert(`[close] connection died`)
        }
    })
    conn.addEventListener('error',function (event) {
        console.log('[error]',event.message);
    })
    document.forms.publish.onsubmit = function(){
        /**
        conn.send(JSON.stringify({command: "register", userId: 1}));

        conn.send(JSON.stringify({command: "register", userId: 9}));

        conn.send(JSON.stringify({command: "message", from:"9", to: "1", message: "Hello"}));
        conn.send(JSON.stringify({command: "subscribe", channel: "global"}));
        conn.send(JSON.stringify({command: "groupchat", message: "hello glob", channel: "global"}));
        */



        let outgoingMessage = this.message.value;
        let sender = this.sender.value;
        let reciever = this.reciever.value;
        conn.send(JSON.stringify({command: "register", userId: sender}));

        conn.send(JSON.stringify({command: "register", userId: reciever}));
        conn.send(JSON.stringify({command: "message", from:sender, to: reciever, message: outgoingMessage}));

        this.message.value ='';
        this.reciever.value ='';
        return false;
    }
    // conn.close();
    // conn.onopen = function(e){
    //         console.log('Connection established!');
    //         conn.send('Hello server!');


    //     };
    // conn.send(JSON.stringify({command: "register", userId: 1}));


    /**
        conn.onopen = function(e) {
            console.log("Connection established!");
        };
        conn.onmessage = function(e) {
            console.log(e.data);
        };

        conn.send(JSON.stringify({command: "register", userId: 1}));

        conn.send(JSON.stringify({command: "register", userId: 9}));

        conn.send(JSON.stringify({command: "message", from:"9", to: "1", message: "Hello"}));
        conn.send(JSON.stringify({command: "subscribe", channel: "global"}));
        conn.send(JSON.stringify({command: "groupchat", message: "hello glob", channel: "global"}));
    */

    // conn.close();
</script>

@endsection
