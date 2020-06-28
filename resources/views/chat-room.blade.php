<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="UTF-8">
        <title>Ratchet WebSocket Chat Sample</title>
        <link rel="stylesheet" href="{{asset('chat/node_modules/bootstrap/dist/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('chat/node_modules/bootstrap/dist/css/bootstrap-theme.min.css')}}">
        <link rel="stylesheet" href="{{asset('chat/css/bootflat.min.css')}}">
        <link rel="stylesheet" href="{{asset('chat/css/style.css')}}">
    </head>
    <body class="container-fluid">
        <div id="loginHolder">
            <div class="form-group">
                <label for="text-name">Enter Name</label>
                <div class="input-group">
                    <input type="text" onkeyup="loginOnEnter(event)" id="text-name" class="form-control">
                    <span class="input-group-addon login-btn" onclick="login()"> Login </span>
                </div>
            </div>
        </div>
        <div id="chatHolder">
            <h3>Hello I'm <span id="me"></span><span id="mekey"></span></h3>
        </div>
        <ul class="nav nav-pills nav-stacked col-md-2" id="onlineUsers">
        </ul>
        <div class="tab-content col-md-10" id="userChat">
        </div><!-- tab content -->
        <div>
        </div>
        {{-- <script src="{{asset('js/app.js')}}"></script> --}}
        <script src="{{asset('chat/js/jquery.min.js')}}"></script>
        <script src="{{asset('chat/node_modules/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('chat/js/icheck.min.js')}}"></script>
        <script src="{{asset('chat/js/jquery.fs.selecter.min.js')}}"></script>
        <script src="{{asset('chat/js/jquery.fs.stepper.min.js')}}"></script>
        <script src="{{asset('chat/js/main.js')}}"></script>
    </body>
</html>
