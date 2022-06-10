@extends('backend.layouts.app')

{{-- website title --}}
@section('title','Reports')

{{-- website css --}}
@section('css')
<style></style>
@endsection

{{-- website body content --}}
@section('content')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    @php
      $monthValue = '';
      if (isset($month)) {
        $monthValue = '('.$month.')';
      }
    @endphp
    <h1 class="h2">Monthly Report {{$monthValue}}</h1>
  </div>

  @if (\Session::has('errorMessage'))
    <div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
      <div class="d-flex align-items-center justify-content-start">
        <i class="icon ion-ios-close alert-icon tx-32"></i>
        <span><strong>Error!  </strong> {!! \Session::get('errorMessage') !!}</span>
      </div>
    </div>
  @endif

  <form action="{{ route('order.month.report') }}" method="GET">
    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="month">From:</label>
        <input type="month" class="form-control" name="month" required>
      </div>
      <div class="form-group col-md-9 pt-1">
        <button type="submit" class="btn btn-primary mt-4"><i class="fa fa-search"></i> Search</button>
        <a href="{{route('order.month.report')}}" class="btn btn-secondary mt-4 float-right"><i class="fa fa-times"></i> Clear Filter</a>
      </div>
    </div>
  </form>

  <div class="row row-sm">
    <div class="col-lg-12 mg-t-20 mg-lg-t-0">

      <div class="table-responsive-sm mt-3">
        <table class="table table-bordered text-center">
          <thead class="thead-light">
            <tr>
              <th>Total<br>Reports</th>
              <th>Total<br>Quantity</th>
              <th>Purchase<br>Price</th>
              <th>Sale<br>Price</th>
              <th>Sub<br>Total</th>
              <th>Sale<br>Status</th>
              <th>Total<br>Expense</th>
              <th>Net<br>Total</th>
            </tr>
          </thead>
          <thead class="thead-light">
            <tr>
              <th>{{ isset($total_reports) ? $total_reports : 0 }}</th>
              <th>{{ isset($total_product_quantity) ? $total_product_quantity : 0 }}</th>
              <th>Rs: {{ isset($total_purchase_price) ? $total_purchase_price : 0 }}</th>
              <th>Rs: {{ isset($total_sale_price) ? $total_sale_price : 0 }}</th>
              <th>Rs: {{ isset($gross_total) ? $gross_total : 0 }}</th>
              @if(isset($sale_status))
                @if($sale_status == 'P')
                  <th class="text-success">{{ 'Profit' }}</th>
                @elseif($sale_status == 'L')
                  <th class="text-danger">{{ 'Loss' }}</th>
                @endif
              @else
                <th>{{ 'N/A' }}</th>
              @endif
              <th class="text-danger">Rs: -{{ isset($total_expense) ? $total_expense : 0 }}</th>
              <th>Rs: {{ isset($net_total) ? $net_total : 0 }}</th>
            </tr>
          </thead>
        </table>
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
