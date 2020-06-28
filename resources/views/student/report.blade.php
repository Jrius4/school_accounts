<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{str_slug($student->name.' '.$student->roll_number,'-')}}</title>
    {{-- <link rel="stylesheet" href="{{asset('css/app.css')}}"> --}}
    {{-- <script src="{{asset('js/app.js')}}"></script> --}}
    <!-- Font Awesome -->
    {{-- <link rel="stylesheet" href="{{asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}"> --}}
    {{-- <link rel="stylesheet" href="{{asset('adminlte/plugins/fontawesome-free/js/all.min.js')}}"> --}}
    <style>
            body {
        margin: 0;
        padding: 0;
        background-color: #FAFAFA;
        font: 8pt "Tahoma";
    }
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
        width: 21cm;
        min-height: 29.7cm;
        padding: 1.5cm;
        margin: 1cm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    .subpage {
        padding: 1cm;
        border: 5px red solid;
        height: 256mm;
        outline: 2cm #FFEAEA solid;
    }

    @page {
        size: A4;
        margin: 0;
    }
    @media print {

  body {
        -webkit-print-color-adjust: exact !important;
        -moz-print-color-adjust: exact !important;
        -o-print-color-adjust: exact !important;
        -ms-print-color-adjust: exact !important;

      }

        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    }
        .d-none{
            display: none;
        }
        table{
            width: 100%;
        }
        table, th, td {
            padding: 10px;
            border: 1px solid black;
            border-collapse: collapse;
            }
        .thead ,tfoot{
            background-color: black !important;
            color: white;
        }
        .header-content{
            display: flex;
            justify-content: space-between;
        }
        .logo{
            width: 125pt;
            max-height: 35pt;
            /* transform: scale(1.5) */
        }
        .title{
            display: block;
            justify-content: center;
            text-align: center;

        }
        .table-title{
            text-align: center;
            color:black;
        }

    </style>
</head>
<body onload="window.print()" class="page">
    <div class="sub-page">
        <div class="header-content">
            <img class="logo" src="{{asset('schools/logos/logo.png')}}" alt=""/> <div class="title">
               <h2>FRIENDS ACADEMY <br> KITENDE</h2>
               <div>
                   <h4>MIXED DAY AND BOARDING SECONDARY SCHOOL</h4>
                   <h5>(ARTS & SCIENCES)</h5>
                   <h6>P.O BOX 27626 KAMPALA <br>
                    TEL:+256(0)303225968 <br>
                    friendsacademy.frack@gmail.com <br>
                    www.friendsacademyug.com
                    </h6>
                    <h3 style="text-align:center;width:100%">{{substr($student->roll_number,0,1)."'LEVEL END OF TERM REPORT"}}</h3>

               </div>
            </div><img width="75" height="75" class="img-circle" src="{{asset('images/'.$student->image)}}" alt="{{$student->name}}">
        </div>
        {{-- <div class="table-title">
            <h3 style="text-align:center;width:100%">{{substr($student->roll_number,0,1)."'LEVEL END OF TERM REPORT"}}</h3>
        </div> --}}

        <table>
            <tr>
                <td colspan="4">
                    Name: {{$student->name}}
                </td>
                <td colspan="2">
                    Class: {{$student->schclass->name}}
                </td>
                <td colspan="4">
                    Admission No:{{$student->roll_number}}
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    Term: {{$student->results->last()->term->name}}
                </td>
                <td colspan="2">
                    Stream: {{$student->schstream->name}}
                </td>
                <td colspan="4">
                    Year:{{date('Y')}}
                </td>
            </tr>

                <tr class="thead">
                    <th colspan="2">Subject</th>
                    <th> Bot <br>Out Of {{App\Exmset::find(1)->set_percentage}}</th>
                    <th> Mot <br>Out Of {{App\Exmset::find(2)->set_percentage}}</th>
                    <th> Eot <br>Out Of {{App\Exmset::find(3)->set_percentage}}</th>
                    <th>Total Marks <br> of 100</th>
                    <th>Final Mark</th>
                    <th>Final Grade</th>
                    <th>Teacher Comment</th>
                </tr>


            <tbody>

                @foreach ($results->groupBy('schclass_id') as $class_id=>$row2)
                {{-- <tr>
                    <td colspan="9">{{$class->find($class_id)->name}} {{$row2->first()->year}}</td>
                </tr> --}}

                    @foreach ($row2->groupBy('term_id') as $term_id=>$row2)

                        {{-- <tr>
                            <td colspan="9">{{$term->find($term_id)->name}}</td>
                        </tr> --}}

                        @foreach ($row2->groupBy('subject_id') as $sub_id=>$row3)

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
            {{-- <tfoot>
                <tr>
                    <th colspan="2">Subject</th>
                    <th> Bot <br>Out Of {{App\Exmset::find(1)->set_percentage}}</th>
                    <th> Mot <br>Out Of {{App\Exmset::find(2)->set_percentage}}</th>
                    <th> Eot <br>Out Of {{App\Exmset::find(3)->set_percentage}}</th>
                    <th>Total Marks <br> of 100</th>
                    <th>Final Mark</th>
                    <th>Final Grade</th>
                    <th>Teacher Comment</th>
                </tr>

            </tfoot> --}}
            <tr>
                <td colspan="4">
                    Average Percentage: {{$student->name}}
                </td>
                <td colspan="2">
                    Position: {{$student->schclass->name}}
                </td>

                    @if ($student->schclass_id>=5 && $student->schclass_id<=6)
                        <td colspan="4">
                        Points:
                        </td>
                    @endif
                    @if ( $student->schclass_id>2 && $student->schclass_id<=4)
                        <td colspan="2">
                            Aggregates in best 8:
                        </td>
                        <td colspan="2">
                            Division:
                        </td>
                    @endif
                    @if ( $student->schclass_id>=1 && $student->schclass_id<3)
                        <td colspan="2">
                            Total:
                        </td>

                    @endif

            </tr>
            <tr>
                <td colspan="11">
                    Class Teacher's commit:
                </td>
            </tr>
            <tr>
                <td colspan="11">
                    Class Teacher's commit:
                </td>
            </tr>
            <tr>
                <td colspan="11">
                    Unpaid Fees:
                </td>
            </tr>
            <tr>
                <td colspan="11">
                    Next Term Begins on:{{date('Y')}}
                </td>
            </tr>


            </tr>
        </table>

    </div>
{{-- <script type="text/javascript">
window.print()

</script> --}}
</body>
{{-- <body>
    <div id="report" class="container">
        <section class="row d-flex justify-content-center">
            <h4>FRIENDS ACADEMY KITENDE</h4>
        </section>
        <section class="" >
            <table class="">
                <thead>
                    <tr>
                        <th>
                            Programmer
                        </th>
                       <th>
                           Language
                       </th>
                       <th>
                           Use
                       </th>
                       <th>
                           Faculty
                       </th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <tr>
                            <td rowspan="2">
                                Kazibwe
                            </td>
                            <td>
                                Python
                            </td>
                            <td>
                                Logic
                            </td>
                            <td rowspan="2">
                                Data Science
                            </td>
                        </tr>
                        <tr>
                            <td>Javascript</td>
                            <td>Visuals</td>
                        </tr>
                    </tr>
                </tbody>
            </table>
        </section>



    </div>
    <footer>
            <div>
                <p>footer</p>
                <button class="btn btn-info" onclick="printPDF()"><i class="fa fa-print"></i></button>

            </div>
    </footer>
    <script src="{{asset('js/app.js')}}"></script>
  <script src="{{asset('adminlte/plugins/pdfmake/pdfmake.js')}}"></script>
  <script src="{{asset('adminlte/plugins/pdfmake/vfs_fonts.js')}}"></script>

    <script type="text/javascript">

        $(document).ready(function () {


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            window.print()
            console.log('ready')
            $('#print').click(function(e){
                e.preventDefault()
                $.print()
                // console.log('clicked')
                // htmlToPdfMake('#report')
            })
            function htmlToPdfMake(elementID)
            {

                var fullContent = "";
                var x = $(elementID).children();
                $.each(x,function(index,value){
                    fullContent+=$(this).html()
                    console.log(fullContent)
                });

                var dd = {
                    content:[
                        fullContent
                    ]
                };
                pdfMake.createPdf(dd).download('sample.pdf');
                console.log(dd.content)
            }
        });

    </script>
    <script type="text/javascript">
    function printPDF (){
        window.print('#report')
    }
    </script>

</body> --}}
</html>
