@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">A Level Results</li>
    </ol>
</nav>


<section class="content">

{{-- @include('manage-results.search') --}}


{{--
<div class="row">
    <div class="col-12">
        <div class="card elevation-2 animated bounce">
            <div class="card-header row">
                <h3 class="card-title mr-auto">A Level Results</h3>

            </div>
            <div class="card-body">
                <div class="row">
                    @include('partials.message')
                </div>
                <table id="RoleTable" class="table table-bordered table-striped">
                    <thead>
                        <th colspan="2">Subject</th>

                        <th>Bot <br> out of {{App\Exmset::find(1)->set_percentage}}</th>
                        <th>Mot<br> out of {{App\Exmset::find(2)->set_percentage}}</th>
                        <th>Eot <br>out of {{App\Exmset::find(3)->set_percentage}}</th>
                        <th>Total Marks<br> of {{'100'}}</th>
                        <th>Final Mark</th>
                        <th>Final Grade</th>
                        <th>Teacher Comment</th>
                    </thead>
                    <tbody>


                                {{-- @foreach ($results->where('subject_id',9)->groupBy('student_id') as $stud_id=>$resu) --
                                @foreach ($results->groupBy('student_id') as $stud_id=>$resu)

                                    <tr><td colspan="9">{{' Name: '.$students->find($stud_id)->name.' Class: '.$students->find($stud_id)->schclass->name}}</td></tr>



                                        @foreach ($resu->where('term_id',1)->where('student_id',$stud_id)->groupBy('subject_id') as $sub=>$res)





                                            @if ($res->first()->subject->papersIn()->count()==3 && $res->first()->paper_id!=null)

                                                    <tr>
                                                        <tr>

                                                            <td rowspan="3">{{$res->first()->subject->name}}</td>
                                                            <td>{{$res->count()>0?$res->first()->paper->paper_abbrev:null}}</td>
                                                            <td>{{$res->where('exmset_id',1)->count()>0?$res->where('exmset_id',1)->first()->calculate_mark:null}}</td>
                                                            <td>{{$res->where('exmset_id',2)->count()>0?$res->where('exmset_id',2)->first()->calculate_mark:null}}</td>
                                                            <td>{{$res->where('exmset_id',3)->count()>0?$res->where('exmset_id',3)->first()->calculate_mark:null}}</td>
                                                            <td>{{$res->count()>0?round(array_sum($res->where('paper_id',$res->first()->paper_id)->pluck('calculate_mark')->toArray()),2):null}}</td>

                                                            <td rowspan="3">
                                                                {{$final_total = (round((($res->count()>0?round(array_sum($res->where('paper_id',$res->first()->paper_id)->pluck('calculate_mark')->toArray()),2):null)+
                                                                ($res->count()>1?round(array_sum($res->where('paper_id',$res[1]->paper_id)->pluck('calculate_mark')->toArray()),2):null)+
                                                                ($res->count()>2?round(array_sum($res->where('paper_id',$res->last()->paper_id)->pluck('calculate_mark')->toArray()),2):null))/($res->first()->paper_id!=null?$res->first()->subject->papersIn()->count():1),2))}}

                                                            </td>
                                                            <td rowspan="3">
                                                                @if ($final_total>90)

                                                                <span>{{$final_grade = 'A+'}}</span>

                                                                @elseif($final_total>=80 && $final_total<90)

                                                                <span>{{$final_grade = 'A'}}</span>
                                                                <span style="display:none">{{$sub_point = 6}}</span>

                                                                @elseif($final_total>=75 && $final_total<80)

                                                                <span>{{$final_grade = 'B+'}}</span>

                                                                @elseif($final_total>=70 && $final_total<75)

                                                                <span>{{$final_grade = 'B'}}</span>

                                                                @elseif($final_total>=65 && $final_total<70)

                                                                <span>{{$final_grade = 'C+'}}</span>

                                                                @elseif($final_total>=60 && $final_total<65)

                                                                <span>{{$final_grade = 'C'}}</span>

                                                                @elseif($final_total>=55 && $final_total<60)

                                                                <span>{{$final_grade = 'D+'}}</span>

                                                                @elseif($final_total>=50 && $final_total<55)

                                                                <span>{{$final_grade = 'D'}}</span>

                                                                @elseif($final_total<50)

                                                                <span>{{$final_grade = 'F'}}</span>

                                                                @endif
                                                            </td>
                                                            <td rowspan="3">{{'Teachers Commit'}}</td>

                                                        </tr>
                                                        <tr>

                                                            <td>{{$res->count()>1?$res[1]->paper->paper_abbrev:null}}</td>
                                                            <td>{{$res->where('exmset_id',1)->count()>1?$res->where('exmset_id',1)->nth(2,1)->first()->calculate_mark:null}}</td>
                                                            <td>{{$res->where('exmset_id',2)->count()>1?$res->where('exmset_id',2)->nth(2,1)->first()->calculate_mark:null}}</td>
                                                            <td>{{$res->where('exmset_id',3)->count()>1?$res->where('exmset_id',3)->nth(2,1)->first()->calculate_mark:null}}</td>
                                                            <td>{{$res->count()>1?round(array_sum($res->where('paper_id',$res[1]->paper_id)->pluck('calculate_mark')->toArray()),2):null}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{$res->count()>2?$res->last()->paper->paper_abbrev:null}}</td>
                                                            <td>{{$res->where('exmset_id',1)->count()>2?$res->where('exmset_id',1)->last()->calculate_mark:null}}</td>
                                                            <td>{{$res->where('exmset_id',2)->count()>2?$res->where('exmset_id',2)->last()->calculate_mark:null}}</td>
                                                            <td>{{$res->where('exmset_id',3)->count()>2?$res->where('exmset_id',3)->last()->calculate_mark:null}}</td>
                                                            <td>{{$res->count()>2?round(array_sum($res->where('paper_id',$res->last()->paper_id)->pluck('calculate_mark')->toArray()),2):null}}</td>
                                                        </tr>

                                                    </tr>

                                            @elseif($res->first()->subject->papersIn()->count()==2 && $res->first()->paper_id!=null)

                                                <tr>
                                                    <tr>

                                                        <td rowspan="2">{{$res->first()->subject->name}}</td>
                                                        <td>{{$res->count()>0?$res->first()->paper->paper_abbrev:null}}</td>
                                                        <td>{{$res->where('exmset_id',1)->count()>0?$res->where('exmset_id',1)->first()->calculate_mark:null}}</td>
                                                        <td>{{$res->where('exmset_id',2)->count()>0?$res->where('exmset_id',2)->first()->calculate_mark:null}}</td>
                                                        <td>{{$res->where('exmset_id',3)->count()>0?$res->where('exmset_id',3)->first()->calculate_mark:null}}</td>
                                                        <td>{{round(array_sum($res->where('paper_id',$res->first()->paper_id)->pluck('calculate_mark')->toArray()),2)}}</td>

                                                        <td rowspan="2">
                                                            {{$final_total = (round((($res->count()>0?round(array_sum($res->where('paper_id',$res->first()->paper_id)->pluck('calculate_mark')->toArray()),2):null)+
                                                            ($res->count()>1?round(array_sum($res->where('paper_id',$res->last()->paper_id)->pluck('calculate_mark')->toArray()),2):null))/($res->first()->paper_id!=null?$res->first()->subject->papersIn()->count():1),2))}}

                                                        </td>
                                                        <td rowspan="2">
                                                            @if ($final_total>90)

                                                                <span>{{$final_grade = 'A+'}}</span>

                                                                @elseif($final_total>=80 && $final_total<90)

                                                                <span>{{$final_grade = 'A'}}</span>
                                                                <span style="display:none">{{$sub_point = 6}}</span>

                                                                @elseif($final_total>=75 && $final_total<80)

                                                                <span>{{$final_grade = 'B+'}}</span>

                                                                @elseif($final_total>=70 && $final_total<75)

                                                                <span>{{$final_grade = 'B'}}</span>

                                                                @elseif($final_total>=65 && $final_total<70)

                                                                <span>{{$final_grade = 'C+'}}</span>

                                                                @elseif($final_total>=60 && $final_total<65)

                                                                <span>{{$final_grade = 'C'}}</span>

                                                                @elseif($final_total>=55 && $final_total<60)

                                                                <span>{{$final_grade = 'D+'}}</span>

                                                                @elseif($final_total>=50 && $final_total<55)

                                                                <span>{{$final_grade = 'D'}}</span>

                                                                @elseif($final_total<50)

                                                                <span>{{$final_grade = 'F'}}</span>

                                                            @endif
                                                        </td>
                                                        <td rowspan="2">{{'Teachers Commit'}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$res->count()>1?$res->last()->paper->paper_abbrev:null}}</td>
                                                        <td>{{$res->where('exmset_id',1)->count()>1?$res->where('exmset_id',1)->last()->calculate_mark:null}}</td>
                                                        <td>{{$res->where('exmset_id',2)->count()>1?$res->where('exmset_id',2)->last()->calculate_mark:null}}</td>
                                                        <td>{{$res->where('exmset_id',3)->count()>1?$res->where('exmset_id',3)->last()->calculate_mark:null}}</td>
                                                        <td>{{$res->count()>1?round(array_sum($res->where('paper_id',$res->last()->paper_id)->pluck('calculate_mark')->toArray()),2):null}}</td>
                                                    </tr>

                                                </tr>


                                            @elseif($res->first()->subject->papersIn()->count() == 0 && $res->first()->paper_id!=null)


                                                <tr>
                                                    <tr>
                                                        <td colspan="2">{{$res->count()>0?$res->first()->subject->name:null}}</td>
                                                        <td>{{$res->where('exmset_id',1)->count()>0?$res->where('exmset_id',1)->first()->calculate_mark:null}}</td>
                                                        <td>{{$res->where('exmset_id',2)->count()>0?$res->where('exmset_id',2)->first()->calculate_mark:null}}</td>
                                                        <td>{{$res->where('exmset_id',3)->count()>0?$res->where('exmset_id',3)->first()->calculate_mark:null}}</td>
                                                        <td>{{round(array_sum($res->pluck('calculate_mark')->toArray()),2)}}</td>
                                                        <td>
                                                            {{
                                                            $final_total = (round((($res->count()>0?round(array_sum($res->pluck('calculate_mark')->toArray()),2):null))/($res->first()->subject->papersIn()->count()!=0?$res->first()->subject->papersIn()->count():1),2))
                                                            }}
                                                        </td>
                                                        <td>
                                                            @if ($final_total>90)

                                                                <span>{{$final_grade = 'A+'}}</span>

                                                                @elseif($final_total>=80 && $final_total<90)

                                                                <span>{{$final_grade = 'A'}}</span>
                                                                <span style="display:none">{{$sub_point = 6}}</span>

                                                                @elseif($final_total>=75 && $final_total<80)

                                                                <span>{{$final_grade = 'B+'}}</span>

                                                                @elseif($final_total>=70 && $final_total<75)

                                                                <span>{{$final_grade = 'B'}}</span>

                                                                @elseif($final_total>=65 && $final_total<70)

                                                                <span>{{$final_grade = 'C+'}}</span>

                                                                @elseif($final_total>=60 && $final_total<65)

                                                                <span>{{$final_grade = 'C'}}</span>

                                                                @elseif($final_total>=55 && $final_total<60)

                                                                <span>{{$final_grade = 'D+'}}</span>

                                                                @elseif($final_total>=50 && $final_total<55)

                                                                <span>{{$final_grade = 'D'}}</span>

                                                                @elseif($final_total<50)

                                                                <span>{{$final_grade = 'F'}}</span>

                                                            @endif
                                                        </td>
                                                        <td>{{'Teachers Commit'}}</td>
                                                    </tr>

                                                </tr>

                                            @elseif($res->first()->subject->papersIn()->count()>0 && $res->first()->paper_id == null)

                                            <tr>
                                                <tr>
                                                    <td colspan="2">{{$res->count()>0?$res->first()->subject->name:null}}</td>
                                                    <td>{{$res->where('exmset_id',1)->count()>0?$res->where('exmset_id',1)->first()->calculate_mark:null}}</td>
                                                    <td>{{$res->where('exmset_id',2)->count()>0?$res->where('exmset_id',2)->first()->calculate_mark:null}}</td>
                                                    <td>{{$res->where('exmset_id',3)->count()>0?$res->where('exmset_id',3)->first()->calculate_mark:null}}</td>
                                                    <td>{{round(array_sum($res->where('id',$res->first()->id)->pluck('calculate_mark')->toArray()),2)}}</td>

                                                    <td>{{
                                                        $final_total = (round((($res->count()>0?round(array_sum($res->where('id',$res->first()->id)->pluck('calculate_mark')->toArray()),2):null))/($res->first()->subject->papersIn()->count()>0 && $res->first()->paper_id == null?1:1),2))
                                                        }}</td>
                                                    <td>
                                                        @if ($final_total>90)

                                                                <span>{{$final_grade = 'A+'}}</span>

                                                                @elseif($final_total>=80 && $final_total<90)

                                                                <span>{{$final_grade = 'A'}}</span>
                                                                <span style="display:none">{{$sub_point = 6}}</span>

                                                                @elseif($final_total>=75 && $final_total<80)

                                                                <span>{{$final_grade = 'B+'}}</span>

                                                                @elseif($final_total>=70 && $final_total<75)

                                                                <span>{{$final_grade = 'B'}}</span>

                                                                @elseif($final_total>=65 && $final_total<70)

                                                                <span>{{$final_grade = 'C+'}}</span>

                                                                @elseif($final_total>=60 && $final_total<65)

                                                                <span>{{$final_grade = 'C'}}</span>

                                                                @elseif($final_total>=55 && $final_total<60)

                                                                <span>{{$final_grade = 'D+'}}</span>

                                                                @elseif($final_total>=50 && $final_total<55)

                                                                <span>{{$final_grade = 'D'}}</span>

                                                                @elseif($final_total<50)

                                                                <span>{{$final_grade = 'F'}}</span>

                                                            @endif
                                                    </td>
                                                    <td>{{'Teachers Commit'}}</td>
                                                </tr>

                                            </tr>

                                            @else

                                            <tr>
                                                <tr>
                                                    <td colspan="2">{{$res->count()>0?$res->first()->subject->name:null}}</td>
                                                    <td>{{$res->where('exmset_id',1)->count()>0?$res->where('exmset_id',1)->first()->calculate_mark:null}}</td>
                                                    <td>{{$res->where('exmset_id',2)->count()>0?$res->where('exmset_id',2)->first()->calculate_mark:null}}</td>
                                                    <td>{{$res->where('exmset_id',3)->count()>0?$res->where('exmset_id',3)->first()->calculate_mark:null}}</td>
                                                    <td>{{round(array_sum($res->pluck('calculate_mark')->toArray()),2)}}</td>

                                                    <td>{{$final_total = round(array_sum($res->pluck('calculate_mark')->toArray()),2)}}</td>
                                                    <td>
                                                        @if ($final_total>90)

                                                                <span>{{$final_grade = 'A+'}}</span>

                                                                @elseif($final_total>=80 && $final_total<90)

                                                                <span>{{$final_grade = 'A'}}</span>
                                                                <span style="display:none">{{$sub_point = 6}}</span>

                                                                @elseif($final_total>=75 && $final_total<80)

                                                                <span>{{$final_grade = 'B+'}}</span>

                                                                @elseif($final_total>=70 && $final_total<75)

                                                                <span>{{$final_grade = 'B'}}</span>

                                                                @elseif($final_total>=65 && $final_total<70)

                                                                <span>{{$final_grade = 'C+'}}</span>

                                                                @elseif($final_total>=60 && $final_total<65)

                                                                <span>{{$final_grade = 'C'}}</span>

                                                                @elseif($final_total>=55 && $final_total<60)

                                                                <span>{{$final_grade = 'D+'}}</span>

                                                                @elseif($final_total>=50 && $final_total<55)

                                                                <span>{{$final_grade = 'D'}}</span>

                                                                @elseif($final_total<50)

                                                                <span>{{$final_grade = 'F'}}</span>

                                                            @endif
                                                    </td>
                                                    <td>{{'Teachers Commit'}}</td>
                                                </tr>

                                            </tr>

                                            @endif





                                        @endforeach



                                @endforeach





                    </tbody>

                    <tfoot>
                        <th colspan="2">Subject</th>
                        <th>Bot</th>
                        <th>Mot</th>
                        <th>Eot</th>
                        <th>Total Marks</th>
                        <th>Final Mark</th>
                        <th>Final Grade</th>
                        <th>Teacher Comment</th>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>
</div>
--}}



<div>
    <div class="row container d-flex justify-content-center">
        <div class="card elevation-1">
            <form action="javascript:void(0)" id="searchform">
                <div class="mx-auto col-lg-12 py-2">

                        @csrf

                        {{-- <div class="form-group col-12 d-block">
                            <select id="class_search" name="class_search" class="action_search form-control" id="">
                                <option value="">select class</option>
                                @foreach ($schclasses as $row)
                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="form-group col-12 d-block">
                            <select id="student_search" name="student_search" class="action_search form-control" id="">
                                <option value="">select student</option>
                                @foreach ($studentz as $row)
                                        <option value="{{$row->id}}">{{$row->name.','.$row->schclass->name.','.$row->roll_number}}</option>
                                @endforeach
                            </select>
                        </div>
                    {{--
                        <div class="form-group col-12 d-block">
                            <select id="term_search" name="term_search" class="action_search form-control" id="">
                                <option value="">select term</option>
                                @foreach ($terms as $row)
                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        --}}


                    {{--
                        <div class="input-group my-3 form-group d-flex justify-content-center col-12">


                        <input type="text" name='search_text' class="form-control col-10" id="search_text" placeholder="search"/>


                        <button class="input-group-prepend btn btn-outline-dark col-2" type="submit">
                                <i class="fas fa-search"></i>
                        </button>
                    </div> --}}
                </div>
            </form>
        </div>

    </div>
    <div id="searchResult">
        <div class="display-6 d-flex justify-content-center">
            <p>Search Results By Student</p>
        </div>

    </div>
</div>

</section>







@endsection

@section('style')
 <!-- DataTables -->


<style>
    .breadcrumb{

        background: #fdffffc7;
    }
</style>
@endsection
@section('first-scripts')
  <!-- jQuery -->
 <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
 <link rel="stylesheet" href="{{asset('schools/plugins/select2/css/select2.min.css')}}">
 <script src="{{asset('schools/plugins/select2/js/select2.full.min.js')}}"></script>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#student_search').select2();

    var actionInput =null;
    var class_id ='';
    var set_id ='';
    var term_id ='';
    var subject_id ='';
    var paper_marks = new Array();

    $('#fillData').submit(function(e){
        e.preventDefault();
        var formData =  $('#fillData').serialize();
        console.log(formData)

    })
    $('.action_search').change(function(){
        var action = $(this).attr('id');
        var query = $(this).val()

        // if(action === 'student_search')
        // {
            var search_student= $('#student_search').val()
        // }
        // if(action === 'search_class_search')
        // {
            var search_class = $('#class_search').val()
        // }
        // if(action === 'term_search')
        // {
            var search_term = $('#term_search').val()
        // }
        console.log(`query:${query},action:${action},class:${search_class},term:${search_term},student:${search_student}`)
        $.ajax({
                url:"{{url('/result-search')}}",
                method:"post",
                data:{search_class:search_class,search_term:search_term,search_student:search_student},
                dataType:'text',
                success:function(data){
                    $('#searchResult').html(data);
                    console.log(data);
                },
                error:function(data){
                    console.log(data.responseText)


                },
            })
    });
    $('#search_text').keyup(function(){
        var txt = $(this).val();
        if(txt !== '')
        {
        // console.log(txt)
        $.ajax({
                url:"{{url('/result-search')}}",
                method:"post",
                data:{search:txt},
                dataType:'text',
                success:function(data){
                    $('#searchResult').html(data);
                },
                error:function(data){
                    console.log(data)

                }
            })

        }
        else
        {
            $('#searchResult').html('');
            $.ajax({
                url:"{{url('/result-search')}}",
                method:"post",
                data:{search:txt},
                dataType:'text',
                success:function(data){
                    $('#searchResult').html(data);
                    console.log(data);
                },
                error:function(data){
                    console.log(data)


                },
            })
        }
    })

    $('#searchform').submit(function(e){
        e.preventDefault()
        var nameInput = $('#name').val();
        if(nameInput !== '')
        {
            $.ajax({
                url:'{{url("/api/search-results")}}',
                method:'post',
                data:{query:nameInput},
                success:function(data){
                    console.log(data)
                },
                error:function(data){
                    console.log(data)
                },

            });
        }
    })



    // $('#schclass').select2();
    // $('#subject').select2();
    // $('#examset').select2();
    // $('#term').select2();

    $('.action').change(function(){
        if($(this).val()!=''){
            var action = $(this).attr('id');
            var query = $(this).val();
            var resuit ='';
            console.log('action:'+action+' query:'+query+' class_id:'+class_id)
            if(action === 'schclass')
            {
                result = 'subject';
                class_id = query;
            }
            if(action === 'subject')
            {
                result = null;
                subject_id = query;
            }
            if(action === 'examset')
            {
                result = null;
                set_id = query;

            }
            if(action === 'term')
            {
                result ='resultz';
                term_id=query
            }
            console.log('action:'+action+' query:'+query+' class_id:'+class_id+' subject_id:'+subject_id+' set_id:'+set_id+' term_id:'+term_id)

            console.log(result)
            $.ajax({
                url:"{{url('/manage-marks')}}",
                method:"POST",
                data:{action:action, query:query,class_id:class_id,subject_id:subject_id,set_id:set_id,term_id:term_id},
                success:function(data)
                {
                    $('#'+result).html(data);
                    console.log('html'+data)

                },
                error:function(data)
                {
                    console.log(data.responseText)
                }

            });
        }

    });




    })
</script>
@endsection
