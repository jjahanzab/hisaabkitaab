@extends('backend.layouts.app')

{{-- website title --}}
@section('title','Dashboard')

{{-- website css script --}}
@section('css')
@endsection

{{-- website body content --}}
@section('content')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    {{-- <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group mr-2">
        <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
      </div>
      <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
        <span data-feather="calendar"></span>
        This week
      </button>
    </div> --}}
  </div>
  <div class="row justify-content-center">
      <div class="col-md-12">
          
        <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>

      </div>
  </div>
@endsection

{{-- website js script --}}
@section('js')
<script src="{{ asset('public/assets/dashboard/feather.min.js') }}"></script>
<script src="{{ asset('public/assets/dashboard/Chart.min.js') }}"></script>
<script>
  $(document).ready(function() {
    // auto close all alerts
    setTimeout(function() {
        $(".alert").alert('close');
    }, 3000);
  });

  /* globals Chart:false, feather:false */

  var labels = [];
  var records = [];
  function loadChart() {
    // 'use strict'
    feather.replace();
    var ctx = document.getElementById('myChart');

    $.ajax({
        url : '{{route('load.chart')}}',
        type: "GET",
        dataType: 'json',
        async: false,
        success: function(response){
          if (response.statusCode == 200) {

            records_rows = response.records;
            records_rows.map((item)=>{
              labels.push(item.order_date);
              records.push(item.total_sub_total);
            })

          } else if (response.statusCode == 404) {
            console.log(response.message);
          }
        },
        error: function(){
          console.log('error in load chart data');
        }
      });
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        // labels: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        labels: labels,
        datasets: [{
          // data: [ 15339, 21345, 18483, 24003, 23489, 24092, 12034],
          data: records,
          lineTension: 0,
          backgroundColor: 'transparent',
          borderColor: '#007bff',
          borderWidth: 4,
          pointBackgroundColor: '#007bff'
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: false
            }
          }]
        },
        legend: {
          display: false
        }
      }
    })
  }
  loadChart()

</script>
@endsection
