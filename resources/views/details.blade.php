@extends('app')

@section('content')

    <div class="flex-center position-ref full-height">

        <div class="container">
            <a href="{{url('/listings')}}" style="background: rgb(14, 61, 8);color:white;padding:8pt;display:block;font-size:large" class="btn mb-2">Listing</a>
            <h1 class="title m-b-md" style="background: rgb(14, 61, 8);color:white;padding:8pt">
                {{ $listing->title }}
            </h1>
            <span><strong>Price: </strong> <i class="label label-success">$ {{ number_format($listing->price, 1) }}</i></span>
            <div class="row d-flex justify-content-center">

                <article class="col-md-8 mx-auto">
                    <img src="{{ $listing->image }}" class="mx-auto d-block img-responsive thumb img-thumbnail" />
                    <p>
                        {{ $listing->description }}
                    </p>
                </article>

            </div>
        </div>
    </div>

@endsection

@section('script')

    @if(Auth::check())
        <script type="text/javascript">
            conn.onmessage = function(e) {
                console.log(e.data);
            };
        </script>
    @endif

@endsection
