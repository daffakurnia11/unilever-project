@extends('layouts.main')

@section('content')

  <!--Header-->
  <div class="page-breadcrumb d-flex flex-column flex-md-row align-items-center mb-3">
    <div class="breadcrumb-title pe-md-3">{{ $sensor->plant_name }} Set Point</div>
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

  <h6 class="mb-0 text-uppercase">Motor Set Point</h6>
  <hr>
  <div class="card col-xxl-8">
    <form action="" method="POST">
      @csrf
      <div class="card-body">
        <h6 class="mb-0 text-uppercase">{{ $sensor->plant_name }} Sensors</h6>
        <hr>
        <div class="row justify-content-center">
          <div class="col-sm-6">
            <div class="card">
              <div class="card-header">
                <h6 class="card-title">Temperature Sensor</h6>
              </div>
              <div class="card-body">
                <label for="name" class="form-label">Warning</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="warning2">
                  <span class="input-group-text"><sup>o</sup>C</span>
                </div>
                <label for="name" class="form-label">Danger</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="danger2">
                  <span class="input-group-text"><sup>o</sup>C</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="card">
              <div class="card-header">
                <h6 class="card-title">Volt and Current Sensor</h6>
              </div>
              <div class="card-body">
                <label for="name" class="form-label">Warning</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="warning3">
                  <span class="input-group-text"><sup>o</sup>C</span>
                </div>
                <label for="name" class="form-label">Danger</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="danger3">
                  <span class="input-group-text"><sup>o</sup>C</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Change set points</button>
      </div>
    </form>
  </div>

@endsection