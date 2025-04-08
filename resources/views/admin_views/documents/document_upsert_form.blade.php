@extends('layouts.base')

@section('title', request()->routeIs('documents-management.create') ? 'Tambah Dokumen' : 'Edit Dokumen')

@section('custom_css_link', asset('css/Form_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">{{request()->routeIs('documents-management.create') ? 'Tambah Dokumen' : 'Edit Dokumen'}}
  </div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item">
        <a href="{{route('home')}}" class="text-decoration-none">Beranda</a>
      </li>
      <li class="breadcrumb-item" aria-current="page"><a href="{{route('documents-management.index')}}"
          class="text-decoration-none">Tugas Akhir</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{request()->routeIs('documents-management.create') ?
        'Tambah Dokumen' : 'Edit Dokumen'}}</li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="main-content mt-3">
  <form
    action="{{Route::is('documents-management.create') ? route('documents-management.store') : route('documents-management.update', [isset($thesis) ? $thesis->id : ''])}}"
    method="POST" enctype="multipart/form-data">
    @if (Route::is('documents-management.edit'))
    @method('PUT')
    @endif
    @csrf
    <div class="mb-2">
      <label class="form-label">Username</label>
      <div class="input-group p-1 shadow-none">
        <input type="text" list="authorListOption" class="form-control author-input" placeholder="Masukkan Username"
          name="username" value="{{old('username', isset($thesis) ? $thesis->student->username : '')}}" />
      </div>
    </div>
    @include('form_views.document_form')
  </form>
</div>
@endsection

@push('js')
<script src="{{asset('js/drag_drop_handler.js')}}"></script>
@endpush