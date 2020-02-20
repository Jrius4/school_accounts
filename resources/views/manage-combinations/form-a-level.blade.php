

                    <div class="form-group py col-md-8">
                        <label for="name">First Subject</label>
                        <select name="first_subject" id="first_subject" class="form-control col-12 d-block">
                            <option value="">Select First Subject</option>
                            @foreach ($subjects as $subject)
                                <option value="{{$subject->id}}">{{$subject->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group py col-md-8">
                        <label for="name">Second Subject</label>
                        <select name="second_subject" id="second_subject" class="form-control col-12 d-block">
                            <option value="">Select Second Subject</option>
                            @foreach ($subjects as $subject)
                                <option value="{{$subject->id}}">{{$subject->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group py col-md-8">
                        <label for="name">Third Subject</label>
                        <select name="third_subject" id="third_subject" class="form-control col-12 d-block">
                            <option value="">Select Third Subject</option>
                            @foreach ($subjects as $subject)
                                <option value="{{$subject->id}}">{{$subject->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" name="level" value="Advanced Level">
                    <div class="form-group py col-md-8">
                        <label for="combination_name">Combination Name</label>
                        <input type="text" name="combination_name" id="combination_name" class="form-control col-12 d-block"/>
                    </div>
                    <div class="form-group py col-md-8">
                        <label for="subsidiary">Subsidiary</label>
                        <select name="subsidiary" id="subsidiary" class="form-control col-12 d-block">
                            <option value="">Select Subsidiary</option>
                            <option value="Sub Math">Sub Math</option>
                            <option value="Sub ICT">Sub ICT</option>
                        </select>
                    </div>
                <div class="col-md-8 py col-md-8">
                    <button type="submit" class="btn btn-info col-12 d-block">Submit</button>
                </div>


