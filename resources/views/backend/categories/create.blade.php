@extends('backend.layouts.app')

{{-- website title --}}
@section('title','Category')

{{-- website css --}}
@section('css')
<style></style>
@endsection

{{-- website body content --}}
@section('content')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>Create Category</h3>
    <a class="btn btn-dark btn-sm" href="{{ route('category.index') }}"> <i class="fas fa-long-arrow-alt-left"></i> Back</a>
  </div>

  @if (\Session::has('successMessage'))
    <div class="alert alert-success" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
      <div class="d-flex align-items-center justify-content-start">
        <i class="icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>
        <span><strong>Success!  </strong>{!! \Session::get('successMessage') !!}</span>
      </div>
    </div>
  @endif
  @if (\Session::has('errorMessage'))
    <div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
      <div class="d-flex align-items-center justify-content-start">
        <i class="icon ion-ios-close alert-icon tx-32"></i>
        <span><strong>Error!  </strong> {!! \Session::get('errorMessage') !!}</span>
      </div>
    </div>
  @endif

  <div class="row row-sm">
      <div class="col-lg-12 mg-t-20 mg-lg-t-0">
          <div class="card mb-5">
              <div class="card-body">

                  <form action="{{route('category.store')}}" method="POST" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                      <label class="col-lg-2 col-md-2 col-sm-4 col-form-label"><strong>Name <span class="text-danger">*</span></strong></label>
                      <div class="col-lg-10 col-md-10 col-sm-8">
                        <input type="text" name="name" class="form-control" value="{{old('name')}}" required>
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-lg-2 col-md-2 col-sm-4 col-form-label"><strong>Description</strong></label>
                      <div class="col-lg-10 col-md-10 col-sm-8">
                        <textarea name="description" class="form-control" cols="10" rows="3">{{old('description')}}</textarea>
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                      </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                  </form>
              </div>
          </div>
      </div>
  </div>
  
@endsection

{{-- website js script --}}
@section('js')
<script>
  $(document).ready(function() {
    setTimeout(function() {
      $(".alert").alert('close');
    }, 3000);
  });
</script>
@endsection