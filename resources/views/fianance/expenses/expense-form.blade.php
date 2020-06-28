<div class="row container col-xl-12">



    <div class="row col-lg-12 d-block">
        <div class="card-body table-responsive p-0">
            <div id="report"></div>
            <input type="hidden" value=1 id="rowNum" />
            <table class="table table-striped table-head-fixed text-nowrap form-group">
                <thead>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Units</th>
                        <th>Rate</th>
                </thead>
                <tbody>


                    <tr id="oldField">
                        <td>
                            <input id="item"  name="item" type="text" class="item form-control col-12 d-block"/>
                        </td>
                        <td>
                            <input id="quantity"  name="quantity" type="text" class="quantity form-control col-12 d-block"/>
                        </td>
                        <td>
                            <input id="units"  name="units" type="text" class="units form-control col-12 d-block"/>
                        </td>
                        <td>
                            <input id="rate"  name="rate" type="text" class="rate form-control col-12 d-block"/>
                        </td>
                    </tr>
                    {{-- <span id="addField"></span> --}}
                    <tr>
                        <td>
                            <input name="add-item" type="button" value="Add Item" id="add-item" class="btn btn-block btn-info col-12"/>
                        </td>
                    </tr>

                </tbody>
            </table>




        </div>
    </div>






</div>
<div class="row">


    <form action="{{route('expenses.store')}}" method="POST"  class="row container d-flex justify-content-center col-xl-12 col-lg-12 col-sm-12">

        @csrf


        <div id="results"></div>


        <div class="row container d-flex justify-content-center col-lg-12 col-sm-12">

            <div class="form-group col-md-6 d-block">
                <label for="term">Term</label>
                <select name="term" id="term" class="form-control @error('term') is-invalid @enderror col-12 action-acc">
                    <option value="">Choose Term</option>
                    @foreach ($terms as $row)
                        <option value="{{$row->id}}" @if(old('term')==$row->id) selected  @endif>{{$row->name}}</option>
                    @endforeach
                </select>
                @error('term')
                    <small class="text-danger">{{$message}}</small>
                @enderror
                <span id="expense-term-error"></span>
            </div>

            <div class="form-group col-md-6 d-block">
                <label for="category">Category</label>
                <select name="category" id="category" class="form-control @error('category') is-invalid @enderror col-12 action-acc">
                    <option value="">Choose Expense Category</option>
                    @if ($cats->count() > 0)
                        @foreach ($cats as $row)
                            <option value="{{$row->id}}" @if(old('category')==$row->id) selected  @endif>{{$row->account_name}}</option>
                        @endforeach
                    @endif

                </select>
                @error('category')
                    <small class="text-danger">{{$message}}</small>
                @enderror

            </div>
        </div>

        <div id="borrowing" style="width:100%;display:block;justify-content:center"></div>



        <div class="row container d-flex justify-content-center col-md-12">

            <div class="form-group col-md-12 d-block">
                <label>Requested By</label>
                <input name="requested_by" type="text" value="{{old('requested_by')?old('requested_by'):''}}" id="requested_by" class="form-control @error('requested_by') is-invalid @enderror col-12"/>
                @error('requested_by')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="form-group col-md-12 d-block">
                <label>Description</label>
                <textarea name="description" id="description" value="{{old('description')?old('description'):''}}" class="form-control col-12" cols="30" rows="10" placeholder="Enter Description Optional"></textarea>
            </div>

            <div class="form-group col-md-12 d-block">
                <input name="make-expense" type="submit" value="Make Expense" id="make-expense" class="btn btn-block btn-dark col-12"/>
            </div>

        </div>

        <div>

        </div>

    </form>




</div>

@include('fianance.expenses.scripts')
