<div class="row container col-xl-12">

    <div class="form-group col-md-12 d-block">
        <label for="term">Term</label>
        <select name="term" id="term" class="form-control @error('term') is-invalid @enderror col-12">
            <option value="">Choose Term</option>
            @foreach ($terms as $row)
                <option value="{{$row->id}}" @if(old('term')==$row->id) selected  @endif>{{$row->name}}</option>
            @endforeach
        </select>
        @error('term')
        <small class="text-danger">{{$message}}</small>
        @enderror
    </div>

    <div class="row col-md-12 d-block form-group">
        <div class="card-body table-responsive p-0">
            <table class="table table-striped table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <th>Entry Name</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @if($schoolAcctypes->count()>0)
                    @foreach ($schoolAcctypes as $row)

                        <tr>
                            <td>
                                <label>{{$row->account_name}} :</label>
                            </td>
                            <td style="min-width:350px">
                            <input value="{{old($row->account_slug)?old($row->account_slug):''}}" name="{{$row->account_slug}}" type="text" class="form-control" style="min-width:100%"  placeholder="enter {{strtolower($row->account_name)}} amount">
                            @error($row->account_slug)
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                            </td>
                        </tr>

                    @endforeach
                @else
                    <tr>
                        <td>
                            <label>Amount :</label>
                        </td>
                        <td style="min-width:350px">
                        <input value="{{old('amount')?old('amount'):''}}" name="amount" type="text" class="form-control" style="min-width:100%"  placeholder="Enter Amount">
                            @error('amount')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </td>
                    </tr>
                @endif
                <tr>
                    <td>
                        <label>If Not Specified :</label>
                    </td>
                    <td style="min-width:350px">
                    <input  value="{{old('not-specified')?old('not-specified'):''}}" name="not-specified" type="text" class="form-control" style="min-width:100%"  placeholder="Enter If Not Specified">
                    @error('not-specified')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>

    <div class="form-group col-md-12 d-block">
        <label>Paid By</label>
        <input name="paid_by" type="text" id="paid_by" class="form-control @error('paid_by') is-invalid @enderror col-12"/>
        @error('paid_by')
        <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <div class="form-group col-md-12 d-block">
        <label>Description</label>
        <textarea name="description" id="description" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror col-12"></textarea>
    </div>




</div>
<div class="row">
    <div class="form-group col-md-12 d-block">
        <input name="student-payment" type="submit" value="Student Payment" id="student-payment" class="btn btn-block btn-dark col-12"/>
    </div>
</div>
