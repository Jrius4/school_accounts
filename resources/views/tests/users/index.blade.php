@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Followers</li>
    </ol>
</nav>


<section class="content">

<section class="container-fluid">
    <div class="col-sm-offset-2 col-sm-8">
        <div class="card card-default">
            <div class="card-header">
                All Users
            </div>
            <div class="card-body">
                <table class="table table-striped task-table">
                    <thead>
                    <th>User</th>
                    <th> </th>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td clphpass="table-text"><div>{{ $user->name }}</div></td>
                            @if (auth()->user()->isFollowing($user->id))
                                <td>
                                    <form action="{{route('follows.unfollow', ['id' => $user->id])}}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" id="delete-follow-{{ $user->id }}" class="btn btn-danger">
                                            <i class="fa fa-btn fa-trash"></i>Unfollow
                                        </button>
                                    </form>
                                </td>
                            @else
                                <td>
                                    <form action="{{route('follows.follow', ['id' => $user->id])}}" method="POST">
                                        {{ csrf_field() }}

                                        <button type="submit" id="follow-user-{{ $user->id }}" class="btn btn-success">
                                            <i class="fa fa-btn fa-user"></i>Follow
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">
                                {{$users->links()}}
                            </td>
                        </tr>

                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>



@endsection
