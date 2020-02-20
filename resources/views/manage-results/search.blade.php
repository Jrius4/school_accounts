
    <div row="container row d-flex justify-content-center">

        <div class="col-8 mx-auto">
            <div class="card elevation-2 animated flipInX col-12">
                <div class="card-header row">
                    <h3 class="card-title mr-auto">Search Results</h3>

                </div>
                <div class="card-body">
                    <form action="">
                        <div class="container row d-flex justify-content-center">
                            <div class="form-group col-12 my-1">
                                <label>Class</label>
                                <select name="schclass" id="schclass" class="action form-control">
                                    <option value="">Select Class</option>
                                    @foreach ($schclasses as $row)
                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12 my-1">
                                <label>Subject</label>
                                <select name="subject" id="subject" class="action form-control">
                                    <option value="">Select Subject</option>
                                    @foreach ($subjects as $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="form-group col-12 my-1">
                                <label>Exam Set</label>
                                <select name="examset" class="action form-control" id="examset">
                                    <option value="">Select Set</option>
                                    @foreach ($sets as $row)
                                        <option value="{{$row->id}}">{{$row->set_name}}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="form-group col-12 my-1">
                                <label>Term</label>
                                <select name="term" class="action form-control" id="term">
                                    <option value="">Select Term</option>
                                    @foreach ($terms as $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12 my-1">

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>


    <div row="container row d-flex justify-content-center">
        <div class="col-10 mx-auto my-2">
            <div class="card elevation-2 animated flipInX col-12">

                        <div id="resultz"></div>

            </div>
        </div>
    </div>


