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

  <h6 class="mb-0 text-uppercase">BMP280 Temperature Sensor Monitoring</h6>
  <hr>
  <div class="card">
    <div class="card-body">
      <div id="temperatureChart"></div>
    </div>
  </div>
  <h6 class="mb-0 text-uppercase">BMP280 Pressure Sensor Monitoring</h6>
  <hr>
  <div class="card">
    <div class="card-body">
      <div id="pressureChart"></div>
    </div>
  </div>

@endsection

@section('javascript')
<script>
//   const url = 'http://128.199.87.189';
  const url = 'http://192.168.55.102/unilever-project/public/api';
  const sensorName = '{{ $sensor->plant_name }}';

  // Generating random data
  function getRndInteger(min, max) {
    return Math.floor(Math.random() * (max - min + 1) ) + min;
  }
  var generateData = function () {
    $.ajax({
      type: "POST",
      url: url + `/${sensorName}`,
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
        url: url + '/api/Panel1/temperature?filter=5&unit=minutes',
        dataType: 'JSON',
        success: function (resp) {
          resp.data[0].temperature.forEach(data => {
            let time = moment(data.created_at).format("MMM, DD YYYY - HH:mm:ss");
            let dataJson = {x: time, y: data.temperature};
            dataTemperature1.push(dataJson);
          });

          resp.data[1].temperature.forEach(data => {
            let time = moment(data.created_at).format("MMM, DD YYYY - HH:mm:ss");
            let dataJson = {x: time, y: data.temperature};
            dataTemperature2.push(dataJson);
          });

          resp.data[2].temperature.forEach(data => {
            let time = moment(data.created_at).format("MMM, DD YYYY - HH:mm:ss");
            let dataJson = {x: time, y: data.temperature};
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
        }
      });

      $.ajax({
        type: "GET",
        url: url + '/api/Panel1/temperature?filter=5&unit=minutes',
        dataType: 'JSON',
        success: function (resp) {
          resp.data[0].temperature.forEach(data => {
            let time = moment(data.created_at).format("MMM, DD YYYY - HH:mm:ss");
            let dataJson = {x: time, y: data.pressure};
            dataPressure1.push(dataJson);
          });

          resp.data[1].temperature.forEach(data => {
            let time = moment(data.created_at).format("MMM, DD YYYY - HH:mm:ss");
            let dataJson = {x: time, y: data.pressure};
            dataPressure2.push(dataJson);
          });

          resp.data[2].temperature.forEach(data => {
            let time = moment(data.created_at).format("MMM, DD YYYY - HH:mm:ss");
            let dataJson = {x: time, y: data.pressure};
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
      generateData();
      updateChart();
    }, 5000);
  </script>
  @endsection