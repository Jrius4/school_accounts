

        <div class="form admin-panel-content animated bounce">



                <div class="container center-form">
                    <span id="feature"></span>
                </div>
                <div class="container row  center-form">
                    <div class="col-md-8 form-details">


                        <div class="form-group py">
                            <label for="name">Subject Name</label>
                            <input type="text" name="name" id="name" placeholder="Subject Name" class="form-control col-sm-12">
                        </div>
                        <div class="form-group py">
                            <label for="name">Subject Code</label>
                            <input type="text" name="subject_code" id="sub_code" placeholder="Subject Name" class="form-control col-sm-12">
                        </div>
                        <div class="form-group py">
                            <label for="name">Subject Level</label>
                            <select name="level" id="level" class="form-control col-sm-12">
                                <option value="">Select Level</option>
                                <option value="Advanced Level">Advanced Level</option>
                                <option value="Ordinary Level">Ordinary Level</option>
                            </select>
                        </div>
                        <div class="form-group py">
                            <label for="sub_comp">Compulsory?</label>
                            <select name="subject_compulsory" id="sub_comp" class="form-control col-sm-12">
                                <option value="">Select Level</option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
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


