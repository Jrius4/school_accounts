


                    <div class=" py-2 form-group col-12 {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">name</label>
                        {{ Form::text('name',null,['class'=>'form-control bg-transparent  d-block col-12','placeholder'=>'Staff Full Number']) }}

                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class=" py-2 form-group col-12 {{ $errors->has('username') ? 'required' : '' }}">
                        <label for="username">username</label>
                        {{ Form::text('username',null,['class'=>'form-control bg-transparent  d-block col-12',( $user->exists ?'readonly' :null),'placeholder'=>'staff username']) }}
                        @if($errors->has('username'))
                            <span class="text-danger">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class=" py-2 form-group col-12 {{ $errors->has('email') ? 'required' : '' }}">
                        <label for="email">Email</label>
                        {{ Form::email('email',null,['class'=>'form-control bg-transparent  d-block col-12','placeholder'=>'staff member email']) }}
                        @error('email')
                        <span class="text-danger">{{$message}}</span>

                        @enderror
                        <small class="text-info">Email input optional</small>

                    </div>

                    <div class=" py-2 form-group col-12 {{ $errors->has('password') ? 'required' : '' }}">


                            <label for="password">Password</label>
                            {{{ Form::password('password', ['class'=>'form-control d-block col-12', 'placeholder'=>'staff member password', 'aria-describedby'=>'basic-addon2']) }}}


                        @if($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class=" py-2 form-group col-12 {{ $errors->has('password_confirmation') ? 'required' : '' }}">


                            <label for="password_confirmation">Password Confirmation</label>
                            {{{ Form::password('password_confirmation', ['class'=>'form-control d-block col-12', 'placeholder'=>'staff member password confirmation', 'aria-describedby'=>'basic-addon2']) }}}


                        @error('password')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <small class="text-info">Password match</small>

                    </div>
                    <div class=" py-2 form-group col-12 {{ $errors->has('join_as') ? 'required' : '' }}">
                        <label for="join_as">Join as</label>
                        {{ Form::text('join_as',null,['class'=>'form-control bg-transparent  d-block col-12','placeholder'=>'joining as']) }}
                        @error('join_as')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <small class="text-info">professional Level of new Staff</small>

                    </div>

                    <div class=" py-2 form-group col-12 {{ $errors->has('entry_date') ? 'required' : '' }}">
                        <label for="entry_date">Entry Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                                {{ Form::text('entry_date',null,['class'=>'form-control bg-transparent  d-block col-12 entry_date','placeholder'=>'entry date','data-mask','data-inputmask-inputformat'=>'dd/mm/yyyy','data-inputmask-alias'=>'datetime','id'=>'datemask']) }}
                            </div>
                            <!-- /.input group -->
                          </div>
                          <!-- /.form group -->
                        @error('entry_date')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class=" py-2 form-group col-12 {{ $errors->has('former_school') ? 'required' : '' }}">
                        <label for="former_school">former school</label>
                        {{ Form::text('former_school',null,['class'=>'form-control bg-transparent  d-block col-12 former_school','placeholder'=>'former school']) }}
                        @error('former_school')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <small class="text-info">Previous School</small>

                    </div>

                    <div class=" py-2 form-group col-12 {{ $errors->has('biography') ? 'required' : '' }}">
                        <label for="biography">Biography</label>
                        {{ Form::textarea('biography',null,['class'=>'form-control bg-transparent  d-block col-12 biography','col'=>'2','row'=>'3','placeholder'=>'former school']) }}

                        @error('biography')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <small class="text-info">Backgroud Information of new staff</small>

                    </div>

                    <div class=" py-2 form-group col-12 {{ $errors->has('roles') ? 'required' : '' }}">
                        <label for="roles">Select Staff Roles</label>

                        <select id="roles" class="form-control d-block roles col-12 @error('roles') is-invalid @enderror" name="roles" style="color:aliceblue!important" multiple="multiple">
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}" @if(old('hidden_roles')) @if(in_array($role->id,explode(',',old('hidden_roles')))) selected @endif @endif @if($user->exists) @if(in_array($role->id,$user->roles()->pluck('id')->toArray())) selected @endif @endif>{{$role->display_name}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('roles'))
                            <span class="text-danger">{{ $errors->first('roles') }}</span>
                        @endif
                        <small class="text-info">Can select more than one role!</small>
                        <input type="hidden" id="hidden_roles" name="hidden_roles">
                    </div>




                    <div class=" py-2 form-group col-12 {{ $errors->has('some_form') ? 'required' : '' }}">
                        <label for="some_form">CV/Resume/Certicates</label>
                        <div class="custom-file">
                            {{ Form::file('some_form',['class'=>'form-control bg-transparent  d-block col-12 custom-file-input','id'=>'customFile','placeholder'=>'Browser File']) }}
                            <label class="custom-file-label" for="customFile">Choose Form</label>
                        </div>
                        <small class="text-info">Documents Required!</small>

                        @error('some_form')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @if (isset($user->some_form))
                        <a href="{{ asset('files/'.$user->some_form) }}" target="_blanck">Open file</a>
                            <embed src="{{ asset('files/'.$user->some_form) }}" style="min-height:450px;" class="col-12" />
                        @endif
                    </div>
                    <div class=" py-2  form-group col-12 {{ $errors->has('image') ? 'required' : '' }}">
                        <label for="image">Profile Picture</label>

                        <div class="custom-file">
                            {{ Form::file('image',['class'=>'form-control bg-transparent  d-block col-12 custom-file-input','id'=>'customFile','placeholder'=>'Browser Image']) }}
                            <label class="custom-file-label" for="customFile">Choose Profile Image</label>
                        </div>
                        <small class="text-info">Profile Picture required Required!</small>
                        @error('image')
                            <span class="text-danger">{{$message}}</span>
                        @enderror

                        @if (isset($user->image))
                        <div class="form-group col-12">
                            <a href="{{ asset('files/'.$user->image) }}" target="_blanck">Open Picture</a>
                            <embed src="{{ asset('files/'.$user->image) }}" style="max-height:75px;max-width:75px"/>
                        </div>
                        @endif
                    </div>

                    <div class="form-group col-12 d-block">
                        <label>Set Salary</label>
                        {{ Form::number('wage_salary',null,['class'=>'form-control bg-transparent  d-block col-12','placeholder'=>'Enter Salary']) }}

                    </div>

                    <div class="form-group col-12 d-block">
                        <label>Salary Paid</label>
                        {{ Form::number('wage_paid',null,['class'=>'form-control bg-transparent  d-block col-12','placeholder'=>'Enter Payment']) }}

                    </div>

                    <div class="form-group col-12 d-block">
                        <label>Salary Balance</label>
                        {{ Form::number('wage_balance',null,['class'=>'form-control bg-transparent  d-block col-12','placeholder'=>'Salary Balance','disabled']) }}

                    </div>

                    <div class="form-group col-12 d-block">
                        <label>Recieve Loan</label>
                        {{ Form::number('wage_loan',null,['class'=>'form-control bg-transparent  d-block col-12','placeholder'=>'Enter Salary Loan']) }}

                    </div>

                    <div class="form-group col-12 d-block">
                        <label>Recieve Upfront</label>
                        {{ Form::number('wage_upfront',null,['class'=>'form-control bg-transparent  d-block col-12','placeholder'=>'Enter Salary Upfront']) }}

                    </div>

                    <div class="form-group col-12">
                      <button type="submit" class="btn btn-info d-block col-12">@if($user->exists)<i class="fa fa-edit"></i> Update @else<i class="fa fa-plus"></i> Create @endif Staff</button>
                      <a href="{{route('users.index')}}" class="btn btn-md btn-default d-block col-12">cancel</a>
                    </div>





    {{-- @include('manage-users.scripts') --}}


