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
    <h6 class="mb-0 text-uppercase">MLX Temperature Sensor Monitoring</h6>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
      Filter
    </button>
  </div>
  <hr>
  <div class="row justify-content-center">
    <div class="col-xl-6">
      <div class="card">
        <div class="card-body">
          <div id="temperatureChart"></div>
        </div>
      </div>
    </div>
    <div class="col-xl-6">
      <div class="card">
        <div class="card-body">
          <div id="ambientChart"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="d-flex align-items-center justify-content-between">
    <h6 class="mb-0 text-uppercase">ADXL Vibration Sensor Monitoring</h6>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
      Filter
    </button>
  </div>
  <hr>
  <div class="row justify-content-center">
    <div class="col-xl-6">
      <div class="card">
        <div class="card-body">
          <div id="vibrationXChart"></div>
        </div>
      </div>
    </div>
    <div class="col-xl-6">
      <div class="card">
        <div class="card-body">
          <div id="vibrationYChart"></div>
        </div>
      </div>
    </div>
    <div class="col-xl-6">
      <div class="card">
        <div class="card-body">
          <div id="vibrationZChart"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="d-flex align-items-center justify-content-between">
    <h6 class="mb-0 text-uppercase">PZEM Volt and Current Sensor Monitoring</h6>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
      Filter
    </button>
  </div>
  <hr>
  <div class="row justify-content-center">
    <div class="col-xl-6">
      <div class="card">
        <div class="card-body">
          <div id="voltChart"></div>
        </div>
      </div>
    </div>
    <div class="col-xl-6">
      <div class="card">
        <div class="card-body">
          <div id="currentChart"></div>
        </div>
      </div>
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
  // const url = 'http://128.199.87.189';
  const url = 'http://192.168.55.102/unilever-project/public';
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
      url: url + `/api/${sensorName}`,
      data: {
        temperature: getRndInteger(20, 30),
        ambient: getRndInteger(20, 30),
        x_axis: getRndInteger(0, 10),
        y_axis: getRndInteger(0, 10),
        z_axis: getRndInteger(0, 10),
        volt: getRndInteger(210, 220),
        ampere: getRndInteger(0, 8),
        power: getRndInteger(0, 10),
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
  var ambientChart = new ApexCharts(document.getElementById("ambientChart"), chartOption);
  ambientChart.render();

  var vibrationXChart = new ApexCharts(document.getElementById("vibrationXChart"), chartOption);
  vibrationXChart.render();
  var vibrationYChart = new ApexCharts(document.getElementById("vibrationYChart"), chartOption);
  vibrationYChart.render();
  var vibrationZChart = new ApexCharts(document.getElementById("vibrationZChart"), chartOption);
  vibrationZChart.render();

  var voltChart = new ApexCharts(document.getElementById("voltChart"), chartOption);
  voltChart.render();
  var currentChart = new ApexCharts(document.getElementById("currentChart"), chartOption);
  currentChart.render();
  
  var updateChart = function () {
      var dataTemperature = [];
      var dataAmbient = [];

      var dataVibrationX = [];
      var dataVibrationY = [];
      var dataVibrationZ = [];

      var dataVolt = [];
      var dataCurrent = [];

      $.ajax({
        type: "GET",
        url: url + `/api/${sensorName}/${sensorQuery}`,
        dataType: 'JSON',
        success: function (resp) {
          resp.data.sensor_motor.forEach(data => {
            let time = moment(data.created_at).format("MMM, DD YYYY - HH:mm:ss");
            let temperature = {x: time, y: data.temperature};
            dataTemperature.push(temperature);
            let ambient = {x: time, y: data.ambient};
            dataAmbient.push(ambient);  
          });

          temperatureChart.updateOptions({
            series: [{
              name: 'Temperature',
              data: dataTemperature
            }],
            colors: ["#0d6efd"],
            title: {
              text: "Temperature Monitoring"
            }
          });

          ambientChart.updateOptions({
            series: [{
              name: 'Ambient',
              data: dataAmbient
            }],
            colors: ["#dc3545"],
            title: {
              text: "Ambient Monitoring"
            }
          });

          resp.data.sensor_motor.forEach(data => {
            let time = moment(data.created_at).format("MMM, DD YYYY - HH:mm:ss");
            let dataX = {x: time, y: data.x_axis};
            dataVibrationX.push(dataX);

            let dataY = {x: time, y: data.y_axis};
            dataVibrationY.push(dataY);

            let dataZ = {x: time, y: data.z_axis};
            dataVibrationZ.push(dataZ);
          });

          vibrationXChart.updateOptions({
            series: [{
              name: 'X Axis',
              data: dataVibrationX
            }],
            colors: ["#0d6efd"],
            title: {
              text: "X Axis Vibration"
            }
          });

          vibrationYChart.updateOptions({
            series: [{
              name: 'Y Axis',
              data: dataVibrationY
            }],
            colors: ["#dc3545"],
            title: {
              text: "Y Axis Vibration"
            }
          });

          vibrationZChart.updateOptions({
            series: [{
              name: 'Z Axis',
              data: dataVibrationZ
            }],
            colors: ["#198754"],
            title: {
              text: "Z Axis Vibration"
            }
          });

          resp.data.sensor_motor.forEach(data => {
            let time = moment(data.created_at).format("MMM, DD YYYY - HH:mm:ss");
            let volt = {x: time, y: data.volt};
            dataVolt.push(volt);

            let current = {x: time, y: data.ampere};
            dataCurrent.push(current);
          });

          voltChart.updateOptions({
            series: [{
              name: 'Volt',
              data: dataVolt
            }],
            colors: ["#0d6efd"],
            title: {
              text: "Volt Monitoring"
            }
          });

          currentChart.updateOptions({
            series: [{
              name: 'Current',
              data: dataCurrent
            }],
            colors: ["#dc3545"],
            title: {
              text: "Current Monitoring"
            }
          });
        }
      });
    }

    updateChart();
    setInterval(() => {
      updateChart();
      generateData();
    }, 5000);
  </script>
  @endsection