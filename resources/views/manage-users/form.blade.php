

                <div class="">
                    <div class=" py-2 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">name</label>
                        {{ Form::text('name',null,['class'=>'form-control bg-transparent  d-block col-lg-12','placeholder'=>'Staff Full Number']) }}
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class=" py-2 form-group {{ $errors->has('username') ? 'required' : '' }}">
                        <label for="username">username</label>
                        {{ Form::text('username',null,['class'=>'form-control bg-transparent  d-block col-lg-12','placeholder'=>'staff username']) }}
                        @if($errors->has('username'))
                            <span class="text-danger">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class=" py-2 form-group {{ $errors->has('email') ? 'required' : '' }}">
                        <label for="email">Email</label>
                        {{ Form::email('email',null,['class'=>'form-control bg-transparent  d-block col-lg-12','placeholder'=>'staff member email']) }}
                        @if($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class=" py-2 form-group {{ $errors->has('password') ? 'required' : '' }}">

                        <div class="form-group">
                            <label for="password">Password</label>
                            {{{ Form::password('password', ['class'=>'form-control d-block col-lg-12', 'placeholder'=>'staff member password', 'aria-describedby'=>'basic-addon2']) }}}

                          </div>
                        @if($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class=" py-2 form-group {{ $errors->has('password_confirmation') ? 'required' : '' }}">

                        <div class="form-group">
                            <label for="password_confirmation">Password Confirmation</label>
                            {{{ Form::password('password_confirmation', ['class'=>'form-control d-block col-lg-12', 'placeholder'=>'staff member password confirmation', 'aria-describedby'=>'basic-addon2']) }}}

                          </div>
                        @if($errors->has('password_confirmation'))
                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>

                    <div class=" py-2 form-group {{ $errors->has('roles[]') ? 'required' : '' }}">
                        <label for="roles">Select Staff Roles</label>
                        <br/>
                        <select id="roles" class="form-control d-block col-lg-12" name="roles" style="color:aliceblue!important" multiple="multiple">
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->display_name}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('role'))
                            <span class="text-danger">{{ $errors->first('roles[]') }}</span>
                        @endif
                    </div>

                        <input type="hidden" id="hidden_roles" name="hidden_roles">


                    <div class=" py-2 form-group {{ $errors->has('some_form') ? 'required' : '' }}">
                        <label for="some_form">File</label>
                        <div class="custom-file">
                            {{ Form::file('some_form',['class'=>'form-control bg-transparent  d-block col-lg-12 custom-file-input','id'=>'customFile','placeholder'=>'Browser File']) }}
                            <label class="custom-file-label" for="customFile">Choose Form</label>
                        </div>
                        @if($errors->has('some_form'))
                            <span class="text-danger">{{ $errors->first('file') }}</span>
                        @endif
                        @if (isset($user->some_form))
                        <a href="{{ asset('documents/'.$user->some_form) }}" target="_blanck">Open file</a>
                            <embed src="{{ asset('documents/'.$user->some_form) }}" style="min-height:450px;" class="col-md-6" />
                        @endif
                    </div>
                        <div class=" py-2  form-group {{ $errors->has('image') ? 'required' : '' }}">
                        <label for="image">Image</label>

                        <div class="custom-file">
                            {{ Form::file('image',['class'=>'form-control bg-transparent  d-block col-lg-12 custom-file-input','id'=>'customFile','placeholder'=>'Browser Image']) }}
                            <label class="custom-file-label" for="customFile">Choose Profile Image</label>
                        </div>
                        @if($errors->has('image'))

                            <span class="text-danger">{{ $errors->first('image') }}</span>
                        @endif
                        @if (isset($user->file))
                        <div class="form-group">
                            <a href="{{ asset('images/'.$user->image) }}" target="_blanck">Open Picture</a>
                            <embed src="{{ asset('images/'.$user->image) }}" style="max-height:25vh;max-width:25vw"/>
                        </div>
                        @endif
                    </div>
                    <div class=" py-2">
                      <button type="submit" class="btn btn-info d-block col-lg-12"><i class="fa fa-plus"></i> Create Staff</button>
                    </div>
                </div>


    @include('manage-users.scripts')


