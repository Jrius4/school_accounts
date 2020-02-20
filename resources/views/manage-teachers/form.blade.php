@include('manage-teachers.styles')






                    <div class="col-md-8 py-2 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">name</label>
                        {{ Form::text('name',null,['class'=>'form-control col-lg-12 d-block bg-transparent','placeholder'=>'Staff Full Number']) }}
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="col-md-8 py-2 form-group {{ $errors->has('username') ? 'required' : '' }}">
                        <label for="username">username</label>
                        {{ Form::text('username',null,['class'=>'form-control col-lg-12 d-block bg-transparent','placeholder'=>'staff username']) }}
                        @if($errors->has('username'))
                            <span class="text-danger">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="col-md-8 py-2 form-group {{ $errors->has('email') ? 'required' : '' }}">
                        <label for="email">Email</label>
                        {{ Form::email('email',null,['class'=>'form-control col-lg-12 d-block bg-transparent','placeholder'=>'staff member email']) }}
                        @if($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="col-md-8 py-2 form-group {{ $errors->has('password') ? 'required' : '' }}">

                        <div class="">
                            <label for='password'>Passoword</label>
                            {{{ Form::password('password', ['class'=>'form-control', 'placeholder'=>'staff member password', 'aria-describedby'=>'basic-addon2']) }}}

                          </div>
                        @if($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="col-md-8 py-2 form-group {{ $errors->has('password_confirmation') ? 'required' : '' }}">

                        <div class="">
                            <label for='password_confirmation'>Confirm Password</label>
                            {{{ Form::password('password_confirmation', ['class'=>'form-control', 'placeholder'=>'staff member password confirmation', 'aria-describedby'=>'basic-addon2']) }}}

                          </div>
                        @if($errors->has('password_confirmation'))
                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>

                    <div class="col-md-8 py-2 form-group">
                        <label for="roles">Roles</label>
                        <select name="roles" id="roles" multiple class="form-control"></select>
                        <input type="hidden" name="hidden_role" id="hidden_role">
                    </div>

                    <div class="col-md-8 py-2 form-group">
                        <label for="subjects">Subjects</label>
                        <select name="subjects" id="subjects" multiple class="form-control"></select>
                        <input type="hidden" name="hidden_subject" id="hidden_subject">
                    </div>

                    {{-- <div class="col-md-8 py-2 form-group">
                        <label for="classes">Select Class and Streams</label>

                        <div class="treeSelector text-light"></div>
                        <input type="hidden" id="hidden_classes" name="hidden_classes">

                    </div> --}}



                    <div class="col-md-8 py-2 form-group files {{ $errors->has('some_form') ? 'required' : '' }}">
                        <label for="some_form">File</label>
                        <div class="custom-file">
                        {{ Form::file('some_form',['class'=>'form-control col-lg-12 d-block bg-transparent custom-file-input','id'=>'customFile','placeholder'=>'Browser File']) }}

                            <label class="custom-file-label" for="customFile">Browser File</label>
                        </div>
                        @if($errors->has('some_form'))
                            <span class="text-danger">{{ $errors->first('file') }}</span>
                        @endif
                        @if (isset($teacher->some_form))
                        <a href="{{ asset('documents/'.$teacher->some_form) }}" target="_blanck">Open file</a>
                            <embed src="{{ asset('documents/'.$teacher->some_form) }}" style="min-height:450px;" class="col-md-6" />
                        @endif
                    </div>
                    <div class="col-md-8 py-2  form-group files {{ $errors->has('image') ? 'required' : '' }}">
                        <label for="image">Image</label>

                        <div class="custom-file">
                        {{ Form::file('image',['class'=>'form-control col-lg-12 d-block bg-transparent custom-file-input','id'=>'customFile','placeholder'=>'Browser Image']) }}

                            <label class="custom-file-label" for="customFile">Choose Profile Image</label>
                        </div>
                        @if($errors->has('image'))

                            <span class="text-danger">{{ $errors->first('image') }}</span>
                        @endif
                        @if (isset($teacher->file))
                        <div class="col-md-6">
                            <a href="{{ asset('images/'.$teacher->image) }}" target="_blanck">Open Picture</a>
                            <embed src="{{ asset('images/'.$teacher->image) }}" style="max-height:25vh;max-width:25vw"/>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-8 py-2">
                      {{ Form::submit('submit',['class'=>'btn btn-md btn-info d-block col-lg-12']) }}
                    </div>

                @include('manage-teachers.script')

    <style>
        .center-form{
            display: flex;
            justify-content: center;
            width: 90%;
            margin-left: 10vw;
            margin-right: 10vw;

        }

    .chk-class{
    display: flex;
    flex-wrap: wrap;
    padding: 5px;
    height: 250x;

}
    .checklist{
        display: flex;
        flex-wrap: wrap;
        flex-direction: row;
        justify-content: start;
    }
    .chk .input-controls{
        display: flex;
        flex-wrap: wrap;
        color:aliceblue;
    }
    .checked-styled{
        display: inline;
        height: 15px;
        margin: 0.3vw;
        padding: 0.4vw;
    }
    .class-div{
        margin: 5px;
        padding-left: 5px;
    }

.big-label{
    padding-left: 10px;
    padding-top:2px;
}
.checked-styled-stream{
    padding-left: 25px;
    padding-top: 3px

}

    </style>


