@extends('layouts.base')

@section('title', Route::is('student-management.create') ? 'Tambah Data Mahasiswa' : 'Edit Data Mahasiswa')

@section('custom_css_link', asset('css/Form_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">{{Route::is('student-management.create') ? 'Tambah Data Mahasiswa' : 'Edit Data
    Mahasiswa'}}</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item align-items-center">
        <a href="{{route('home')}}" class="text-decoration-none">Beranda</a>
      </li>
      <li class="breadcrumb-item align-items-center">
        <a href="{{route('student-management.index')}}" class="text-decoration-none">Mahasiswa</a>
      </li>
      <li class="breadcrumb-item align-items-center active">
        {{Route::is('student-management.create') ? 'Tambah Data Mahasiswa' : 'Edit
        Data Mahasiswa'}}
      </li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="main-content mt-3">
  <form class="form"
    action="{{Route::is('student-management.create')  ? route('student-management.store') : route('student-management.update', isset($student) ? $student->id : "")}}"
    method="POST" enctype="multipart/form-data">
    @if (Route::is('student-management.edit'))
    @method('PUT')
    @endif
    @csrf
    @include('form_views.user_form')
  </form>
</div>
@endsection