@include('manage-teachers.styles')

                <div class="container center-form">
                    <span id="feauture"></span>
                </div>
                <div class="container row  center-form">
                    <div class="col-12">


                    <div class="col-md-8 py-2 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">name</label>
                        {{ Form::text('name',null,['class'=>'form-control text-success bg-transparent','placeholder'=>'Staff Full Number']) }}
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="col-md-8 py-2 form-group {{ $errors->has('username') ? 'required' : '' }}">
                        <label for="username">username</label>
                        {{ Form::text('username',null,['class'=>'form-control text-success bg-transparent','placeholder'=>'staff username']) }}
                        @if($errors->has('username'))
                            <span class="text-danger">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="col-md-8 py-2 form-group {{ $errors->has('email') ? 'required' : '' }}">
                        <label for="email">Email</label>
                        {{ Form::email('email',null,['class'=>'form-control text-success bg-transparent','placeholder'=>'staff member email']) }}
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
{{--


                    <div class="col-md-8 py-2 form-group chk {{ $errors->has('roles[]') ? 'required' : '' }}">
                        <label for="roles[]">Select Staff Roles</label>

                                    <div class="checklist">
                                        @foreach ($roles as $item)
                                            @if ($teacher->id && $teacher->whereId($teacher->id)->with('roles')->first()->roles->count()!=null)
                                            @foreach ($teacher->whereId($teacher->id)->with('roles')->first()->roles as $role)
                                                @if ($role->display_name == $item)
                                                    <div class="input-controls">
                                                        <div class="checked-styled">
                                                            {!! Form::checkbox('roles[]', $role->display_name,true)!!}  {!! Form::label($role->display_name, '   '.$role->display_name) !!}
                                                        </div>
                                                    </div>
                                                @endif


                                            @endforeach

                                            @if ($teacher->whereId($teacher->id)->with('roles')->first()->roles->first()->display_name != $item)
                                                <div class="input-controls">
                                                    <div class="checked-styled">
                                                        {!! Form::checkbox('roles[]', $item,null)!!}  {!! Form::label($item, '   '.$item) !!}
                                                    </div>
                                                </div>
                                            @endif






                                        @elseif ($teacher->id && $teacher->whereId($teacher->id)->with('roles')->first()->roles->count()==null)
                                        <div class="input-controls">
                                            <div class="checked-styled">
                                                {!! Form::checkbox('roles[]', $item,null)!!}  {!! Form::label($item, '   '.$item) !!}
                                            </div>
                                        </div>
                                        @else
                                        <div class="input-controls">

                                            <div class="checked-styled">
                                                {!! Form::checkbox('roles[]', $item,null)!!}  {!! Form::label($item, '   '.$item) !!}
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                    </div>




                        @if($errors->has('role'))
                            <span class="text-danger">{{ $errors->first('roles[]') }}</span>
                        @endif
                    </div>


                     --}}

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

                    <div class="col-md-8 py-2 form-group">
                        <label for="classes">Select Class and Streams</label>

                        <div class="treeSelector text-secondary"></div>
                        <input type="hidden" id="hidden_classes" name="hidden_classes">

                    </div>


{{--

                    <div class="col-md-8 py-2 form-group chk {{ $errors->has('subjects[]') ? 'required' : '' }}">
                        <label for="subjects[]">Select Subjects</label>
                        <div class="checklist">
                            @foreach ($subjects as $subject)
                                <div class="input-controls">
                                    <div class="checked-styled">
                                        {!! Form::checkbox('subjects[]', $subject,null)!!}  {!! Form::label($subject, '   '.$subject) !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                    <div class="col-md-8 py-2 form-group  {{ $errors->has('classes[]') ? 'required' : '' }}">
                        <label for="classes[]">Select Classes</label>
                        <div class="class-div">
                            @foreach ($classes as $i=>$class)

                                <div class="chk-class">

                                    <div class="input-controls">
                                        <div class="checked-styled-class">
                                            {!! Form::checkbox('classes[]', $class,null)!!}  {!! Form::label($class, '   '.$class) !!}
                                        </div>
                                    </div>

                                    @if ($streams->where('school_class_id',$i))

                                        <div class="checklist-streams">
                                            <label class="big-label" for="streams[]">Select Streams</label>
                                            @foreach ($streams->where('school_class_id',$i)->pluck('name','id') as $i=>$stream)
                                                <div class="input-controls">
                                                    <div class="checked-styled-stream">
                                                        {!! Form::checkbox('streams[]', $stream,null)!!}  {!! Form::label($stream, '   '.$stream) !!}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    @endif

                                </div>


                            @endforeach
                        </div>

                    </div> --}}
                    <div class="col-md-8 py-2 form-group files {{ $errors->has('some_form') ? 'required' : '' }}">
                        <label for="some_form">File</label>
                        {{ Form::file('some_form',['class'=>'form-control text-success bg-transparent','id'=>'file','placeholder'=>'Browser File']) }}
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
                        {{ Form::file('image',['class'=>'form-control text-success bg-transparent','id'=>'image','placeholder'=>'Browser Image']) }}
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
                      {{ Form::submit('submit',['class'=>'btn btn-sm btn-info']) }}
                    </div>
                </div>
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


