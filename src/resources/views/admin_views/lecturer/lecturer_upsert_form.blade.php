@extends('layouts.base')

@section('title', Route::is('lecturer-management.create') ? 'Tambah Data Dosen' : 'Edit Data Dosen')

@section('custom_css_link', asset('css/Form_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">{{Route::is('lecturer-management.create') ? 'Tambah Data Dosen' : 'Edit Data
    Dosen'}}</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item align-items-center">
        <a href="{{route('home')}}" class="text-decoration-none">Beranda</a>
      </li>
      <li class="breadcrumb-item align-items-center">
        <a href="{{route('lecturer-management.index')}}" class="text-decoration-none">Dosen</a>
      </li>
      <li class="breadcrumb-item align-items-center active">
        {{Route::is('lecturer-management.create') ? 'Tambah Data Dosen' : 'Edit
        Data Dosen'}}
      </li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="main-content mt-3">
  <form class="form"
    action="{{Route::is('lecturer-management.create')  ? route('lecturer-management.store') : route('lecturer-management.update', isset($lecturer) ? $lecturer->id : "")}}"
    method="POST" enctype="multipart/form-data">
    @if (Route::is('lecturer-management.edit'))
    @method('PUT')
    @endif
    @csrf
    <div class="mb-2">
      <label class="form-label">Username</label>
      <input type="text" data-cy="input-username" class="form-control" placeholder="Masukkan Username" name="username"
        {{Route::is('lecturer-management.create') ? 'required' : '' }}
        value="{{old('username', isset($lecturer) ? $lecturer->username : '')}}" />
    </div>
    <div class="mb-2">
      <label class="form-label">Nama</label>
      <input type="text" class="form-control" data-cy="input-name" placeholder="Masukkan Nama" name="name"
        {{Route::is('lecturer-management.create') ? 'required' : '' }}
        value="{{old('name', isset($lecturer) ? $lecturer->name : '')}}" />
    </div>
    <div class="mb-2">
      <label class="form-label">Topik Spesialis</label>
      <select class="form-select" data-cy="select-topic" name="topic_id" {{Route::is('lecturer-management.create')
        ? 'required' : '' }}>
        <option value="">Pilih Topik Spesialis</option>
        @foreach ($topics as $topic)
        <option value="{{$topic->id}}" @selected(old('topic_id', isset($lecturer) ? $lecturer->topic_id :
          '') ==$topic->id)>
          {{$topic->topic}}
        </option>
        @endforeach
      </select>
    </div>
    <div class="mb-2">
      <label class="form-label">Email</label>
      <input type="email" class="form-control" data-cy="input-email" placeholder="Masukkan Email" name="email"
        value="{{old('email', isset($lecturer) ? $lecturer->email : '')}}" />
    </div>
    <div class="mb-2">
      <label class="form-label">Password</label>
      <input type="password" class="form-control" data-cy="input-password" {{Route::is('lecturer-management.create')
        ? 'required' : '' }} placeholder="Masukkan Password" name="password" />
    </div>
    <div class="mb-2">
      <label for="formFile" class="form-label">Gambar Profil</label>
      <input class="form-control" type="file" id="formFile" data-cy="input-profile-picture" name="profile_picture" />
    </div>
    <div class="wrapper d-flex justify-content-end">
      <button data-cy="btn-submit" class="btn btn-submit text-black px-5 btn-warning fw-bold"
        type="submit">Submit</button>
    </div>
  </form>
</div>
@endsection