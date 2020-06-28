@extends('student')
@section('content')
<div class="card col-md-10 mx-auto">
    <div class="card-header">
        <h4>Results</h4>
    </div>
    <div class="card-body p-0">
        <div class="row col-12">

            <div class="card card-body table-reponsive p-0">

            </div>

        </div>
    </div>



</div>

@if ($results->count() >0)

    <div class="card col-md-10 mx-auto">
        <div class="card-header">
            Student Results
        </div>
        <div class="card-body table-responsive p-0 col-12">
            <table class="table table-bordered table-head-fixed text-nowrap col-lg-12">
                <thead class="text-center">
                    <th colspan="2">Subject</th>
                    <th> Bot <br>Out Of {{App\Exmset::find(1)->set_percentage}}</th>
                    <th> Mot <br>Out Of {{App\Exmset::find(2)->set_percentage}}</th>
                    <th> Eot <br>Out Of {{App\Exmset::find(3)->set_percentage}}</th>
                    <th>Total Marks <br> of 100</th>
                    <th>Final Mark</th>
                    <th>Final Grade</th>
                    <th>Teacher Comment</th>
                </thead>
                <tbody>

                    @foreach ($results->groupBy('schclass_id') as $class_id=>$row2)
                    <tr>
                        <td colspan="9" class="text-left">{{$class->find($class_id)->name}} {{$row2->first()->year}}</td>
                    </tr>

                        @foreach ($row2->groupBy('term_id') as $term_id=>$row2)

                            <tr>
                                <td colspan="9" class="text-left">{{$term->find($term_id)->name}}</td>
                            </tr>

                            @foreach ($row2->groupBy('subject_id') as $sub_id=>$row3)
                                {{-- <tr>
                                    <td>{{$subject->find($sub_id)->name}}</td>
                                </tr> --}}
                                @if ($row3->where('subject_id',$sub_id)->first()->subject->papersIn()->count()==3 && $row3->first()->paper_id != null)
                                    <tr>
                                        <tr>
                                            <td rowspan="3">
                                                {{$row3->where('subject_id',$sub_id)->first()->subject->name}}
                                            </td>
                                            <td>
                                                @if($row3->count()>0)
                                                    {{$row3->first()->paper->paper_abbrev}}
                                                @endif
                                                @if($row3->count()==0)
                                                    {{null}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($row3->where('exmset_id',1)->count()>0)
                                                    <div class="d-none">{{$bot_mark = round(($row3->where('exmset_id',1)->first()->mark*$set->find(1)->set_percentage/100),2) }}</div>
                                                    {{$bot_mark}}
                                                @endif
                                                @if($row3->where('exmset_id',1)->count()==0)
                                                    <div class="d-none">{{$bot_mark= 0}}</div>
                                                    {{$bot_mark}}
                                                @endif

                                            </td>
                                            <td>
                                                @if($row3->where('exmset_id',2)->count()>0)
                                                    <div class="d-none">{{$mot_mark = round(($row3->where('exmset_id',2)->first()->mark*$set->find(2)->set_percentage/100),2) }}</div>
                                                    {{$mot_mark}}
                                                @endif
                                                @if($row3->where('exmset_id',2)->count()==0)
                                                    <div class="d-none">{{$mot_mark = 0}}</div>
                                                    {{$mot_mark}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($row3->where('exmset_id',3)->count()>0)
                                                    <div class="d-none">{{$eot_mark = round(($row3->where('exmset_id',3)->first()->mark*$set->find(3)->set_percentage/100),2) }}</div>
                                                    {{$eot_mark}}
                                                @endif
                                                @if($row3->where('exmset_id',3)->count()==0)
                                                    <div class="d-none">{{$eot_mark = 0}}</div>
                                                    {{$eot_mark}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($row3->count()>0)
                                                    <span class="d-none">{{$paper_1_total = round(array_sum(array($bot_mark,$mot_mark,$eot_mark)),2)}}</span>
                                                    {{$paper_1_total}}
                                                @endif
                                                @if($row3->count()==0)
                                                    <div class="d-none">{{$paper_1_total = 0}}</div>
                                                    {{$paper_1_total}}
                                                @endif
                                            </td>
                                            <td rowspan="3">
                                                @if($row3->count()>0)
                                                    <span class="d-none">{{$bot_mark1 = $row3->where('exmset_id',1)->where('paper_id',$row3->first()->paper_id)->count()>0?
                                                        round(($row3->where('exmset_id',1)->where('paper_id',$row3->first()->paper_id)->first()->mark*$set->find(1)->set_percentage)/100,2)
                                                        :0}}
                                                        {{$mot_mark1=($row3->where('exmset_id',2)->where('paper_id',$row3->first()->paper_id)->count()>0?
                                                        round(($row3->where('exmset_id',2)->where('paper_id',$row3->first()->paper_id)->first()->mark*$set->find(2)->set_percentage)/100,2)
                                                        :0)}}
                                                        {{
                                                            $eot_mark1=($row3->where('exmset_id',3)->where('paper_id',$row3->first()->paper_id)->count()>0?
                                                            round(($row3->where('exmset_id',3)->where('paper_id',$row3->first()->paper_id)->first()->mark*$set->find(3)->set_percentage)/100,2)
                                                            :0)
                                                        }}
                                                        {{$paper_total1 = round(array_sum(array($bot_mark1,$mot_mark1,$eot_mark1)),2)}}</span>
                                                @endif
                                                @if($row3->count() == 0)
                                                <div class="d-none">{{$paper_total1=0}}</div>
                                                {{""}}
                                                @endif

                                                @if($row3->count()>1)

                                                    <div class="d-none">
                                                        {{$bot_mark2=($row3->where('exmset_id',1)->where('paper_id',$row3[1]->paper_id)->count()>0?
                                                        round(($row3->where('exmset_id',1)->where('paper_id',$row3[1]->paper_id)->first()->mark*$set->find(1)->set_percentage)/100,2)
                                                        :0)}}
                                                        {{$mot_mark2=($row3->where('exmset_id',2)->where('paper_id',$row3[1]->paper_id)->count()>0?
                                                        round(($row3->where('exmset_id',2)->where('paper_id',$row3[1]->paper_id)->first()->mark*$set->find(2)->set_percentage)/100,2)
                                                        :0)}}
                                                        {{$eot_mark2=($row3->where('exmset_id',3)->where('paper_id',$row3[1]->paper_id)->count()>0?
                                                        round(($row3->where('exmset_id',3)->where('paper_id',$row3[1]->paper_id)->first()->mark*$set->find(3)->set_percentage)/100,2)
                                                        :0)}}
                                                        {{$paper_total2 = round(array_sum(array($bot_mark2,$mot_mark2,$eot_mark2)),2)}}
                                                    </div>
                                                @endif

                                                @if($row3->count()<1)
                                                <div class="d-none">{{$paper_total2=0}}</div>
                                                {{""}}
                                                @endif

                                                @if($row3->count()>2)
                                                <div class="d-none">
                                                    {{$bot_mark3=($row3->where('exmset_id',1)->where('paper_id',$row3->last()->paper_id)->count()>0?
                                                    round(($row3->where('exmset_id',1)->where('paper_id',$row3->last()->paper_id)->first()->mark*$set->find(1)->set_percentage)/100,2)
                                                    :0)}}
                                                    {{$mot_mark3=($row3->where('exmset_id',2)->where('paper_id',$row3->last()->paper_id)->count()>0?
                                                    round(($row3->where('exmset_id',2)->where('paper_id',$row3->last()->paper_id)->first()->mark*$set->find(2)->set_percentage)/100,2)
                                                    :0)}}
                                                    {{$eot_mark3=($row3->where('exmset_id',3)->where('paper_id',$row3->last()->paper_id)->count()>0?
                                                    round(($row3->where('exmset_id',3)->where('paper_id',$row3->last()->paper_id)->first()->mark*$set->find(3)->set_percentage)/100,2)
                                                    :0)}}
                                                    {{$paper_total3 = round(array_sum(array($bot_mark3,$mot_mark3,$eot_mark3)),2)}}
                                                </div>
                                                @endif

                                                @if($row3->count()<2)
                                                <div class="d-none">{{$paper_total3=0}}</div>
                                                {{""}}


                                                @endif
                                                {{-- {{$paper_total1}};
                                                {{$paper_total2}};
                                                {{$paper_total3}}; --}}
                                                <div class="d-none">{{$Subject_final_mark=round(array_sum(array($paper_total1,$paper_total2,$paper_total3))/3,2)  }}</div>
                                                {{$Subject_final_mark}}

                                            </td>

                                            <td rowspan="3">


                                                @if($Subject_final_mark>90)

                                                        <div class="d-none">{{$Subject_final_grade = "A+"}}</div>
                                                        {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=80 && $Subject_final_mark<90)
                                                    <div class="d-none">{{$Subject_final_grade = "A"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=75 && $Subject_final_mark<80)
                                                    <div class="d-none">{{$Subject_final_grade = "B+"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=70 && $Subject_final_mark<75)
                                                    <div class="d-none">{{$Subject_final_grade = "B-"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=65 && $Subject_final_mark<70)
                                                    <div class="d-none">{{$Subject_final_grade = "C+"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=60 && $Subject_final_mark<65)
                                                    <div class="d-none">{{$Subject_final_grade = "C-"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=55 && $Subject_final_mark<60)
                                                    <div class="d-none">{{$Subject_final_grade = "D+"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=50 && $Subject_final_mark<55)
                                                    <div class="d-none">{{$Subject_final_grade = "D-"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark<50)
                                                    <div class="d-none">{{$Subject_final_grade = "F"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif

                                            </td>
                                            <td rowspan="3">
                                                <span class="d-none"></span>
                                                @if ($Subject_final_grade == "A+")
                                                    {{$faker->randomElement(array('Excellent work','Keep it Up',"keep aiming higher"))}}
                                                @endif
                                                @if ($Subject_final_grade == "A")
                                                {{$faker->randomElement(array('Aim higher','You have greater Pontential',"Great hardwork, aim higher",'Goodwork'))}}
                                                @endif
                                                @if ($Subject_final_grade == "B+")
                                                {{$faker->randomElement(array('You could do better','You have greater Pontential',"Average","Good"))}}
                                                @endif
                                                @if ($Subject_final_grade == "B-")
                                                {{$faker->randomElement(array('You could do better','You have greater Pontential',"Fair work","Do Better"))}}
                                                @endif
                                                @if ($Subject_final_grade == "C+")
                                                {{$faker->randomElement(array('You could do better','Give your studies ample time',"Fair work","Utilize your teacher Well"))}}
                                                @endif
                                                @if ($Subject_final_grade == "C-")
                                                {{$faker->randomElement(array('You could do better','Give your studies ample time',"Fair work","Utilize your teacher Well"))}}
                                                @endif
                                                @if ($Subject_final_grade == "D+")
                                                {{$faker->randomElement(array('You are better than this','revise you books',"fair try","Utilize your teacher Well"))}}
                                                @endif
                                                @if ($Subject_final_grade == "D-")
                                                {{$faker->randomElement(array('You are better than this','revise you books',"fair try","Utilize your teacher Well"))}}
                                                @endif
                                                @if ($Subject_final_grade == "F")
                                                {{$faker->randomElement(array('Pull up your socks','Utilize your teacher Well','Read your books','Need of hardwork'))}}
                                                @endif


                                            </td>

                                        </tr>


                                        <tr>
                                            <td>
                                                @if($row3->count()>1)
                                                    {{$row3[1]->paper->paper_abbrev}}
                                                @endif
                                                @if($row3->count()<1)
                                                {{""}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($row3->where('exmset_id',1)->count()>1)
                                                    <div class="d-none">{{$bot_mark = round(($row3->where('exmset_id',1)->nth(2,1)->first()->mark*$set->find(1)->set_percentage/100),2)}}</div>
                                                    {{$bot_mark}}
                                                @endif
                                                @if ($row3->where('exmset_id',1)->count()<1)
                                                    <div class="d-none">{{$bot_mark = 0}}</div>
                                                    {{""}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($row3->where('exmset_id',2)->count()>1)
                                                    <div class="d-none">{{$mot_mark = round(($row3->where('exmset_id',2)->nth(2,1)->first()->mark*$set->find(2)->set_percentage/100),2)}}</div>
                                                    {{$mot_mark}}
                                                @endif
                                                @if ($row3->where('exmset_id',2)->count()<1)
                                                    <div class="d-none">{{$mot_mark = 0}}</div>
                                                    {{""}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($row3->where('exmset_id',3)->count()>1)
                                                    <div class="d-none">{{$eot_mark = round(($row3->where('exmset_id',3)->nth(2,1)->first()->mark*$set->find(3)->set_percentage/100),2)}}</div>
                                                    {{$eot_mark}}
                                                @endif
                                                @if ($row3->where('exmset_id',3)->count()<1)
                                                    <div class="d-none">{{$eot_mark = 0}}</div>
                                                    {{""}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($row3->count()>1)
                                                    <div class="d-none">{{$paper_2_total = round(array_sum(array($bot_mark,$mot_mark,$eot_mark)),2)}}</div>
                                                    {{$paper_2_total}}
                                                @endif
                                                @if($row3->count()<1)
                                                    <div class="d-none">{{ $paper_2_total=0}}</div>
                                                    {{""}}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if($row3->count()>2)
                                                    {{$row3->last()->paper->paper_abbrev}}
                                                @endif
                                                @if($row3->count()<2)
                                                {{""}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($row3->where('exmset_id',1)->count()>2)
                                                <div class="d-none">{{ $bot_mark = round(($row3->where('exmset_id',1)->last()->mark*$set->find(1)->set_percentage/100),2)}}</div>
                                                {{$bot_mark}}
                                                @endif
                                                @if($row3->where('exmset_id',1)->count()<2)
                                                <div class="d-none">{{$bot_mark = 0}}</div>
                                                {{""}}
                                                @endif


                                            </td>
                                            <td>
                                                @if($row3->where('exmset_id',2)->count()>2)
                                                <div class="d-none">{{$mot_mark = round(($row3->where('exmset_id',2)->last()->mark*$set->find(2)->set_percentage/100),2)}}</div>
                                                {{$mot_mark}}
                                                @endif
                                                @if($row3->where('exmset_id',2)->count()<2)
                                                <div class="d-none">{{$mot_mark = 0}}</div>
                                                {{''}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($row3->where('exmset_id',3)->count()>2)
                                                <div class="d-none">{{$eot_mark = round(($row3->where('exmset_id',3)->last()->mark*$set->find(3)->set_percentage/100),2)}}</div>
                                                {{$eot_mark}}
                                                @endif
                                                @if($row3->where('exmset_id',3)->count()<2)
                                                <div class="d-none">{{$eot_mark =0}}</div>
                                                {{""}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($row3->count()>2)

                                                    <div class="d-none">{{$paper_3_total = round(array_sum(array($bot_mark,$mot_mark,$eot_mark)),2)}}</div>
                                                    {{$paper_3_total}}

                                                @endif

                                                @if($row3->count()<2)
                                                    <div class="d-none">{{$paper_3_total=0}}</div>
                                                    {{""}}
                                                @endif
                                            </td>
                                        </tr>
                                    </tr>
                                @endif

                                @if($row3->where('subject_id',$sub_id)->first()->subject->papersIn()->count()==2 && $row3->where('subject_id',$sub_id)->first()->paper_id!=null)

                                    <tr>
                                        <tr>
                                            <td rowspan="2">{{$row3->where('subject_id',$sub_id)->first()->subject->name}}</td>
                                            <td>
                                                @if($row3->count()>0)
                                                {{$row3->first()->paper->paper_abbrev}}
                                                @endif
                                                @if($row3->count()==0)
                                                {{""}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($row3->where('exmset_id',1)->count()>0)
                                                <div class="d-none">{{  $bot_mark = round(($row3->where('exmset_id',1)->first()->mark*$set->find(1)->set_percentage/100),2) }}</div>
                                                {{$bot_mark}}
                                                @endif
                                                @if($row3->where('exmset_id',1)->count()==0)
                                                    <div class="d-none">{{$bot_mark = 0}}</div>
                                                    {{""}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($row3->where('exmset_id',2)->count()>0)
                                                <div class="d-none">{{  $mot_mark = round(($row3->where('exmset_id',2)->first()->mark*$set->find(2)->set_percentage/100),2) }}</div>
                                                {{$mot_mark}}
                                                @endif
                                                @if($row3->where('exmset_id',2)->count()==0)
                                                    <div class="d-none">{{$mot_mark = 0}}</div>
                                                    {{""}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($row3->where('exmset_id',3)->count()>0)
                                                <div class="d-none">{{  $eot_mark = round(($row3->where('exmset_id',3)->first()->mark*$set->find(3)->set_percentage/100),2) }}</div>
                                                {{$eot_mark}}
                                                @endif
                                                @if($row3->where('exmset_id',3)->count()==0)
                                                    <div class="d-none">{{$eot_mark = 0}}</div>
                                                    {{""}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($row3->count()>0)
                                                    <div class="d-none">{{$paper_1_total = round(array_sum(array($bot_mark,$mot_mark,$eot_mark)),2)}}}</div>
                                                    {{$paper_1_total}}
                                                @endif
                                                @if($row3->count()==0)
                                                    <div class="d-none">{{$paper_1_total = 0}}</div>
                                                    {{""}}
                                                @endif
                                            </td>
                                            <td rowspan="2">
                                                @if($row3->count()>0)
                                                <div class="d-none">
                                                    {{$bot_mark1=($row3->where('exmset_id',1)->where('paper_id',$row3->first()->paper_id)->count()>0?
                                                    round(($row3->where('exmset_id',1)->where('paper_id',$row3->first()->paper_id)->first()->mark*$set->find(1)->set_percentage)/100,2)
                                                    :0)}}
                                                    {{$mot_mark1=($row3->where('exmset_id',2)->where('paper_id',$row3->first()->paper_id)->count()>0?
                                                    round(($row3->where('exmset_id',2)->where('paper_id',$row3->first()->paper_id)->first()->mark*$set->find(2)->set_percentage)/100,2)
                                                    :0)}}
                                                    {{
                                                        $eot_mark1=($row3->where('exmset_id',3)->where('paper_id',$row3->first()->paper_id)->count()>0?
                                                                round(($row3->where('exmset_id',3)->where('paper_id',$row3->first()->paper_id)->first()->mark*$row->find(3)->set_percentage)/100,2)
                                                                :0)
                                                    }}
                                                    {{$paper_total1 = round(array_sum(array($bot_mark1,$mot_mark1,$eot_mark1)),2)}}
                                                </div>
                                                @endif
                                                @if($row3->count()==0)
                                                    <div class="d-none">{{$paper_total1=0}}</div>

                                                @endif
                                                @if($row3->count()>1)
                                                    <div class="d-none">
                                                        {{$bot_mark3=($row3->where('exmset_id',1)->where('paper_id',$row3->last()->paper_id)->count()>0?
                                                        round(($row3->where('exmset_id',1)->where('paper_id',$row3->last()->paper_id)->first()->mark*$set->find(1)->set_percentage)/100,2)
                                                        :0)}}
                                                        {{
                                                            $mot_mark3=($row3->where('exmset_id',2)->where('paper_id',$row3->last()->paper_id)->count()>0?
                                                                round(($row3->where('exmset_id',2)->where('paper_id',$row3->last()->paper_id)->first()->mark*$set->find(2)->set_percentage)/100,2)
                                                                :0)
                                                        }}
                                                        {{
                                                            $eot_mark3=($row3->where('exmset_id',3)->where('paper_id',$row3->last()->paper_id)->count()>0?
                                                                round(($row3->where('exmset_id',3)->where('paper_id',$row3->last()->paper_id)->first()->mark*$set->find(3)->set_percentage)/100,2)
                                                                :0)
                                                        }}
                                                        {{$paper_total2 = round(array_sum(array($bot_mark3,$mot_mark3,$eot_mark3)),2)}}
                                                    </div>

                                                @endif
                                                @if($row3->count()<1)
                                                    <div class="d-none">{{$paper_total2 = 0}}</div>


                                                @endif

                                                <div class="d-none">{{$Subject_final_mark=round(array_sum(array($paper_total1,$paper_total2))/2,2)}}</div>
                                                {{$Subject_final_mark}}


                                            </td>

                                            <td rowspan="2">


                                                @if($Subject_final_mark>90)

                                                        <div class="d-none">{{$Subject_final_grade = "A+"}}</div>
                                                        {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=80 && $Subject_final_mark<90)
                                                    <div class="d-none">{{$Subject_final_grade = "A"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=75 && $Subject_final_mark<80)
                                                    <div class="d-none">{{$Subject_final_grade = "B+"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=70 && $Subject_final_mark<75)
                                                    <div class="d-none">{{$Subject_final_grade = "B-"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=65 && $Subject_final_mark<70)
                                                    <div class="d-none">{{$Subject_final_grade = "C+"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=60 && $Subject_final_mark<65)
                                                    <div class="d-none">{{$Subject_final_grade = "C-"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=55 && $Subject_final_mark<60)
                                                    <div class="d-none">{{$Subject_final_grade = "D+"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=50 && $Subject_final_mark<55)
                                                    <div class="d-none">{{$Subject_final_grade = "D-"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark<50)
                                                    <div class="d-none">{{$Subject_final_grade = "F"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif

                                            </td>
                                            <td rowspan="2">
                                                <span class="d-none"></span>
                                                @if ($Subject_final_grade == "A+")
                                                    {{$faker->randomElement(array('Excellent work','Keep it Up',"keep aiming higher"))}}
                                                @endif
                                                @if ($Subject_final_grade == "A")
                                                {{$faker->randomElement(array('Aim higher','You have greater Pontential',"Great hardwork, aim higher",'Goodwork'))}}
                                                @endif
                                                @if ($Subject_final_grade == "B+")
                                                {{$faker->randomElement(array('You could do better','You have greater Pontential',"Average","Good"))}}
                                                @endif
                                                @if ($Subject_final_grade == "B-")
                                                {{$faker->randomElement(array('You could do better','You have greater Pontential',"Fair work","Do Better"))}}
                                                @endif
                                                @if ($Subject_final_grade == "C+")
                                                {{$faker->randomElement(array('You could do better','Give your studies ample time',"Fair work","Utilize your teacher Well"))}}
                                                @endif
                                                @if ($Subject_final_grade == "C-")
                                                {{$faker->randomElement(array('You could do better','Give your studies ample time',"Fair work","Utilize your teacher Well"))}}
                                                @endif
                                                @if ($Subject_final_grade == "D+")
                                                {{$faker->randomElement(array('You are better than this','revise you books',"fair try","Utilize your teacher Well"))}}
                                                @endif
                                                @if ($Subject_final_grade == "D-")
                                                {{$faker->randomElement(array('You are better than this','revise you books',"fair try","Utilize your teacher Well"))}}
                                                @endif
                                                @if ($Subject_final_grade == "F")
                                                {{$faker->randomElement(array('Pull up your socks','Utilize your teacher Well','Read your books','Need of hardwork'))}}
                                                @endif


                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                @if($row3->count()>1)
                                                    {{$row3->last()->paper->paper_abbrev}}
                                                @endif
                                                @if($row3->count() <1 )
                                                {{""}}

                                                @endif
                                            </td>
                                            <td>
                                                @if($row3->where('exmset_id',1)->count()>1)
                                                    <div class="d-none">{{$bot_mark = round(($row3->where('exmset_id',1)->last()->mark*$set->find(1)->set_percentage/100),2)}}</div>
                                                    {{$bot_mark}}
                                                @endif
                                                @if($row3->where('exmset_id',1)->count()<1)
                                                <div class="d-none">{{$bot_mark = 0}}</div>
                                                {{""}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($row3->where('exmset_id',2)->count()>1)
                                                    <div class="d-none">{{$mot_mark = round(($row3->where('exmset_id',2)->last()->mark*$set->find(2)->set_percentage/100),2)}}</div>
                                                    {{$mot_mark}}
                                                @endif
                                                @if($row3->where('exmset_id',2)->count()<1)
                                                <div class="d-none">{{$mot_mark = 0}}</div>
                                                {{""}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($row3->where('exmset_id',3)->count()>1)
                                                <div class="d-none">{{$eot_mark = round(($row3->where('exmset_id',3)->last()->mark*$set->find(3)->set_percentage/100),2)}}</div>
                                                {{$eot_mark}}
                                                @endif
                                                @if($row3->where('exmset_id',3)->count()<1)
                                                <div class="d-none">{{$eot_mark = 0}}</div>
                                                {{""}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($row3->count()>1)
                                                <div class="d-none">{{$paper_3_total = round(array_sum(array($bot_mark,$mot_mark,$eot_mark)),2)}}</div>
                                                {{$paper_3_total}}
                                                @endif
                                                @if($row3->count()<1)
                                                <div class="d-none">{{$paper_3_total = 0}}</div>
                                                {{""}}
                                                @endif
                                            </td>
                                        </tr>
                                    </tr>

                                @endif

                                @if($row3->where('subject_id',$sub_id)->first()->subject->papersIn()->count()>0 && $row3->where('subject_id',$sub_id)->first()->paper_id == null)

                                    <tr>
                                        <tr>
                                            <td colspan="2">

                                                @if($row3->count()>0)
                                                    {{$row3->first()->subject->name}}
                                                @endif
                                                @if($row3->count()<0)
                                                    {{""}}
                                                @endif

                                            </td>

                                            <td>
                                                @if($row3->where('exmset_id',1)->count()>0)
                                                    <div class="d-none">{{$bot_mark = round(($row3->where('exmset_id',1)->first()->mark*$set->find(1)->set_percentage/100),2)}}</div>
                                                    {{$bot_mark}}
                                                @endif
                                                @if($row3->where('exmset_id',1)->count()==0)
                                                    <div class="d-none">{{$bot_mark = 0}}</div>
                                                    {{""}}

                                                @endif
                                            </td>


                                            <td>
                                                @if($row3->where('exmset_id',2)->count()>0)
                                                    <div class="d-none">{{$mot_mark = round(($row3->where('exmset_id',2)->first()->mark*$set->find(2)->set_percentage/100),2)}}</div>
                                                    {{$mot_mark}}
                                                @endif
                                                @if($row3->where('exmset_id',2)->count()==0)
                                                    <div class="d-none">{{$mot_mark = 0}}</div>
                                                    {{""}}

                                                @endif
                                            </td>


                                            <td>
                                                @if($row3->where('exmset_id',3)->count()>0)
                                                    <div class="d-none">{{$eot_mark = round(($row3->where('exmset_id',3)->first()->mark*$set->find(3)->set_percentage/100),2)}}</div>
                                                    {{$eot_mark}}
                                                @endif
                                                @if($row3->where('exmset_id',3)->count()==0)
                                                    <div class="d-none">{{$eot_mark = 0}}</div>
                                                    {{""}}
                                                @endif
                                            </td>

                                            <td>
                                                @if($row3->count()>0)

                                                    <div class="d-none">{{$total_mark = round((array_sum(array($bot_mark,$mot_mark,$eot_mark))),2)}}</div>
                                                    {{$total_mark}}

                                                @endif
                                            </td>

                                            <td>
                                                @if($row3->count()>0)
                                                    <div class="d-none">{{$total_mark}}</div>
                                                    {{$total_mark}}
                                                @endif
                                            </td>

                                            <td>

                                                @if($row3->count()>0)

                                                    <div class="d-none">{{$Subject_final_mark =  $total_mark}}</div>
                                                @if($Subject_final_mark>90)

                                                        <div class="d-none">{{$Subject_final_grade = "A+"}}</div>
                                                        {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=80 && $Subject_final_mark<90)
                                                    <div class="d-none">{{$Subject_final_grade = "A"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=75 && $Subject_final_mark<80)
                                                    <div class="d-none">{{$Subject_final_grade = "B+"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=70 && $Subject_final_mark<75)
                                                    <div class="d-none">{{$Subject_final_grade = "B-"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=65 && $Subject_final_mark<70)
                                                    <div class="d-none">{{$Subject_final_grade = "C+"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=60 && $Subject_final_mark<65)
                                                    <div class="d-none">{{$Subject_final_grade = "C-"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=55 && $Subject_final_mark<60)
                                                    <div class="d-none">{{$Subject_final_grade = "D+"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=50 && $Subject_final_mark<55)
                                                    <div class="d-none">{{$Subject_final_grade = "D-"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark<50)
                                                    <div class="d-none">{{$Subject_final_grade = "F"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @endif

                                            </td>

                                            <td>

                                                <span class="d-none"></span>
                                                @if ($Subject_final_grade == "A+")
                                                    {{$faker->randomElement(array('Excellent work','Keep it Up',"keep aiming higher"))}}
                                                @endif
                                                @if ($Subject_final_grade == "A")
                                                {{$faker->randomElement(array('Aim higher','You have greater Pontential',"Great hardwork, aim higher",'Goodwork'))}}
                                                @endif
                                                @if ($Subject_final_grade == "B+")
                                                {{$faker->randomElement(array('You could do better','You have greater Pontential',"Average","Good"))}}
                                                @endif
                                                @if ($Subject_final_grade == "B-")
                                                {{$faker->randomElement(array('You could do better','You have greater Pontential',"Fair work","Do Better"))}}
                                                @endif
                                                @if ($Subject_final_grade == "C+")
                                                {{$faker->randomElement(array('You could do better','Give your studies ample time',"Fair work","Utilize your teacher Well"))}}
                                                @endif
                                                @if ($Subject_final_grade == "C-")
                                                {{$faker->randomElement(array('You could do better','Give your studies ample time',"Fair work","Utilize your teacher Well"))}}
                                                @endif
                                                @if ($Subject_final_grade == "D+")
                                                {{$faker->randomElement(array('You are better than this','revise you books',"fair try","Utilize your teacher Well"))}}
                                                @endif
                                                @if ($Subject_final_grade == "D-")
                                                {{$faker->randomElement(array('You are better than this','revise you books',"fair try","Utilize your teacher Well"))}}
                                                @endif
                                                @if ($Subject_final_grade == "F")
                                                {{$faker->randomElement(array('Pull up your socks','Utilize your teacher Well','Read your books','Need of hardwork'))}}
                                                @endif


                                            </td>


                                        </tr>
                                    </tr>

                                @else

                                    <tr>
                                        <tr>
                                            <td colspan="2">
                                                {{$row3->first()->subject->name}}
                                            </td>
                                            <td>
                                                @if($row3->where('exmset_id',1)->count()>0)
                                                    <div class="d-none">{{$bot_mark = $row3->where('exmset_id',1)->first()->mark*$set->find(1)->set_percentage/100}}</div>
                                                    {{$bot_mark}}
                                                @endif
                                                @if($row3->where('exmset_id',1)->count()==0)
                                                    <div class="d-none">{{$bot_mark=0}}</div>
                                                    {{""}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($row3->where('exmset_id',2)->count()>0)
                                                    <div class="d-none">{{$mot_mark = $row3->where('exmset_id',2)->first()->mark*$set->find(2)->set_percentage/100}}</div>
                                                    {{$mot_mark}}
                                                @endif
                                                @if($row3->where('exmset_id',2)->count()==0)
                                                    <div class="d-none">{{$mot_mark=0}}</div>
                                                    {{""}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($row3->where('exmset_id',3)->count()>0)
                                                    <div class="d-none">{{$eot_mark = $row3->where('exmset_id',3)->first()->mark*$set->find(3)->set_percentage/100}}</div>
                                                    {{$eot_mark}}
                                                @endif
                                                @if($row3->where('exmset_id',3)->count()==0)
                                                    <div class="d-none">{{$eot_mark=0}}</div>
                                                    {{""}}
                                                @endif
                                            </td>

                                            <td>
                                                @if($row3->count()>0)

                                                    <div class="d-none">{{$final_total = round((array_sum(array($bot_mark,$mot_mark,$eot_mark))),2)}}</div>
                                                    {{$final_total}}

                                                @endif
                                            </td>

                                            <td>
                                                @if($row3->count()>0)
                                                    <div class="d-none">{{$final_total}}</div>
                                                    {{$final_total}}
                                                @endif
                                            </td>

                                            <td>

                                                @if($row3->count()>0)

                                                    <div class="d-none">{{$Subject_final_mark =  $final_total}}</div>
                                                @if($Subject_final_mark>90)

                                                        <div class="d-none">{{$Subject_final_grade = "A+"}}</div>
                                                        {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=80 && $Subject_final_mark<90)
                                                    <div class="d-none">{{$Subject_final_grade = "A"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=75 && $Subject_final_mark<80)
                                                    <div class="d-none">{{$Subject_final_grade = "B+"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=70 && $Subject_final_mark<75)
                                                    <div class="d-none">{{$Subject_final_grade = "B-"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=65 && $Subject_final_mark<70)
                                                    <div class="d-none">{{$Subject_final_grade = "C+"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=60 && $Subject_final_mark<65)
                                                    <div class="d-none">{{$Subject_final_grade = "C-"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=55 && $Subject_final_mark<60)
                                                    <div class="d-none">{{$Subject_final_grade = "D+"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark>=50 && $Subject_final_mark<55)
                                                    <div class="d-none">{{$Subject_final_grade = "D-"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @if($Subject_final_mark<50)
                                                    <div class="d-none">{{$Subject_final_grade = "F"}}</div>
                                                    {{$Subject_final_grade}}
                                                @endif
                                                @endif

                                            </td>

                                            <td>

                                                <span class="d-none"></span>
                                                @if ($Subject_final_grade == "A+")
                                                    {{$faker->randomElement(array('Excellent work','Keep it Up',"keep aiming higher"))}}
                                                @endif
                                                @if ($Subject_final_grade == "A")
                                                {{$faker->randomElement(array('Aim higher','You have greater Pontential',"Great hardwork, aim higher",'Goodwork'))}}
                                                @endif
                                                @if ($Subject_final_grade == "B+")
                                                {{$faker->randomElement(array('You could do better','You have greater Pontential',"Average","Good"))}}
                                                @endif
                                                @if ($Subject_final_grade == "B-")
                                                {{$faker->randomElement(array('You could do better','You have greater Pontential',"Fair work","Do Better"))}}
                                                @endif
                                                @if ($Subject_final_grade == "C+")
                                                {{$faker->randomElement(array('You could do better','Give your studies ample time',"Fair work","Utilize your teacher Well"))}}
                                                @endif
                                                @if ($Subject_final_grade == "C-")
                                                {{$faker->randomElement(array('You could do better','Give your studies ample time',"Fair work","Utilize your teacher Well"))}}
                                                @endif
                                                @if ($Subject_final_grade == "D+")
                                                {{$faker->randomElement(array('You are better than this','revise you books',"fair try","Utilize your teacher Well"))}}
                                                @endif
                                                @if ($Subject_final_grade == "D-")
                                                {{$faker->randomElement(array('You are better than this','revise you books',"fair try","Utilize your teacher Well"))}}
                                                @endif
                                                @if ($Subject_final_grade == "F")
                                                {{$faker->randomElement(array('Pull up your socks','Utilize your teacher Well','Read your books','Need of hardwork'))}}
                                                @endif


                                            </td>


                                        </tr>
                                    </tr>

                                @endif

                            @endforeach

                        @endforeach

                    @endforeach
                </tbody>
                <tfoot class="text-center">
                    <th colspan="2">Subject</th>
                    <th> Bot <br>Out Of {{App\Exmset::find(1)->set_percentage}}</th>
                    <th> Mot <br>Out Of {{App\Exmset::find(2)->set_percentage}}</th>
                    <th> Eot <br>Out Of {{App\Exmset::find(3)->set_percentage}}</th>
                    <th>Total Marks <br> of 100</th>
                    <th>Final Mark</th>
                    <th>Final Grade</th>
                    <th>Teacher Comment</th>
                </tfoot>
            </table>
        </div>
        <div class="card-footer row d-flex align-content-left bg-light">
            <div class="col-12 row d-flex justify-content-center">
            <a class="mx-auto" href="{{url('report-pdf-export/'.$student->id)}}" target="_blanck"> <i class="fa fa-print"></i> </a>
            </div>
            {{-- <div class="col-md-6 mr-auto">
                <small>{{$results->appends(Request::query())->render()}}</small>
            </div>
            <div class="col-md-6 ml-auto">
                {{$results->count()}} {{str_plural('Item',$results->count())}}
            </div> --}}
        </div>
    </div>
@else

    <div class="card card-body row d-flex justify-content-center p-4 bg-light col-md-8 mx-auto text-center">

        <p>No Result history yet</p>
    </div>

@endif

@endsection
