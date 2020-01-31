

                <div class="row d-flex justify-content-center bg-dark">
                    <div class="col-md-8 py-2 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">Username</label>
                        {{ Form::text('name',null,['class'=>'form-control text-success bg-transparent','placeholder'=>'Username']) }}
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="col-md-8 py-2 form-group {{ $errors->has('author') ? 'required' : '' }}">
                        <label for="author">Author Name</label>
                        {{ Form::text('author',null,['class'=>'form-control text-success bg-transparent','placeholder'=>'Book Author']) }}
                        @if($errors->has('author'))
                            <span class="text-danger">{{ $errors->first('author') }}</span>
                        @endif
                    </div>
                    <div class="col-md-8 py-2 form-group {{ $errors->has('file') ? 'required' : '' }}">
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
                    </div>
                    <div class="col-md-8 py-2">
                      {{ Form::submit('Upload',['class'=>'btn btn-sm btn-info']) }}
                    </div>
                </div>


