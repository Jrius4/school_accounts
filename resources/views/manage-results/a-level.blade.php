<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('schools/plugins/rowspanizer/jquery.rowspanizer.js')}}"></script>


</head>
<style>
 table,thead,th,tr,tbody,td{
    border: springgreen 2px solid;
    border-collapse: collapse;
}
</style>
<body>
    <div class="container">
        <a href="{{url('/')}}">&raquo;&raquo;</a>

        <div class="row">
            <div class="container">
                <div class="row"><a href="./index.html">&raquo;</a></div>

                <table class="table">
                    <thead>
                        <th colspan="2">Subject</th>
                        <th>Bot</th>
                        <th>Mot</th>
                        <th>Eot</th>
                        <th>Total Mark</th>
                        <th>Final Mark</th>
                        <th>Final Grade</th>
                        <th>Teacher Comment</th>
                    </thead>
                    <tbody>


                                {{-- @foreach ($results->where('subject_id',9)->groupBy('student_id') as $stud_id=>$resu) --}}
                                @foreach ($results->groupBy('student_id') as $stud_id=>$resu)

                                    <tr><td colspan="9">{{$students->find($stud_id)->name}}</td></tr>



                                        @foreach ($resu->where('term_id',1)->where('student_id',$stud_id)->groupBy('subject_id') as $sub=>$res)





                                            @if ($res->first()->subject->papersIn()->count()==3 && $res->first()->paper_id!=null)

                                                    <tr>
                                                        <tr>

                                                            <td rowspan="3">{{$res->first()->subject->name}}</td>
                                                            <td>{{$res->count()>0?$res->first()->paper->paper_abbrev:null}}</td>
                                                            <td>{{$res->where('exmset_id',1)->count()>0?$res->where('exmset_id',1)->first()->mark:null}}</td>
                                                            <td>{{$res->where('exmset_id',2)->count()>0?$res->where('exmset_id',2)->first()->mark:null}}</td>
                                                            <td>{{$res->where('exmset_id',3)->count()>0?$res->where('exmset_id',3)->first()->mark:null}}</td>
                                                            <td>{{'Total Mark'}}</td>
                                                            <td rowspan="3">{{'Final Mark'}}</td>
                                                            <td rowspan="3">{{'Final Grade'}}</td>
                                                            <td rowspan="3">{{'Teachers Commit'}}</td>
                                                        </tr>
                                                        <tr>

                                                            <td>{{$res->count()>1?$res[1]->paper->paper_abbrev:null}}</td>
                                                            <td>{{$res->where('exmset_id',1)->count()>1?$res->where('exmset_id',1)->nth(2,1)->first()->mark:null}}</td>
                                                            <td>{{$res->where('exmset_id',2)->count()>1?$res->where('exmset_id',2)->nth(2,1)->first()->mark:null}}</td>
                                                            <td>{{$res->where('exmset_id',3)->count()>1?$res->where('exmset_id',3)->nth(2,1)->first()->mark:null}}</td>
                                                            <td>{{'Total Mark'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{$res->count()>2?$res->last()->paper->paper_abbrev:null}}</td>
                                                            <td>{{$res->where('exmset_id',1)->count()>2?$res->where('exmset_id',1)->last()->mark:null}}</td>
                                                            <td>{{$res->where('exmset_id',2)->count()>2?$res->where('exmset_id',2)->last()->mark:null}}</td>
                                                            <td>{{$res->where('exmset_id',3)->count()>2?$res->where('exmset_id',3)->last()->mark:null}}</td>
                                                            <td>{{'Total Mark'}}</td>
                                                        </tr>
                                                    </tr>

                                            @elseif($res->first()->subject->papersIn()->count()==2 && $res->first()->paper_id!=null)

                                                <tr>
                                                    <tr>

                                                        <td rowspan="2">{{$res->first()->subject->name}}</td>
                                                        <td>{{$res->count()>0?$res->first()->paper->paper_abbrev:null}}</td>
                                                        <td>{{$res->where('exmset_id',1)->count()>0?$res->where('exmset_id',1)->first()->mark:null}}</td>
                                                        <td>{{$res->where('exmset_id',2)->count()>0?$res->where('exmset_id',2)->first()->mark:null}}</td>
                                                        <td>{{$res->where('exmset_id',3)->count()>0?$res->where('exmset_id',3)->first()->mark:null}}</td>
                                                        <td>{{'Total Mark'}}</td>
                                                        <td rowspan="2">{{'Final Mark'}}</td>
                                                        <td rowspan="2">{{'Final Grade'}}</td>
                                                        <td rowspan="2">{{'Teachers Commit'}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$res->count()>1?$res->last()->paper->paper_abbrev:null}}</td>
                                                        <td>{{$res->where('exmset_id',1)->count()>1?$res->where('exmset_id',1)->last()->mark:null}}</td>
                                                        <td>{{$res->where('exmset_id',2)->count()>1?$res->where('exmset_id',2)->last()->mark:null}}</td>
                                                        <td>{{$res->where('exmset_id',3)->count()>1?$res->where('exmset_id',3)->last()->mark:null}}</td>
                                                        <td>{{'Total Mark'}}</td>
                                                    </tr>
                                                </tr>


                                            @elseif($res->first()->subject->papersIn()->count() == 0 && $res->first()->paper_id!=null)


                                                <tr>
                                                    <tr>
                                                        <td colspan="2">{{$res->count()>0?$res->first()->subject->name:null}}</td>
                                                        <td>{{$res->where('exmset_id',1)->count()>0?$res->where('exmset_id',1)->first()->mark:null}}</td>
                                                        <td>{{$res->where('exmset_id',2)->count()>0?$res->where('exmset_id',2)->first()->mark:null}}</td>
                                                        <td>{{$res->where('exmset_id',3)->count()>0?$res->where('exmset_id',3)->first()->mark:null}}</td>
                                                        <td>{{'Total Mark'}}</td>
                                                        <td>{{'Final Mark'}}</td>
                                                        <td>{{'Final Grade'}}</td>
                                                        <td>{{'Teachers Commit'}}</td>
                                                    </tr>
                                                </tr>

                                            @elseif($res->first()->subject->papersIn()->count()>0 && $res->first()->paper_id == null)

                                            <tr>
                                                <tr>
                                                    <td colspan="2">{{$res->count()>0?$res->first()->subject->name:null}}</td>
                                                    <td>{{$res->where('exmset_id',1)->count()>0?$res->where('exmset_id',1)->first()->mark:null}}</td>
                                                    <td>{{$res->where('exmset_id',2)->count()>0?$res->where('exmset_id',2)->first()->mark:null}}</td>
                                                    <td>{{$res->where('exmset_id',3)->count()>0?$res->where('exmset_id',3)->first()->mark:null}}</td>
                                                    <td>{{'Total Mark'}}</td>
                                                    <td>{{'Final Mark'}}</td>
                                                    <td>{{'Final Grade'}}</td>
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
                        <th>Total Mark</th>
                        <th>Final Mark</th>
                        <th>Final Grade</th>
                        <th>Teacher Comment</th>
                    </tfoot>

                </table>
            </div>
        </div>






    </div>
    <script src="{{asset('schools/plugins/jsPDF/jspdf.min.js')}}"></script>
    <script type="text/javascript">
    </script>

</body>
</html>
