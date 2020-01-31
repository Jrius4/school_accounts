

                <div class="row">
                    <div class="col-md-8 py-2 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">name</label>
                        {{ Form::text('name',null,['class'=>'form-control text-success bg-transparent','placeholder'=>'Role Name']) }}
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="col-md-8 py-2 form-group {{ $errors->has('display_name') ? 'required' : '' }}">
                        <label for="display_name">Display Name</label>
                        {{ Form::text('display_name',null,['class'=>'form-control text-success bg-transparent','placeholder'=>'Role display name']) }}
                        @if($errors->has('display_name'))
                            <span class="text-danger">{{ $errors->first('display_name') }}</span>
                        @endif
                    </div>
                    <div class="col-md-8 py-2 form-group {{ $errors->has('description') ? 'required' : '' }}">
                        <label for="description">Display Name</label>
                        {{ Form::textarea('description',null,['class'=>'form-control text-success bg-transparent','placeholder'=>'Description']) }}
                        @if($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                  {{--   <div class="col-md-8 py-2 form-group {{ $errors->has('file') ? 'required' : '' }}">
                        <label for="file">File</label>
                        {{ Form::file('file',['class'=>'form-control text-success bg-transparent','placeholder'=>'Browser File']) }}
                        @if($errors->has('file'))
                            <span class="text-danger">{{ $errors->first('file') }}</span>
                        @endif
                        @if (isset($file->file))
                        <a href="{{ asset('documents/'.$file->file) }}" target="_blanck">Open file</a>
                            <embed src="{{ asset('documents/'.$file->file) }}" style="min-height:450px;" class="col-md-6" />
                        @endif
                    </div>
                    <div class="col-md-8 py-2  form-group {{ $errors->has('image') ? 'required' : '' }}">
                        <label for="image">Image</label>
                        {{ Form::file('image',['class'=>'form-control text-success bg-transparent','placeholder'=>'Browser Image']) }}
                        @if($errors->has('image'))

                            <span class="text-danger">{{ $errors->first('image') }}</span>
                        @endif
                        @if (isset($file->file))
                        <div class="col-md-6">
                            <a href="{{ asset('images/'.$file->image) }}" target="_blanck">Open Picture</a>
                            <embed src="{{ asset('images/'.$file->image) }}" style="max-height:25vh;max-width:25vw"/>
                        </div>
                        @endif
                    </div> --}}
                    <div class="col-md-8 py-2">
                      {{ Form::submit('Create',['class'=>'btn btn-sm btn-info']) }}
                    </div>
                </div>


