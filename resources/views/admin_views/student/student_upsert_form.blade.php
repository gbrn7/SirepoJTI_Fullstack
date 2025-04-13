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
    <div class="mb-2">
      <label class="form-label">Username</label>
      <input type="text" data-cy="input-username" class="form-control" placeholder="Masukkan Username" name="username"
        {{Route::is('student-management.create') ? 'required' : '' }}
        value="{{old('username', isset($student) ? $student->username : '')}}" />
    </div>
    <div class="mb-2">
      <label class="form-label">Nama Depan</label>
      <input type="text" data-cy="input-first-name" class="form-control" placeholder="Masukkan Nama Depan"
        name="first_name" {{Route::is('student-management.create') ? 'required' : '' }}
        value="{{old('name', isset($student) ? $student->first_name : '')}}" />
    </div>
    <div class="mb-2">
      <label class="form-label">Nama Belakang</label>
      <input type="text" data-cy="input-last-name" class="form-control" placeholder="Masukkan Nama Belakang"
        name="last_name" {{Route::is('student-management.create') ? 'required' : '' }}
        value="{{old('name', isset($student) ? $student->last_name : '')}}" />
    </div>
    <div class="mb-2">
      <label class="form-label">Jenis Kelamin</label>
      <select name="gender" data-cy="select-gender" class="form-select">
        <option value="">Pilih Jenis Kelamin</option>
        <option value="Male" @selected(old('gender', isset($student) ? $student->gender : '') == 'Male')>Laki - Laki
        </option>
        <option value="Female" @selected(old('gender', isset($student) ? $student->gender : '') == 'Female')>Perempuan
        </option>
      </select>
    </div>
    <div class="mb-2">
      <label class="form-label">Tahun Angkatan</label>
      <input type="number" data-cy="input-class-year" class="form-control" placeholder="Masukkan Tahun Angkatan"
        name="class_year" value="{{old('class_year', isset($student) ? $student->class_year : '')}}" />
    </div>
    <div class="mb-2">
      <label class="form-label">Email</label>
      <input type="email" data-cy="input-email" class="form-control" placeholder="Masukkan Email" name="email"
        value="{{old('email', isset($student) ? $student->email : '')}}" />
    </div>
    <div class="mb-2">
      <label class="form-label">Password</label>
      <input type="password" data-cy="input-password" class="form-control" {{Route::is('student-management.create')
        ? 'required' : '' }} placeholder="Masukkan Password" name="password" />
    </div>
    <div class="mb-2">
      <label class="form-label">Program Studi</label>
      <select class="form-select" data-cy="select-program-study" name="program_study_id"
        {{Route::is('student-management.create') ? 'required' : '' }}>
        <option value="">Pilih Program Studi</option>
        @foreach ($prodys as $prody)
        <option value="{{$prody->id}}" @selected(old('program_study', isset($student) ? $student->program_study_id :
          '') ==$prody->id)>
          {{$prody->name}}
        </option>
        @endforeach
      </select>
    </div>
    <div class="mb-2">
      <label for="formFile" class="form-label">Gambar Profil</label>
      <input class="form-control" data-cy="input-profile-picture" type="file" id="formFile" name="profile_picture" />
    </div>
    <div class="wrapper d-flex justify-content-end">
      <button class="btn btn-submit text-black px-5 btn-warning fw-bold" type="submit"
        data-cy="btn-submit">Submit</button>
    </div>
  </form>
</div>
@endsection