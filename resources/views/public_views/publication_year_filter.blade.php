@extends('layouts.base')

@section('title', 'Pencarian Berdasarkan Tahun Publikasi')

@section('custom_css_link', asset('css/Home_style/main.css'))

@section('main-content')
<div class="filter-title-wrapper text-center fw-semibold mt-5">
  Pencarian Berdasarkan Tahun Publikasi
</div>
<div class="list-wrapper mt-3">
  <ul>
    @foreach ($years as $year)
    <li class="list-wrapper-list"><a href="" class="text-decoration-none">{{$year->year}} <u
          class="text-decoration-none">({{$year->total}})</u></a></li>
    @endforeach
  </ul>
</div>
@endsection