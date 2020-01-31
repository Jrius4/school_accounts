@extends('manage-files.layout')
@section('content')

{{-- @include('partials.message') --}}

<div>
    <a href="{{route('files.create')}}" class="btn btn-sm btn-success mb-2">Create File</a>
</div>

<table class="table table-hover table-striped table-success text-primary">
    <thead class="thead-dark">
      <th>Image</th>
      <th>Name</th>
      <th>Author</th>
      <th>View</th>
      <th>Edit</th>
      <th>Delete</th>
    </thead>
    <tbody>
    @if($files->count()>0)
            @foreach ($files as $file)
                <tr>

                <td> <img style="max-height:5vh;max-width:5vw" src="{{asset('images/'.$file->image)}}"/></td>
                    <td>{{$file->name}}</td>
                    <td>{{$file->author}}</td>
                    <td><a href="{{route('files.show',$file->id)}}"><i class="fa fab fa-eye"></i></a></td>
                    <td><a href="{{route('files.edit',$file->id)}}"><i class="fa fab fa-edit"></i></a></td>
                    <td><a href="{{route('files.destroy',$file->id)}}"><i class="fa fab fa-trash"></i></a></td>
                </tr>

            @endforeach
      @else
        <tr>

                <p class="alert alert-warning">No files</p>

        </tr>
      @endif
    </tbody>
    <tfoot>
        <tr>
           <td>Image</td>
           <td>Name</td>
           <td>Author</td>
           <td>View</td>
           <td>Edit</td>
           <td>Delete</td>
        </tr>

    </tfoot>
</table>

@endsection
