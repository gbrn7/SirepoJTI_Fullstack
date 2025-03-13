@extends('layouts.base')

@section('title', 'Pencarian Berdasarkan Penulis')

@section('custom_css_link', asset('css/Home_style/main.css'))

@section('main-content')
<div class="filter-title-wrapper text-center fw-semibold mt-3 mt-md-5">
  Pencarian Berdasarkan Penulis
</div>
<div class="alphabet-filter-wrapper text-center mt-3">
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=A">A</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=B">B</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=C">C</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=D">D</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=E">E</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=F">F</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=G">G</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=H">H</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=I">I</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=J">J</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=K">K</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=L">L</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=M">M</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=N">N</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=O">O</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=P">P</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=Q">Q</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=R">R</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=S">S</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=T">T</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=U">U</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=V">V</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=W">W</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=X">X</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=Y">Y</a>
  <span> | </span>
  <a class="alphabet-filter" href="{{route('filter.author.view')}}?alphabet=Z">Z</a class="">
</div>
<div class="list-wrapper mt-3">
  <div class="h1">{{request()->alphabet ?request()->alphabet.'...':'A...' }}</div>
  <ul class="mt-2">
    @foreach ($authors as $author)
    <li class="list-wrapper-list"><a href="" class="text-decoration-none">{{$author->last_name}},
        {{$author->first_name}} <span>({{$author->total}})</span></a></li>
    @endforeach
  </ul>
</div>
@endsection