@extends('layouts.base')

@section('title', 'Welcome')

@section('custom_css_link', asset('Css/Home_style/main.css'))

@section('main-content')
<form action="#" method="POST">
  @csrf
  <div class="row justify-content-center h-100">
    <div class="d-flex flex-column align-items-center main-content col-10 col-lg-8">
      <div class="logo-wrapper d-flex align-items-center justify-content-center gap-3">
        <img src="{{asset('img/jti_logo.png')}}" class="jti-logo" />
        <div class="text-wrapper gap-1">
          <p class="m-0 head-title">Sistem Informasi</p>
          <h1 class="fw-bold m-0 main-title">REPOSITORI SKRIPSI JTI</h1>
        </div>
      </div>
      <div class="input-group mt-4">
        <input type="text" class="form-control py-2 px-3 search-input border-0" placeholder="Search"
          aria-label="Recipient's username" aria-describedby="basic-addon2" />
        <button type="submit" class="input-group-text btn btn-danger d-flex align-items-center fs-5 px-3"
          id="basic-addon2">
          <i class="ri-search-line"></i>
        </button>
      </div>
    </div>
  </div>
</form>
@endsection