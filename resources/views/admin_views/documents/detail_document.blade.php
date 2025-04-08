@extends('layouts.base')

@section('title', 'Tugas Akhir')

@section('custom_css_link', asset('css/User-Document_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">Tugas Akhir</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item align-items-center">
        <a href="{{route('home')}}" class="text-decoration-none">Beranda</a>
      </li>
      <li class="breadcrumb-item align-items-center">
        <a href="{{route('documents-management.index')}}" class="text-decoration-none">Tugas Akhir</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        Detail Data Tugas Akhir {{$document->student->username}}
      </li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
@include('layouts.detail_document')
@endsection