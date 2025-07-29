@extends('layouts.base')

@section('title', request()->routeIs('document-management.create') ? 'Tambah Dokumen' : 'Edit Dokumen')

@section('custom_css_link', asset('css/Form_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">{{request()->routeIs('document-management.create') ? 'Tambah Data Tugas Akhir' : 'Edit
    Data Tugas Akhir'}}
  </div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item">
        <a href="{{route('home')}}" class="text-decoration-none">Beranda</a>
      </li>
      <li class="breadcrumb-item" aria-current="page"><a href="{{route('document-management.index')}}"
          class="text-decoration-none">Tugas Akhir</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{request()->routeIs('document-management.create') ?
        'Tambah Data Tugas Akhir' : 'Edit Data Tugas Akhir'}}</li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="main-content mt-3">
  <form id="form-tag"
    action="{{Route::is('document-management.create') ? route('document-management.store') : route('document-management.update', [isset($thesis) ? $thesis->id : ''])}}"
    method="POST" class="no-interval-load" enctype="multipart/form-data">
    @if (Route::is('document-management.edit'))
    @method('PUT')
    @endif
    @csrf
    <div class="mb-2">
      <label class="form-label">NIM</label>
      <div class="input-group p-1 shadow-none">
        <input type="text" data-cy="input-username" class="form-control author-input" placeholder="Masukkan Nim"
          name="username" value="{{old('username', isset($thesis) ? $thesis->student->username : '')}}" />
      </div>
    </div>
    @include('form_views.document_form')
    <div class="wrapper d-flex justify-content-end">
      <button @class(['btn btn-submit text-black px-5 fw-bold', 'btn-success text-white'=>
        Route::is('document-management.create'), 'btn-warning text-black'=>
        Route::is('document-management.edit')])
        data-cy="btn-submit"
        type="submit">Submit
      </button>
    </div>
  </form>
</div>
@endsection

@push('js')
<script src="{{asset('js/drag_drop_handler.js')}}"></script>
@endpush