@extends('layouts.main')

@section('content')

@if (session()->has('message'))
  <div id="flash-data" data-flashdata="{{ session('message') }}"></div>
@endif

<div class="authentication-card">
  <div class="card shadow rounded-0 overflow-hidden">
    <div class="row g-0">
      <div class="col-lg-12">
        <div class="card-body p-4 p-sm-5">
          <h5 class="card-title">Log In</h5>
          <p class="card-text mb-3">Unilever Internship Project</p>
          <form action="/auth" method="POST" class="form-body">
            @csrf
            <hr>
            <div class="row g-3">
              <div class="col-12">
                <label for="username" class="form-label">Username</label>
                <div class="ms-auto position-relative">
                  <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-envelope-fill"></i></div>
                  <input type="text" name="username" class="form-control radius-30 ps-5" id="username" placeholder="Username">
                </div>
              </div>
              <div class="col-12">
                <label for="password" class="form-label">Password</label>
                <div class="ms-auto position-relative">
                  <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-lock-fill"></i></div>
                  <input type="password" name="password" class="form-control radius-30 ps-5" id="password" placeholder="Password">
                </div>
              </div>
              <div class="col-12">
                <div class="d-grid">
                  <button type="submit" class="btn btn-primary radius-30">Log In</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
