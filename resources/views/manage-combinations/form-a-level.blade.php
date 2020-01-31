

        <div class="form admin-panel-content animated bounce">



            <div class="container center-form">
                <span id="feature"></span>
            </div>
            <div class="container row  center-form">
                <div class="col-md-8 form-details">


                    <div class="form-group py">
                        <label for="name">First Subject</label>
                        <select name="first_subject" id="first_subject" class="form-control col-sm-12"></select>
                    </div>
                    <div class="form-group py">
                        <label for="name">Second Subject</label>
                        <select name="second_subject" id="second_subject" class="form-control col-sm-12"></select>
                    </div>
                    <div class="form-group py">
                        <label for="name">Third Subject</label>
                        <select name="third_subject" id="third_subject" class="form-control col-sm-12"></select>
                    </div>

                    <input type="hidden" name="level" value="Advanced Level">
                    <div class="form-group py">
                        <label for="combination_name">Combination Name</label>
                        <input type="text" name="combination_name" id="combination_name" class="form-control col-sm-12"/>
                    </div>
                    <div class="form-group py">
                        <label for="subsidiary">Subsidiary</label>
                        <select name="subsidiary" id="subsidiary" class="form-control col-sm-12">
                            <option value="">Select Subsidiary</option>
                            <option value="Sub Math">Sub Math</option>
                            <option value="Sub ICT">Sub ICT</option>
                        </select>
                    </div>
                <div class="col-md-8 py">
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </div>
            </div>
    </div>


<style>
    .center-form{
        display: flex;
        justify-content: center;
        width: 90%;
        margin-left: 5vw;
        margin-right: 5vw;

    }

.chk-class{
display: flex;
flex-wrap: wrap;
padding: 5px;
height: 250x;

}
.checklist{
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
    justify-content: start;
}
.chk .input-controls{
    display: flex;
    flex-wrap: wrap;
    color:aliceblue;
}
.checked-styled{
    display: inline;
    height: 15px;
    margin: 0.3vw;
    padding: 0.4vw;
}
.class-div{
    margin: 5px;
    padding-left: 5px;
}

.big-label{
padding-left: 10px;
padding-top:2px;
}
.checked-styled-stream{
padding-left: 25px;
padding-top: 3px

}

</style>


