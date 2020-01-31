

                <div class="row">
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

                        <div class="form-group">
                            <label for="password">Password</label>
                            {{{ Form::password('password', ['class'=>'form-control', 'placeholder'=>'staff member password', 'aria-describedby'=>'basic-addon2']) }}}

                          </div>
                        @if($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="col-md-8 py-2 form-group {{ $errors->has('password_confirmation') ? 'required' : '' }}">

                        <div class="form-group">
                            <label for="password_confirmation">Password Confirmation</label>
                            {{{ Form::password('password_confirmation', ['class'=>'form-control', 'placeholder'=>'staff member password confirmation', 'aria-describedby'=>'basic-addon2']) }}}

                          </div>
                        @if($errors->has('password_confirmation'))
                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>

                    <div class="col-md-8 py-2 form-group chk {{ $errors->has('roles[]') ? 'required' : '' }}">
                        <label for="roles[]">Select Staff Roles</label>

                        <select id="roles" class="form-control" class="col-sm-12" style="color:aliceblue!important" multiple="multiple"></select>
                        <input type="hidden" id="hidden_roles" name="hidden_roles">

{{--
                                @foreach ($roles as $item)

                                    @if ($user->id && $user->whereId($user->id)->with('roles')->first()->roles->count()!=null)
                                        @foreach ($user->whereId($user->id)->with('roles')->first()->roles as $role)
                                            @if ($role->display_name == $item)
                                                <div class="input-controls">
                                                    <div class="checked-styled">
                                                        {!! Form::checkbox('roles[]', $role->display_name,true)!!}  {!! Form::label($role->display_name, '   '.$role->display_name) !!}
                                                    </div>
                                                </div>
                                            @endif


                                        @endforeach

                                        @if ($user->whereId($user->id)->with('roles')->first()->roles->first()->display_name != $item)
                                            <div class="input-controls">
                                                <div class="checked-styled">
                                                    {!! Form::checkbox('roles[]', $item,null)!!}  {!! Form::label($item, '   '.$item) !!}
                                                </div>
                                            </div>
                                        @endif






                                    @elseif ($user->id && $user->whereId($user->id)->with('roles')->first()->roles->count()==null)
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
                                @endforeach --}}














                        @if($errors->has('role'))
                            <span class="text-danger">{{ $errors->first('roles[]') }}</span>
                        @endif
                    </div>
                    <div class="col-md-8 py-2 form-group {{ $errors->has('some_form') ? 'required' : '' }}">
                        <label for="some_form">File</label>
                        {{ Form::file('some_form',['class'=>'form-control text-success bg-transparent','placeholder'=>'Browser File']) }}
                        @if($errors->has('some_form'))
                            <span class="text-danger">{{ $errors->first('file') }}</span>
                        @endif
                        @if (isset($user->some_form))
                        <a href="{{ asset('documents/'.$user->some_form) }}" target="_blanck">Open file</a>
                            <embed src="{{ asset('documents/'.$user->some_form) }}" style="min-height:450px;" class="col-md-6" />
                        @endif
                    </div>
                    <div class="col-md-8 py-2  form-group {{ $errors->has('image') ? 'required' : '' }}">
                        <label for="image">Image</label>
                        {{ Form::file('image',['class'=>'form-control text-success bg-transparent','placeholder'=>'Browser Image']) }}
                        @if($errors->has('image'))

                            <span class="text-danger">{{ $errors->first('image') }}</span>
                        @endif
                        @if (isset($user->file))
                        <div class="col-md-6">
                            <a href="{{ asset('images/'.$user->image) }}" target="_blanck">Open Picture</a>
                            <embed src="{{ asset('images/'.$user->image) }}" style="max-height:25vh;max-width:25vw"/>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-8 py-2">
                      <button type="submit" class="btn btn-info"><i class="fa fa-plus"></i> Create Staff</button>
                    </div>
                </div>

    <style>
        textarea{
            color:white !important;
        }
    .chk .input-controls{
        display: flex;
        flex-wrap: wrap;
        color:aliceblue
    }
    .checked-styled{
        display: inline;
        height: 15px;
        margin: 0.3vw;
        padding: 0.4vw
    }

    </style>
    @include('manage-users.scripts')


