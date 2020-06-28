@extends('layouts.main-dashboard')

@section('dashboard')

<div class="col-md-8 blog-main col-lg-8 blog-main col-sm-8 blog-main mx-auto  row d-flex justify-content-center">
    <h3 class="pb-3 mb-4 font-italic border-bottom">
        Send Message
    </h3>
    <div class="card card-dark elevation-2 col-md-10 mx-auto row d-flex justify-content-center p-0 animated slideInDown">

        <h2 class="card-header">Compose Message</h2>
        <div class="card-body">
            @if(session('message'))

            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-info"></i> Sent!</h5>
                <p>{{session('message')}}</p>
                <a class="btn btn-block btn-dark mx-auto nav-link" href="{{url('/messenger')}}">Check Inbox</a>
            </div>
                
            @endif
            <form method="post" action="{{ route('messages.store') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Send To</label>
                    <select required class="form-control py-2" name="reciever_id" id="reciever_id">
                        <option value="">Send To...</option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-12 d-block">
                    <label for="message">Message<span class="required">∗</span>
                    </label>
                    <textarea name="message" id="message" required spellcheck="false" class="form-control d-block col-12 message" cols="30" rows="10" placeholder="Enter message"></textarea>

                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block"
                    value="Submit"/>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .select2-new{
        padding:100px;
    }
</style>
@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function(){
        $('#reciever_id').select2();
        $('#reciever_id').change(function(){
            var reciever = $(this).val()
            if(reciever !== ""){
                $(this).addClass('form-control')
            }
            
        })
    });
</script>
@endsection
