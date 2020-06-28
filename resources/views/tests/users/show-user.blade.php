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
                <table class="table table-sm">
                    <tbody>
                        <tr>
                            <td>
                                Name
                            </td>
                            <td>
                                {{$user->name}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>



@endsection
