@extends('layouts.main')

@section('content')

  <!--Header-->
  <div class="page-breadcrumb d-flex flex-column flex-md-row align-items-center mb-3">
    <div class="breadcrumb-title pe-md-3">{{ $sensor->plant_name }} Monitoring</div>
    <div class="ps-md-3 ms-md-auto mx-auto mx-md-0 mt-3 mt-md-0">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 p-0">
          <li class="breadcrumb-item">
            <a href="/">
              Dashboard
            </a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">{{ $sensor->plant_name }}</li>
        </ol>
      </nav>
    </div>
  </div>
  <!--end of Header--> 

  <div class="d-flex align-items-center justify-content-between">
    <h6 class="mb-0 text-uppercase">BMP280 Temperature Sensor Monitoring</h6>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
      Filter
    </button>
  </div>
  <hr>
  <div class="card">
    <div class="card-body">
      <div id="temperatureChart"></div>
    </div>
  </div>
  
  <div class="d-flex align-items-center justify-content-between">
    <h6 class="mb-0 text-uppercase">BMP280 Pressure Sensor Monitoring</h6>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
      Filter
    </button>
  </div>
  <hr>
  <div class="card">
    <div class="card-body">
      <div id="pressureChart"></div>
    </div>
  </div>

  <!-- Filter Modal -->
  <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Filter Form</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/{{ $sensor->plant_name }}/monitoring" method="get">
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="mb-3">
                  <label for="filter" class="form-label">Time interval</label>
                  <input type="text" class="form-control" id="filter" name="filter" value="{{ $request->filter }}">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="mb-3">
                  <label for="by" class="form-label">Time unit</label>
                  <select class="form-select" id="by" name="by">
                    <option {{ $request->by == 'minutes' ? 'selected' : '' }} value="minutes">Minutes</option>
                    <option {{ $request->by == 'hours' ? 'selected' : '' }} value="hours">Hours</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Filter</button>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection

@section('javascript')
<script>
  const url = '{{ $api_url }}';
  const sensorName = '{{ $sensor->plant_name }}';
  let params = (new URL(document.location)).searchParams;
  let filter = params.get("filter");
  let by = params.get("by");
  let sensorQuery = `data`;
  if (filter && by) {
    sensorQuery = `data?filter=${filter}&by=${by}`;
  } 

  // Generating random data
  function getRndInteger(min, max) {
    return Math.floor(Math.random() * (max - min + 1) ) + min;
  }
  var generateData = function () {
    $.ajax({
      type: "POST",
      url: url + `${sensorName}`,
      data: {
        temperature1: getRndInteger(20, 30),
        temperature2: getRndInteger(20, 30),
        temperature3: getRndInteger(20, 30),
        pressure1: getRndInteger(100, 200),
        pressure2: getRndInteger(100, 200),
        pressure3: getRndInteger(100, 200),
      },
      success: function(data) {
        console.log(data);
      }
    });
  }

  var chartOption = {
    chart: {
      type: 'line',
      height: 300
    },
    series: [{
      name: 'temperature',
      data: []
    }],
    stroke: {
      show: true,
      curve: 'smooth',
      lineCap: 'butt',
      colors: undefined,
      width: 3,
      dashArray: 0,      
    },
    xaxis: {
      labels: {
        show: false,
      },
      tooltip: {
        enabled: false,
      }
    },
    title: {
      text: undefined,
      align: 'center',
      style: {
        fontSize:  '14px',
        fontWeight:  'bold',
      },
    }
  }

  var temperatureChart = new ApexCharts(document.getElementById("temperatureChart"), chartOption);
  temperatureChart.render();
  var pressureChart = new ApexCharts(document.getElementById("pressureChart"), chartOption);
  pressureChart.render();
  
  var updateChart = function () {
      var dataTemperature1 = [];
      var dataTemperature2 = [];
      var dataTemperature3 = [];

      var dataPressure1 = [];
      var dataPressure2 = [];
      var dataPressure3 = [];

      $.ajax({
        type: "GET",
        url: url + `${sensorName}/${sensorQuery}`,
        dataType: 'JSON',
        success: function (resp) {
          resp.data.sensor_panel.forEach(data => {
            let time = moment(data.created_at).format("MMM, DD YYYY - HH:mm:ss");
            let dataJson = {x: time, y: data.temperature1};
            dataTemperature1.push(dataJson);
          });

          resp.data.sensor_panel.forEach(data => {
            let time = moment(data.created_at).format("MMM, DD YYYY - HH:mm:ss");
            let dataJson = {x: time, y: data.temperature2};
            dataTemperature2.push(dataJson);
          });

          resp.data.sensor_panel.forEach(data => {
            let time = moment(data.created_at).format("MMM, DD YYYY - HH:mm:ss");
            let dataJson = {x: time, y: data.temperature3};
            dataTemperature3.push(dataJson);
          });

          temperatureChart.updateOptions({
            series: [{
              name: 'First Temperature Sensor',
              data: dataTemperature1
            },{
              name: 'Second Temperature Sensor',
              data: dataTemperature2
            },{
              name: 'Third Temperature Sensor',
              data: dataTemperature3
            }],
            title: {
              text: "BMP280 Temperature Sensor"
            }
          })
          
          resp.data.sensor_panel.forEach(data => {
            let time = moment(data.created_at).format("MMM, DD YYYY - HH:mm:ss");
            let dataJson = {x: time, y: data.pressure1};
            dataPressure1.push(dataJson);
          });

          resp.data.sensor_panel.forEach(data => {
            let time = moment(data.created_at).format("MMM, DD YYYY - HH:mm:ss");
            let dataJson = {x: time, y: data.pressure2};
            dataPressure2.push(dataJson);
          });

          resp.data.sensor_panel.forEach(data => {
            let time = moment(data.created_at).format("MMM, DD YYYY - HH:mm:ss");
            let dataJson = {x: time, y: data.pressure3};
            dataPressure3.push(dataJson);
          });

          pressureChart.updateOptions({
            series: [{
              name: 'First Pressure Sensor',
              data: dataPressure1
            },{
              name: 'Second Pressure Sensor',
              data: dataPressure2
            },{
              name: 'Third Pressure Sensor',
              data: dataPressure3
            }],
            title: {
              text: "BMP280 Pressure Sensor"
            }
          })
        }
      });
    }

    updateChart();
    setInterval(() => {
      // generateData();
      updateChart();
    }, 5000);
  </script>
  @endsection