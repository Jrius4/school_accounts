<div class="form-group col-md-8">
    <label>Student Name</label>
    <input type="hidden" name="level" value="Ordinary Level">
    <select name="student_name" id="student_name" class="d-block col-12 form-control">
        <option value="">student o-level semi-or-candinate</option>
        @foreach ($students as $student)
            <option value="{{$student->id}}">{{$student->name.' -> '.$student->schclass->name}}</option>
        @endforeach
    </select>

</div>
<div class="form-group col-md-8">
    <label>Option One</label>
    <select name="first_o_subject" id="first_o_subject" class="d-block col-12 form-control">
        <option value="">Select First Option</option>
        @foreach ($subjects as $subject)
            <option value="{{$subject->id}}">{{$subject->name}}</option>
        @endforeach
    </select>
</div>
<div class="form-group col-md-8">
    <label>Option Two</label>

    <select name="second_o_subject" id="second_o_subject"  class="d-block col-12 form-control">
            <option value="">Select Second Option</option>
            @foreach ($subjects as $subject)
                <option value="{{$subject->id}}">{{$subject->name}}</option>
            @endforeach
    </select>
</div>
<div class="form-group col-md-8">
    <label>Option Three</label>
    <select name="third_o_subject" id="third_o_subject"  class="d-block col-12 form-control">
                <option value="">Select Third Option</option>
                @foreach ($subjects as $subject)
                    <option value="{{$subject->id}}">{{$subject->name}}</option>
                @endforeach
    </select>
</div>
<div class="form-group col-md-8">
    <button class="btn btn-sm btn-primary d-block col-12" type="submit" name="submit">Set Combination</button>
</div>
