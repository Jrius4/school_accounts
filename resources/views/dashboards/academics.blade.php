
     <!-- Small boxes (Stat box) -->
     <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box  bg-info animated flipInY">
            <div class="inner">
              <h3>{{App\User::count()}}</h3>

              <p>Administrators</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-stalker"></i>
            </div>
            <a href="{{route('users.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box  bg-success animated flipInY">
            <div class="inner">
              <h3>{{App\Role::whereName('teacher')->first()->users()->count()}}<sup style="font-size: 20px"></sup></h3>

              <p>Teachers</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-people"></i>
            </div>
            <a href="{{route('teachers.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box  bg-warning animated flipInY">
            <div class="inner">
              <h3>{{App\Models\Student::count()}}</h3>

              <p>Students</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-contacts"></i>
            </div>
            <a href="{{route('students.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box  bg-danger animated flipInY">
            <div class="inner">
              <h3>{{App\Subject::count()}}</h3>

              <p>Subjects</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-list"></i>
            </div>
            <a href="{{route('subjects.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

      @section('script')

      <!-- jQuery -->
      <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
      <!-- jQuery UI 1.11.4 -->
      <script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
     @endsection



