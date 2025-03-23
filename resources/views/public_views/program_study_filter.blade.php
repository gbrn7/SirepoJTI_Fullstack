@extends('layouts.base')

@section('title', 'Pencarian Berdasarkan Program Studi')

@section('custom_css_link', asset('css/Home_style/main.css'))

@section('main-content')
<div class="filter-title-wrapper text-center fw-semibold mt-5">
  Pencarian Berdasarkan Program Studi
</div>
<div class="list-wrapper mt-3">
  <ul>
    @foreach ($programs as $program)
    <li class="list-wrapper-list"><a href="{{route('home', ['program_study_id'=> $program->id])}}"
        class="text-decoration-none" data-cy="link-filter">{{$program->program}} <span>({{$program->total}})</span></a>
    </li>
    @endforeach
  </ul>
</div>
@endsection