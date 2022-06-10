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
    <h1 class="h2">Reports List</h1>
    <a class="btn btn-outline-secondary btn-sm" href="{{ route('order.create') }}"> <i class="fa fa-plus"></i> Create Report</a>
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

      <div class="table-responsive-sm mt-3">
        <table class="table table-bordered text-center">
          <thead class="thead-dark">
            <tr>
              <th>Report<br>Date</th>
              <th>Report<br>No</th>
              <th>Total<br>Qty</th>
              <th>Purchase<br>Price</th>
              <th>Sale<br>Price</th>
              <th>Sub<br>Total</th>
              <th>Sale<br>Status</th>
              <th>Total<br>Expense</th>
              <th>Net<br>Total</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="tbody">
            @isset($ordertotals)
              @foreach ($ordertotals as $report)
                @php
                  $sale_status = ''; $sub_total_sign = '';
                  if ($report->sale_status == 'P') {
                    $sale_status = 'Profit';
                    $sub_total_sign = '+';
                  } else if ($report->sale_status == 'L') {
                    $sale_status = 'Loss';
                    $sub_total_sign = '-';
                  }
                @endphp
                <tr>
                  <td class="bg-light">
                    <b>{{date('d-m-Y', strtotime($report->order_date))}}</b>
                  </td>
                  <td>{{$report->order_number}}</td>
                  <td>{{$report->total_product_quantity}}</td>
                  <td>{{$report->total_purchase_price}}</td>
                  <td>{{$report->total_sale_price}}</td>
                  <td class="bg-light">
                    <b>{{$sub_total_sign}}{{$report->total_sub_total}}</b>
                  </td>
                  <td>{{$sale_status}}</td>
                  <td>-{{$report->total_expense}}</td>
                  <td class="bg-light">
                    <b>{{$report->net_total}}</b>
                  </td>
                  <td>
                    <button type="button" class="btn btn-outline-info" onclick="viewOrders({{$report->order_number}})"><i class="fas fa-eye"></i></button>
                    <a href="{{ route('order.delete.report', $report->slug) }}" class="btn btn-outline-danger" onclick="return confirm('Are you sure want to delete?')"><i class="fas fa-trash-alt"></i></a>
                  </td>
                </tr>
              @endforeach
            @endisset
          </tbody>
        </table>
      </div>
      {{$ordertotals->links()}}
    </div>
  </div>

  <!-- Button trigger modal -->
  {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-xl">Launch xl modal</button> --}}

  <!-- Report Orders Modal -->
  <div class="modal fade bd-example-modal-xl" id="ordersModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myLargeModalLabel">Report No.<span id="report_no"></span> (<span id="report_date"></span>)</h5>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        </div>
        <div class="modal-body">

          <div class="table-responsive-sm">
            <table class="table table-bordered text-center mb-0">
              <thead class="thead-dark">
                <tr>
                  <th>No</th>
                  <th>Product</th>
                  <th>Qty</th>
                  <th>Purchase</th>
                  <th>Sale</th>
                  <th>SubTotal</th>
                  <th>Status</th>
                  <th>Expense</th>
                  <th>Expense Detail</th>
                </tr>
              </thead>
              <tbody id="modalBody"></tbody>
            </table>
          </div>

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

  function viewOrders(order_no) {
    if (order_no) {
      $.ajax({
        url : '{{route('order.detail.list')}}',
        type: "POST",
        data: {'order_no':order_no, _token:"{{csrf_token()}}"},
        dataType: 'json',
        async: false,
        success: function(response){
          if (response.statusCode == 200) {
            document.getElementById('modalBody').innerHTML = '';
            document.getElementById('modalBody').innerHTML = response.table;
            document.getElementById('report_no').innerText = order_no;
            document.getElementById('report_date').innerText = response.report_date;
            $("#ordersModal").modal("show");

          } else if (response.statusCode == 404) {
            console.log(response.message);
          }
        },
        error: function(){
          console.log('error in change category dropdown');
        }
      });
    }
  }
</script>
@endsection
