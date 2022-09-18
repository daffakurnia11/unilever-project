@extends('layouts.main')

@section('content')

  <!--Header-->
  <div class="page-breadcrumb d-flex flex-column flex-md-row align-items-center mb-3">
    <div class="breadcrumb-title pe-md-3">Hallo, {{ auth()->user()->name }}</div>
    <div class="ps-md-3 ms-md-auto mx-auto mx-md-0 mt-3 mt-md-0">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 p-0">
          <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
      </nav>
    </div>
  </div>
  <!--end of Header--> 

  @foreach ($sidebars as $menu)
    @if ($menu->plant_type == 'Panel')
    <h6 class="mb-0 text-uppercase">{{ $menu->plant_name }} Monitoring</h6>
    <hr>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xxl-3">
      <div class="col">
        <div class="card radius-10">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-0 text-secondary">
                  First Temperature Status : <span class="{{ $menu->plant_name }}-status1"></span>
                </p>
                <h4 class="my-1">
                  <span class="{{ $menu->plant_name }}-temperature1">0</span>
                  <sup>o</sup>C
                </h4>
                <p class="mb-0 font-13 text-success">
                  <i class="bi bi-caret-up-fill"></i>
                  <span class="{{ $menu->plant_name }}-timestamp">-</span>
                </p>
              </div>
              <div class="widget-icon-large bg-gradient-purple text-white ms-auto">
                <i class="bi bi-thermometer-half"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card radius-10">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-0 text-secondary">
                  Second Temperature Status : <span class="{{ $menu->plant_name }}-status2"></span>
                </p>
                <h4 class="my-1">
                  <span class="{{ $menu->plant_name }}-temperature2">0</span>
                  <sup>o</sup>C
                </h4>
                <p class="mb-0 font-13 text-success">
                  <i class="bi bi-caret-up-fill"></i>
                  <span class="{{ $menu->plant_name }}-timestamp">-</span>
                </p>
              </div>
              <div class="widget-icon-large bg-gradient-success text-white ms-auto">
                <i class="bi bi-thermometer-half"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card radius-10">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-0 text-secondary">
                  Third Temperature Status : <span class="{{ $menu->plant_name }}-status3"></span>
                </p>
                <h4 class="my-1">
                  <span class="{{ $menu->plant_name }}-temperature3">0</span>
                  <sup>o</sup>C
                </h4>
                <p class="mb-0 font-13 text-success">
                  <i class="bi bi-caret-up-fill"></i>
                  <span class="{{ $menu->plant_name }}-timestamp">-</span>
                </p>
              </div>
              <div class="widget-icon-large bg-gradient-danger text-white ms-auto">
                <i class="bi bi-thermometer-half"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    @else
    <h6 class="mb-0 text-uppercase">{{ $menu->plant_name }} Monitoring</h6>
    <hr>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2">
      <div class="col">
        <div class="card radius-10">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-0 text-secondary">
                  Current Status : <span class="{{ $menu->plant_name }}-status1"></span>
                </p>
                <h4 class="my-1">
                  <span class="{{ $menu->plant_name }}-current">0</span>
                  Ampere
                </h4>
                <p class="mb-0 font-13 text-success">
                  <i class="bi bi-caret-up-fill"></i>
                  <span class="{{ $menu->plant_name }}-timestamp">-</span>
                </p>
              </div>
              <div class="widget-icon-large bg-gradient-purple text-white ms-auto">
                <i class="bi bi-lightning-charge"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card radius-10">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-0 text-secondary">
                  Temperature Status : <span class="{{ $menu->plant_name }}-status2"></span>
                </p>
                <h4 class="my-1">
                  <span class="{{ $menu->plant_name }}-temperature">0</span>
                  <sup>o</sup>C
                </h4>
                <p class="mb-0 font-13 text-success">
                  <i class="bi bi-caret-up-fill"></i>
                  <span class="{{ $menu->plant_name }}-timestamp">-</span>
                </p>
              </div>
              <div class="widget-icon-large bg-gradient-success text-white ms-auto">
                <i class="bi bi-thermometer-half"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row row-cols-1 row-cols-sm-3 row-cols-md-3 row-cols-xl-3">
      <div class="col">
        <div class="card radius-10">
          <div class="card-body text-center">
            <div class="widget-icon mx-auto mb-1 bg-light-purple text-purple">
              <i class="bi bi-arrow-bar-right"></i>
            </div>
            <p class="mb-0">X-axis</p>
            <h3 class="mt-1 mb-0"><span class="{{ $menu->plant_name }}-xAxis"></span> deg</h3>
            <small id="xProgress" class="text-success">
              <i class="bi bi-caret-up-fill"></i>
              <span class="{{ $menu->plant_name }}-timestamp">-</span>
            </small>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card radius-10">
          <div class="card-body text-center">
            <div class="widget-icon mx-auto mb-1 bg-light-orange text-orange">
              <i class="bi bi-arrow-bar-up"></i>
            </div>
            <p class="mb-0">Y-axis</p>
            <h3 class="mt-1 mb-0"><span class="{{ $menu->plant_name }}-yAxis"></span> deg</h3>
            <small id="yProgress" class="text-success">
              <i class="bi bi-caret-up-fill"></i>
              <span class="{{ $menu->plant_name }}-timestamp">-</span>
            </small>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card radius-10">
          <div class="card-body text-center">
            <div class="widget-icon mx-auto mb-1 bg-light-success text-success">
              <i class="bi bi-arrow-bar-down"></i>
            </div>
            <p class="mb-0">Z-axis</p>
            <h3 class="mt-1 mb-0"><span class="{{ $menu->plant_name }}-zAxis"></span> deg</h3>
            <small id="PowerProgress" class="text-success">
              <i class="bi bi-caret-up-fill"></i>
              <span class="{{ $menu->plant_name }}-timestamp">-</span>
            </small>
          </div>
        </div>
      </div>
    </div>
        
    @endif
  @endforeach

@endsection

@section('javascript')
  <script>
    const url = "{{ $api_url }}all/latest";

    function getTimestamp(timestamp) {
      let date = moment(timestamp).format("MMM, DD YYYY - HH:mm:ss");
      return date;
    }

    var updateDashboard = () => {
      $.ajax({
        type: 'GET',
        url: url,
        dataType: 'JSON',
        success: function(resp) {
          resp.data.forEach(data => {
            if (data.plant_type == 'Panel') {
              const temperature1 = data.sensor_panel[0].temperature1;
              const temperature2 = data.sensor_panel[0].temperature2;
              const temperature3 = data.sensor_panel[0].temperature3;
              let status1 = '';
              let status2 = '';
              let status3 = '';

              if (temperature1 < data.set_point.warning1) {
                status1 = 'Safe';
              } else if (temperature1 >= data.set_point.danger1) {
                status1 = 'DANGER!';
              } else {
                status1 = 'Warning!';
              }

              if (temperature2 < data.set_point.warning2) {
                status2 = 'Safe';
              } else if (temperature2 >= data.set_point.danger2) {
                status2 = 'DANGER!';
              } else {
                status2 = 'Warning!';
              }

              if (temperature3 < data.set_point.warning3) {
                status3 = 'Safe';
              } else if (temperature3 >= data.set_point.danger3) {
                status3 = 'DANGER!';
              } else {
                status3 = 'Warning!';
              }

              $(`.${data.plant_name}-temperature1`).html(temperature1)
              $(`.${data.plant_name}-temperature2`).html(temperature2)
              $(`.${data.plant_name}-temperature3`).html(temperature3)
              $(`.${data.plant_name}-status1`).html(status1)
              $(`.${data.plant_name}-status2`).html(status2)
              $(`.${data.plant_name}-status3`).html(status3)
              $(`.${data.plant_name}-timestamp`).html(getTimestamp(data.sensor_panel[0].created_at))
            }
            else if (data.plant_type == 'Motor') {
              const current = data.sensor_motor[0].ampere;
              const temperature = data.sensor_motor[0].temperature;
              let status1 = '';
              let status2 = '';

              if (current < data.set_point.warning3) {
                status1 = 'Safe';
              } else if (current >= data.set_point.danger3) {
                status1 = 'DANGER!';
              } else {
                status1 = 'Warning!';
              }

              if (temperature < data.set_point.warning2) {
                status2 = 'Safe';
              } else if (temperature >= data.set_point.danger2) {
                status2 = 'DANGER!';
              } else {
                status2 = 'Warning!';
              }

              $(`.${data.plant_name}-current`).html(current)
              $(`.${data.plant_name}-temperature`).html(temperature)
              $(`.${data.plant_name}-status1`).html(status1)
              $(`.${data.plant_name}-status2`).html(status2)
              $(`.${data.plant_name}-xAxis`).html(data.sensor_motor[0].x_axis)
              $(`.${data.plant_name}-yAxis`).html(data.sensor_motor[0].y_axis)
              $(`.${data.plant_name}-zAxis`).html(data.sensor_motor[0].z_axis)
              $(`.${data.plant_name}-timestamp`).html(getTimestamp(data.sensor_motor[0].created_at))
            }
          });
        }
      })
    }

    updateDashboard();
    setInterval(() => {
      updateDashboard();
    }, 5000);
  </script>
@endsection