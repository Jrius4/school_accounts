<div class="row">
    <div class="form-group d-block col-md-12">
        <label >account category name</label>
        <input type="text" name="name" class="form-control col-12 @error('name') is-invalid @enderror" placeholder="Account Category Name"/>
        @error('name')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <div class="btn-group col-12">
        <input type="submit" name="create-account-form" value="Create New Account" class="btn btn-dark btn-sm-block col" placeholder="Account Name"/>
        <a  href="{{route('acc-category.index')}}" role="button" class="btn btn-secondary btn-sm-block col">Cancel</a>
    </div>
</div>
