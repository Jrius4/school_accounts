                        <div class="form-group py col-md-8">
                            <label for="name" class="@error('name') text-danger @enderror">Subject Name</label>
                            <input type="text" name="name" id="name" placeholder="Subject Name" class="form-control d-block col-12 @error('name') is-invalid @enderror" value="@if(old('name')!==null){{old('name')}}@elseif($subject->exists()){{$subject->name}}@endif">
                            @error('name')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group py col-md-8">
                            <label for="subject_code" class="@error('subject_code') text-danger @enderror">Subject Code</label>
                            <input type="text" name="subject_code" id="sub_code" placeholder="Subject Name" class="form-control d-block col-12 @error('subject_code') is-invalid @enderror" value="@if(old('subject_code')!==null){{old('subject_code')}}@elseif($subject->exists()){{$subject->subject_code}}@endif">
                            @error('subject_code')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group py col-md-8">
                            <label for="name" class="@error('level') text-danger @enderror">Subject Level</label>
                            <select name="level" id="level" class="form-control d-block col-12 @error('level') is-invalid @enderror">
                                <option value="">Select Level</option>
                                <option value="Both" @if(old('level')=='Both') selected @elseif($subject->exists() && $subject->level == 'Both') selected @endif>Both</option>
                                <option value="Advanced Level" @if(old('level')=='Advanced Level') selected @elseif($subject->exists() && $subject->level == 'Advanced Level') selected @endif>Advanced Level</option>
                                <option value="Ordinary Level" @if(old('subject_code')=='Ordinary Level') selected @elseif($subject->exists() && $subject->level == 'Ordinary Level') selected @endif>Ordinary Level</option>
                            </select>
                            @error('level')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group py col-md-8">
                            <label for="sub_comp" class="@error('subject_compulsory') text-danger @enderror">Compulsory?</label>
                            <select name="subject_compulsory" id="sub_comp" class="form-control d-block col-12 @error('subject_compulsory') is-invalid @enderror">
                                <option value="">Select option</option>
                                <option value="1" @if(old('subject_compulsory')=='1') selected @elseif($subject->exists() && $subject->subject_compulsory == '1') selected @endif>Yes</option>
                                <option value="0" @if(old('subject_compulsory')=='0') selected @elseif($subject->exists() && $subject->subject_compulsory == '0') selected @endif>No</option>
                            </select>
                            @error('subject_compulsory')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-8 py">
                            <button type="submit" class="btn btn-info d-block col-12">Submit</button>
                        </div>
