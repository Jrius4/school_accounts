@extends('manage-tests.layout')
@section('content')



        <div class="row">
        <a href="{{route('to-checks.create')}}" class="btn btn-warning">Create</a>
        </div>

        <div class="row">
                @include('partials.message')
            </div>

        <table class="table table-hover table-striped table-light text-success">
            <thead class="thead-dark"><th>id</th><th>name</th></thead>
            <tbody>
                @if ($users->count()>0)

                @foreach ($users as $user)
                    <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    </tr>

                @endforeach

                @else

                    <div class="alert alert-warning text-center">
                        <p>No Inform!</p>
                    </div>

                @endif
            </tbody>
        </table>


        <div class="row py-2 my-2">


        <table class="table table-hover table-striped table-light text-success">
                <thead class="thead-dark"><th>id</th><th>name</th><th>classes</th></thead>
                <tbody>
                    @if ($subjects->count()>0)

                    @foreach ($subjects as $subject)
                        <tr>
                        <td>{{$subject->id}}</td>
                        <td>{{$subject->name}}</td>
                        <td>
                            @foreach ($subject->schoolClasses as $item)
                        <span class='badge badge-info'>{{$item->name}}</span>
                            @endforeach
                        </td>
                        </tr>

                    @endforeach

                    @else

                        <div class="alert alert-warning text-center">
                            <p>No Inform!</p>
                        </div>

                    @endif
                </tbody>
            </table>




        </div>

        @endsection

