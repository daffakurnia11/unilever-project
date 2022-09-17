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

  <h6 class="mb-0 text-uppercase">MLX Temperature Sensor Monitoring</h6>
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

  <h6 class="mb-0 text-uppercase">ADXL Vibration Sensor Monitoring</h6>
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

  <h6 class="mb-0 text-uppercase">PZEM Volt and Current Sensor Monitoring</h6>
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

@endsection

@section('javascript')
<script>
  const url = 'http://128.199.87.189';

  let params = (new URL(document.location)).searchParams;
  let filter = params.get("filter");
  let unit = params.get("unit");

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
        url: url + `/api/Motor1/temperature?filter=${filter}&unit=${unit}`,
        dataType: 'JSON',
        success: function (resp) {
          resp.data[0].temperature.forEach(data => {
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
        }
      });

      $.ajax({
        type: "GET",
        url: url + `/api/Motor1/vibration?filter=${filter}&unit=${unit}`,
        dataType: 'JSON',
        success: function (resp) {
          resp.data[0].vibration.forEach(data => {
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
        }
      });

      $.ajax({
        type: "GET",
        url: url + `/api/Motor1/current?filter=${filter}&unit=${unit}`,
        dataType: 'JSON',
        success: function (resp) {
          resp.data[0].current.forEach(data => {
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
    }, 5000);
  </script>
  @endsection