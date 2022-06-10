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
    <h3>Products List</h3>
    <a class="btn btn-dark btn-sm" href="{{ route('product.create') }}"> <i class="fa fa-plus"></i> New Product</a>
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
                  <div class="table-responsive-sm">
                    <table class="table table-bordered text-center">
                      <thead class="thead-dark">
                      <tr>
                        <th>No</th>
                        <th>Category</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Pic</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>

                        @if(isset($products) && count($products)>0)
                          @foreach($products as $product)
                            <tr>
                              <td scope="row">{{ $loop->index + 1 }}</td>
                              <td>
                                @php
                                  $category = \App\Category::where('id', $product->category_id)->first();
                                  if (isset($category)) {
                                    echo $category->name;
                                  }
                                @endphp
                              </td>
                              <td>{{ $product->name }}</td>
                              <td>{{ $product->price }}</td>
                              <td>{{ $product->quantity ? $product->quantity : 0 }}</td>
                              <td>
                                @if ($product->pic)
                                  <img src='{{ asset("public/uploads/products/$product->pic") }}' alt="no-pic" height="80px" width="100px">
                                @else
                                  no-pic
                                @endif
                              </td>
                              <td>
                                <a href="{{ route('product.edit', $product->slug) }}" class="btn btn-outline-info"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('product.delete', $product->slug) }}" class="btn btn-outline-danger" onclick="return confirm('Are you sure want to delete?')"><i class="fas fa-trash-alt"></i></a>
                              </td>
                            </tr>
                          @endforeach
                        @else
                          <tr>
                            <td colspan="5">Records Not Found</td>
                          </tr>
                        @endif
                      </tbody>
                    </table>
                  </div>
                  {{$products->links()}}
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
