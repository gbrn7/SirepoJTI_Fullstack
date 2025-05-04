@extends('layouts.base')

@section('title', 'Pencarian Berdasarkan Jenis Tugas Akhir')

@section('custom_css_link', asset('css/Home_style/main.css'))

@section('main-content')
<div class="filter-title-wrapper text-center fw-semibold mt-5">
  Pencarian Berdasarkan Jenis Tugas Akhir
</div>
<div class="list-wrapper mt-3">
  <ul>
    @foreach ($types as $type)
    <li class="list-wrapper-list"><a href="{{route('home', ['type_id' => $type->id])}}" class="text-decoration-none"
        data-cy="link-filter">{{$type->type}}
        <span>({{$type->total}})</span></a></li>
    @endforeach
  </ul>
</div>
@endsection