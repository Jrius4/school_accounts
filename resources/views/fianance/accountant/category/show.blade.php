@extends('layouts.main-dashboard')
@section('dashboard')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('acc-category.index')}}">Account Types</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$accCategory->name}} Acc. Type</a></li>
    </ol>
</nav>

<section class="card card-body row container d-flex col-11 mx-auto elevation-2 animated slideInDown">
    <table class="table table-sm table-hover">
        <thead>
            <tr>
                <th colspan="3" class="display-4 text-center">
                    {{$accCategory->name}}
                </th>
            </tr>
            <tr>
                <th>Name</th>
                <th>Balance</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($accCategory->schoolAccounts->count()==0)
                <tr>
                    <td class="d-block text-center" colspan="3">
                        No Account In this Category
                    </td>
                </tr>
            @else

                @foreach ($accCategory->schoolAccounts as $item)

                <tr>
                    <td>{{$item->account_name}}</td>
                    <td>{{$item->amount}}</td>
                    <td></td>
                </tr>

                @endforeach

            @endif

        </tbody>

    </table>

</section>

@endsection
