


                    <div class="py-2 form-group col-12 {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">name</label>
                        {{ Form::text('name',null,['class'=>'form-control bg-transparent d-block','placeholder'=>'Role Name']) }}
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="py-2 form-group col-12 {{ $errors->has('display_name') ? 'required' : '' }}">
                        <label for="display_name">Display Name</label>
                        {{ Form::text('display_name',null,['class'=>'form-control bg-transparent d-block','placeholder'=>'Role display name']) }}
                        @if($errors->has('display_name'))
                            <span class="text-danger">{{ $errors->first('display_name') }}</span>
                        @endif
                    </div>
                    <div class="py-2 form-group col-12 {{ $errors->has('description') ? 'required' : '' }}">
                        <label for="description">Display Name</label>
                        {{ Form::textarea('description',null,['class'=>'form-control bg-transparent  d-block','placeholder'=>'Description']) }}
                        @if($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        @endif
                    </div>

                    <div class="py-2 col-12">
                      {{ Form::submit($role->exists?'Update':'Create',['class'=>'btn btn-md btn-info d-block col-12']) }}
                      <a href="{{route('roles.index')}}" class="btn btn-md btn-default d-block col-12">cancel</a>
                    </div>

