@extends('layouts.base')

@section('title', 'Pencarian Berdasarkan Topik')

@section('custom_css_link', asset('css/Home_style/main.css'))

@section('main-content')
<div class="filter-title-wrapper text-center fw-semibold mt-5">
  Pencarian Berdasarkan Topik
</div>
<div class="list-wrapper mt-3">
  <ul>
    @foreach ($topics as $topic)
    <li class="list-wrapper-list"><a href="{{route('home', ['topic_id' => $topic->id])}}" class="text-decoration-none"
        data-cy="link-filter">{{$topic->topic}} <span>({{$topic->total}})</span></a></li>
    @endforeach
  </ul>
</div>
@endsection