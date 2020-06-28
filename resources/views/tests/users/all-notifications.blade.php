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
                <table class="table table-striped table-sm task-table">
                    <thead>
                    <tr>
                        <th colspan="2">All Notifications {{$numberNotifications}}</th>
                        <th colspan="2"> </th>
                    </tr>

                    <tr>
                        <th>
                            <a href={{url("/all-notifications")}} class="btn btn-sm btn-dark">All</a>
                        </th>
                        <th><a href={{url("/all-notifications/?unread=true")}} class="btn btn-sm btn-danger">Unread</a></th>
                        <th><a href={{url("/all-notifications//?already=true")}} class="btn btn-sm btn-success">Read</a></th>
                        {{-- <th>
                            <form class="form-inline ml-3">
                                <div class="input-group input-group-sm">
                                  <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                                  <div class="input-group-append">
                                    <button class="btn btn-sm btn-dark" type="submit">
                                      <i class="fas fa-search"></i>
                                    </button>
                                  </div>
                                </div>
                              </form>
                        </th> --}}
                    </tr>


                    </thead>
                    <tbody>
                        @foreach ($allNotifications as $item)
                            <tr class="">
                                <td colspan="3">
                                    @if ($item->type == "App\\Notifications\\NewPost")
                                        <h6> {{$item->data["following_name"]}}</h6> <small> published New Post </small>
                                    @endif
                                    <p>

                                        @if ($item->read_at==null)
                                            <small class="text-danger">not read</small>
                                        @else
                                            <small class="text-success">read</small>
                                        @endif
                                    </p>
                                </td>
                                <td colspan="1">
                                    @if ($item->type == "App\\Notifications\\NewPost")
                                        <a href={{url("follows/comments/{$item->data["post_id"]}?read={$item->id}")}} class=" btn btn-sm-block @if($item->read_at!=null) text-dark @endif"> <i class="fa fa-btn fa-eye"></i></a>
                                    @endif
                                </td>
                            </tr>


                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                {{$allNotifications->links()}}
                            </td>
                        </tr>

                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>



@endsection
