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
    <financial-graphs/>
</section>


<section class="row d-flex justify-content-center">

    <div class="card mx-auto col-md-6 p-0 animated flipInX">
        <div class="card-header text-center text-light bg-dark">
            Set Fees Structure
        </div>
        <div class="card-body">
            <form action="{{route('burser.store')}}" method="POST">
                @csrf
                <input type="hidden" name="_method" value="POST">
                <div class="form-group d-block col-12">
                    <label for="class">Class</label>
                    <select class="form-control @error('class') is-invalid @enderror" name="class" id="class">
                        <div class="d-none">{{$classes = App\Schclass::orderBy('id','asc')->get()}}</div>
                        <option value="">Choose class</option>
                        @foreach ($classes as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                        @endforeach
                    </select>
                    @error('class')
                    <small class="text-danger">
                        {{$message}}
                    </small>
                    @enderror
                </div>

                <div class="form-group d-block col-12">
                    <label for="fees_amount">Fees Amount</label>
                    <input type="text" name="fees_amount" class="form-control @error('fees_amount') is-invalid @enderror" id="fees_amount" placeholder="100000"/>
                    @error('fees_amount')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>


                    <input type="submit" value="submit" class="btn btn-block bg-gradient-primary btn-sm"/>


            </form>
        </div>

    </div>

    <div class="card mx-auto col-md-6 p-0 animated flipInX">
        <div class="card-header text-center text-light bg-dark">
            Set Fees Structure Table
        </div>
        <div class="card-body table-responsive no-wrap p-0 col-12">

            <table class="table" style="width:100%">
                <thead>
                    <tr>
                         <th>
                        Class
                    </th>
                    <th>
                        Fees Amount
                    </th>
                    </tr>

                </thead>
                <tbody>
                   <span class="d-none">{{$fees = App\ClassFee::orderBy('schclass_id','asc')->get()}}</span>
                    @foreach ($fees as $row)
                        <tr>
                            <td>
                                {{$row->schclass->name}}
                            </td>
                            <td>
                                {{$row->fees_amount}}
                            </td>
                        </tr>

                    @endforeach
                </tbody>



                <tfoot>
                    <th>
                        Class
                    </th>
                    <th>
                        Fees Amount
                    </th>
                </tfoot>
            </table>


        </div>

    </div>

</section>




