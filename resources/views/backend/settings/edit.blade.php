@extends('backend.layouts.app')

{{-- website title --}}
@section('title','Setting')

{{-- website css --}}
@section('css')
<style></style>
@endsection

{{-- website body content --}}
@section('content')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>General Setting</h3>
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

                  <form action="{{route('setting.store')}}" method="POST" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                      <label class="col-lg-2 col-md-2 col-sm-4 col-form-label"><strong>Shop Name <span class="text-danger">*</span></strong></label>
                      <div class="col-lg-10 col-md-10 col-sm-8">
                        <input type="text" name="shop_name" class="form-control" value="{{isset($setting->shop_name)?$setting->shop_name:''}}" required>
                        <span class="text-danger">{{ $errors->first('shop_name') }}</span>
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label class="col-lg-2 col-md-2 col-sm-4 col-form-label"><strong>Contact No.</strong></label>
                      <div class="col-lg-10 col-md-10 col-sm-8">
                        <input type="text" name="shop_contact" class="form-control" value="{{isset($setting->shop_contact)?$setting->shop_contact:''}}">
                        <span class="text-danger">{{ $errors->first('shop_contact') }}</span>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-lg-2 col-md-2 col-sm-4 col-form-label"><strong>Address</strong></label>
                      <div class="col-lg-10 col-md-10 col-sm-8">
                        <textarea name="address" class="form-control" cols="10" rows="3">{{isset($setting->address)?$setting->address:''}}</textarea>
                        <span class="text-danger">{{ $errors->first('address') }}</span>
                      </div>
                    </div>

                    <button type="submit" class="btn btn-outline-primary">Save</button>
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