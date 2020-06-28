<div class="row">
    <div class="form-group d-block col-md-12">
        <label >Account name*</label>
        <input type="text" name="account_name" class="form-control col-12 @error('account_name') is-invalid @enderror" placeholder="Account Name"/>
        @error('account_name')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <div class="form-group d-block col-md-12">
        <label >Amount to Pay</label>
        <input type="text" name="to_pay" class="form-control col-12 @error('to_pay') is-invalid @enderror" placeholder="Account to pay"/>
        @error('to_pay')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <div class="form-group d-block col-md-12">
        <label >Choose Account Type*</label>
        <select type="text" name="type" id="typename" class="form-control col-12 @error('type') is-invalid @enderror">
            <option value="">Choose Account Type</option>
            @foreach ($types as $row)
                <option value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
        </select>
        @error('type')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <div id="typeInput"  class="form-group d-block col-12"></div>
    <div class="form-group d-block col-md-12">
        <label >Set Minium Account Balance</label>
        <input type="text" name="set_minium_balance" class="form-control col-12 @error('set_minium_balance') is-invalid @enderror" placeholder="Account to Set Minium Balance"/>
        <small class="text-info">Optional Only If you want a minium balance to the Account</small>
        @error('set_minium_balance')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <div class="form-group d-block col-md-12">
        <small class="text-danger">* Required Fields</small>
        <input type="submit" name="create-account-form" value="Create New Account" class="btn btn-dark btn-sm-block col-12" placeholder="Account Name"/>
    </div>
</div>

@section('others-scripts')
    <!-- jQuery -->
    <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    @include('fianance.accountant.scripts')
@endsection

