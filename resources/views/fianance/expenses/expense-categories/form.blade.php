<div class="row">
    <div class="form-group d-block col-md-12">
        <label >Expense category name</label>
        <input type="text" name="name" class="form-control col-12 @error('name') is-invalid @enderror" placeholder="Account Category Name"/>
        @error('name')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <div class="form-group d-block col-md-12">
        <input type="submit" name="create-account-form" value="Create New Account" class="btn btn-dark btn-sm-block col-12" placeholder="Account Name"/>
    </div>
</div>
