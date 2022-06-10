@extends('backend.layouts.app')

{{-- website title --}}
@section('title','Orders')

{{-- website css --}}
@section('css')
<style></style>
@endsection

{{-- website body content --}}
@section('content')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Orders</h1>
  </div>
  
  @if (\Session::has('messageWeightDelivery'))
    <div class="alert alert-success" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
      <div class="d-flex align-items-center justify-content-start">
        <i class="icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>
        <span><strong>Success!  </strong>{!! \Session::get('messageWeightDelivery') !!}</span>
      </div>
    </div>
  @endif
  @if (\Session::has('errorMessageWeightDelivery'))
    <div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
      <div class="d-flex align-items-center justify-content-start">
        <i class="icon ion-ios-close alert-icon tx-32"></i>
        <span><strong>Error!  </strong> {!! \Session::get('errorMessageWeightDelivery') !!}</span>
      </div>
    </div>
  @endif

  <div class="row row-sm">
    <div class="col-lg-12 mg-t-20 mg-lg-t-0">

      <div class="card mb-5">
        <div class="card-body">
          
          <form action="{{ route('order.save') }}" method="POST">
            @csrf
            <table class="table table-borderless">
              <thead>
                <tr>
                  <th scope="col">To Start</th>
                  <th scope="col">To End</th>
                  <th scope="col">Charges</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>

              <tbody id="weight-delivery-tbody">
                  @php
                    $increment = 0;
                  @endphp
                @isset($weight_delivery)

                  @foreach($weight_delivery as $x)
                    <tr>
                      <td>
                        <input type="number" step="0" oninput="((this.value < 0) ?  this.value = (this.value * -1 ): this.value = this.value )" min="0" required="" name="weight_start[{{$increment}}]" value="{{$x->weight_start}}" class="form-control">
                      </td>
                      <td>
                        <input type="number" step="0" oninput="((this.value < 0) ?  this.value = (this.value * -1 ): this.value = this.value )" min="0" required="" name="weight_end[{{$increment}}]" value="{{$x->weight_end}}" class="form-control">
                      </td>
                      <td>
                        <input type="number" step="0.01" oninput="((this.value < 0) ?  this.value = (this.value * -1 ): this.value = this.value )" min="0" required name="charges[{{$increment}}]" value="{{$x->charges}}" class="form-control">
                      </td>
                      <td><button type="button" class="btn btn-outline-danger" onclick="removeRecord({{$x->id}} , event, 'weight')">Remove</button></td>
                    </tr>
                    
                    @php
                      $increment++
                    @endphp
                  @endforeach
                  
                @endisset
              </tbody>

              <tfoot>
                <tr class="text-center">
                  <td colspan=4> <button type="button" class="btn btn-outline-primary btn-sm rounded-circle js-add--exam-row" onclick="addNewRowInWeight({{$increment}})">+</button>
                  </td>
                </tr>
                <tr>
                  <td colspan=4>
                    <button type="submit" class="btn btn-outline-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Save Changes</button>
                  </td>
                </tr>
              </tfoot>
            </table>
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
    // auto close all alerts
    setTimeout(function() {
        $(".alert").alert('close');
    }, 3000);
  });

  token = '{{Session::token()}}';
  var count = 0;
  function addNewRowInWeight(i){
    i = i+ count;
    $('#weight-delivery-tbody').append('<tr><td><input type="number" oninput="((this.value < 0) ?  this.value = (this.value * -1 ): this.value = this.value )" step="0" min="0" name="weight_start['+i+']" required="" class="form-control"></td><td><input name="weight_end['+i+']" type="number" step="0" oninput="((this.value < 0) ?  this.value = (this.value * -1 ): this.value = this.value )" min="0" required="" class="form-control"></td><td><input required="" name="charges['+i+']" type="number" step="0.01" oninput="((this.value < 0) ?  this.value = (this.value * -1 ): this.value = this.value )" min="0" min="0.01" required name="charges['+i+']" class="form-control"></td> <td><button type="button" class="btn btn-outline-danger"onclick="removeNewRecord(event)">Remove</button></td></tr>');
    count++;
  }

  function removeRecord(d, event , type){
    id = d;
    if (id) {
      $.ajax({
        url : '{{route('order.delete')}}',
        type: "POST",
        data: {'id':id, 'type': type ,'_token': token},
        success: function(data){
            removeNewRecord(event);
        }
      })
    }
  }

  function removeNewRecord(event){
    event.target.parentElement.parentElement.remove();
  }
</script>
@endsection
