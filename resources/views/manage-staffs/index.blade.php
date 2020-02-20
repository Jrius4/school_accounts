@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manage Staffs</li>
    </ol>
</nav>


<section class="content">

<section class="container-fluid">

     <!-- Small boxes (Stat box) -->
     <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box  bg-info">
            <div class="inner">
              <h3>150</h3>

              <p>Administrators</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-stalker"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box  bg-success">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>Teachers</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-people"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box  bg-warning">
            <div class="inner">
              <h3>44</h3>

              <p>Students</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-contacts"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box  bg-danger">
            <div class="inner">
              <h3>65</h3>

              <p>Subjects</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-list"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

</section>



@endsection

@section('style')

<style>
    .breadcrumb{

        background: #cdececc7;
    }
</style>

@endsection
