@extends('backend.layouts.app')

{{-- website title --}}
@section('title','Products')

{{-- website css --}}
@section('css')
<style></style>
@endsection

{{-- website body content --}}
@section('content')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>Edit Product</h3>
    <a class="btn btn-dark btn-sm" href="{{ route('product.index') }}"> <i class="fas fa-long-arrow-alt-left"></i> Back</a>
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

                  <form action="{{route('product.update')}}" method="POST" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="slug" value="{{$product->slug}}">

                    <div class="form-group row">
                      <label class="col-lg-2 col-md-2 col-sm-4 col-form-label"><strong>Category <span class="text-danger">*</span></strong></label>
                      <div class="col-lg-10 col-md-10 col-sm-8">
                        <select name="category_id" class="form-control" data-placeholder="Choose Category" required>
                          <option value="">choose category</option>
                          @if($categories)
                            @foreach($categories as $category)
                              <option value="{{$category->id}}" {{$product->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                            @endforeach
                          @endif
                        </select>
                        <span class="text-danger">{{ $errors->first('category_id') }}</span>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-lg-2 col-md-2 col-sm-4 col-form-label"><strong>Name <span class="text-danger">*</span></strong></label>
                      <div class="col-lg-10 col-md-10 col-sm-8">
                        <input type="text" name="name" class="form-control" value="{{$product->name}}" required>
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-lg-2 col-md-2 col-sm-4 col-form-label"><strong>Price <span class="text-danger">*</span></strong></label>
                      <div class="col-lg-10 col-md-10 col-sm-8">
                        <input type="number" name="price" class="form-control" value="{{$product->price}}" required>
                        <span class="text-danger">{{ $errors->first('price') }}</span>
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label class="col-lg-2 col-md-2 col-sm-4 col-form-label"><strong>Quantity <span class="text-danger">*</span></strong></label>
                      <div class="col-lg-10 col-md-10 col-sm-8">
                        <input type="number" name="quantity" class="form-control" value="{{$product->quantity}}" required>
                        <span class="text-danger">{{ $errors->first('quantity') }}</span>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-lg-2 col-md-2 col-sm-4 col-form-label"><strong>Product Code</strong></label>
                      <div class="col-lg-10 col-md-10 col-sm-8">
                        <input type="text" name="product_code" class="form-control" value="{{$product->product_code}}">
                        <span class="text-danger">{{ $errors->first('product_code') }}</span>
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label class="col-lg-2 col-md-2 col-sm-4 col-form-label"><strong>Manufacturer</strong></label>
                      <div class="col-lg-10 col-md-10 col-sm-8">
                        <input type="text" name="manufacturer" class="form-control" value="{{$product->manufacturer}}">
                        <span class="text-danger">{{ $errors->first('manufacturer') }}</span>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-lg-2 col-md-2 col-sm-4 col-form-label"><strong>Supplier</strong></label>
                      <div class="col-lg-10 col-md-10 col-sm-8">
                        <input type="text" name="supplier" class="form-control" value="{{$product->supplier}}">
                        <span class="text-danger">{{ $errors->first('supplier') }}</span>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-lg-2 col-md-2 col-sm-4 col-form-label"><strong>Picture</strong></label>
                      <div class="col-lg-10 col-md-10 col-sm-8">
                        <input name="pic" type="file" class="form-control">
                        <span class="text-danger">{{ $errors->first('pic') }}</span>
                      </div>
                    </div>

                    @if ($product->pic)
                      <div class="form-group row">
                        <label class="col-lg-2 col-md-2 col-sm-4 col-form-label"><strong>Old Picture</strong></label>
                        <div class="col-lg-10 col-md-10 col-sm-8">
                          <img src='{{ asset("public/uploads/products/$product->pic") }}' alt="no-pic" height="80px" width="100px">
                        </div>
                      </div>
                    @endif

                    <div class="form-group row">
                      <label class="col-lg-2 col-md-2 col-sm-4 col-form-label"><strong>Description</strong></label>
                      <div class="col-lg-10 col-md-10 col-sm-8">
                        <textarea name="description" class="form-control" cols="10" rows="3">{{$product->description}}</textarea>
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-lg-2 col-md-2 col-sm-4 col-form-label"><strong>Status</strong></label>
                      <div class="col-lg-10 col-md-10 col-sm-8">
                        <div class="form-check">
                          <input type="checkbox" name="status" class="form-check-input" id="status" {{$product->status == 'A'?'checked':''}}>
                          <label class="form-check-label" for="status">Active</label>
                        </div>
                      </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
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