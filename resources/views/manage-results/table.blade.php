
<div class="sparkline13-graph" style="color:whitesmoke !important">
    <div class="datatable-dashv1-list custom-datatable-overright">
        <table class="table" id="table" data-toggle="table" data-pagination="true" data-search="true" data-key-events="true" data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" data-click-to-select="true" data-toolbar="#toolbar">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Result</th>
                    <th colspan="3">vvvvv</th>

                </tr>
            </thead>
            <tbody>

                        {{-- @foreach ($results as $res)
                            <tr>
                                <td>{{$res->student->name}}</td>
                                <td>{{$res->subject->name}}</td>
                                <td>
                                    @if ($res->paper!=null)
                                        {{$res->paper->paper_abbrev}}
                                    @endif
                                </td>
                                <td>{{$res->mark}}</td>
                            </tr>
                         @endforeach --}}

                         @foreach ($students as $stud)

                         <tr>
                         <td>{{$stud->name}}</td>
                             <td>{{$stud->name}}</td>
                             <td>{{$stud->schclass->name}}</td>

                                 @if ($stud->results()->count() >0)
                                    <td bgcolor="#45fg453" rowspan="{{$stud->results()->count()}}">
                                        @foreach ($stud->results()->get() as $res)
                                            <p>

                                                <p>{{$subjs->find($res->subject_id)->name}}</p>

                                                    @foreach ($subjs->find($res->subject_id)->results()->get() as $res2)
                                                        <p>{{$res2->mark}}</p>
                                                    @endforeach

                                            </p>
                                        @endforeach
                                    </td>
                                 @endif

                         </tr>

                         @endforeach








            </tbody>
        </table>
    </div>
</div>
