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
    <form action="http://192.168.55.102/unilever-project/public/api/{{ $sensor->plant_name }}" method="POST" id="setPointForm">
      @method('PATCH')
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
                  <input type="text" class="form-control" name="warning2" value="{{ $setpoints->warning2 }}">
                  <span class="input-group-text"><sup>o</sup>C</span>
                </div>
                <label for="name" class="form-label">Danger</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="danger2" value="{{ $setpoints->danger2 }}">
                  <span class="input-group-text"><sup>o</sup>C</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="card">
              <div class="card-header">
                <h6 class="card-title">Current Sensor</h6>
              </div>
              <div class="card-body">
                <label for="name" class="form-label">Warning</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="warning3" value="{{ $setpoints->warning3 }}">
                  <span class="input-group-text">Ampere</span>
                </div>
                <label for="name" class="form-label">Danger</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="danger3" value="{{ $setpoints->danger3 }}">
                  <span class="input-group-text">Ampere</span>
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

@section('javascript')
  <script>
    $('#setPointForm').submit((e) => {
      e.preventDefault();
      const url = $('#setPointForm').attr('action');

      const warning2 = $('input[name=warning2]').val();
      const warning3 = $('input[name=warning3]').val();
      const danger2 = $('input[name=danger2]').val();
      const danger3 = $('input[name=danger3]').val();

      $.ajax({
        url: url,
        type: 'PATCH',
        data: {
          warning2: warning2,
          warning3: warning3,
          danger2: danger2,
          danger3: danger3,
        },
        success: function(resp) {
          Swal.fire({
            title: resp.message,
            icon: 'success',
          })
          $('input[name=warning2]').val(resp.data.warning2);
          $('input[name=warning3]').val(resp.data.warning3);
          $('input[name=danger2]').val(resp.data.danger2);
          $('input[name=danger3]').val(resp.data.danger3);
        },
        error: function(resp) {
          Swal.fire({
            title: resp.status + ' ' + resp.statusText,
            icon: 'error',
          })
        }
      })
    })
  </script>
@endsection