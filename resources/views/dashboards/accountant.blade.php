<div class="row d-flex justify-content-center">
    <div class="col-lg-3 col-6">
        <div class="small-box  bg-info animated flipInY">
            <div class="inner">
              <h3>{{App\Models\Student::count()}}</h3>

              <p>Students</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-stalker"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<section class="row d-flex justify-content-center">

    <div class="card mx-auto col-md-8 p-0">
        <div class="card-header text-center text-light bg-dark">
            Set Fees Structure
        </div>
        <div class="card-body">
            <form action="javascript:void(0)">
                <div class="form-group d-block col-12">
                    <label for="schclass_id">Class</label>
                    <select class="form-control" name="schclass_id" id="schclass_id">
                        <div class="d-none">{{$classes = App\Schclass::orderBy('id','asc')->get()}}</div>
                        <option value="">Choose class</option>
                        @foreach ($classes as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group d-block col-12">
                    <label for="schclass_id">Fees Amount</label>
                    <input type="text" name="amount" class="form-control" id="amount"/>
                </div>


                    <input type="submit" value="submit" class="btn btn-gradient-secondary d-block col-12"/>


            </form>
        </div>

    </div>

</section>

@section('script')
 <!-- jQuery -->
 <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
@endsection



