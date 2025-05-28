@extends('layouts.base')

@section('title', 'Edit Profile')

@section('custom_css_link', asset('css/Form_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">Edit Profil</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item align-items-center">
        <a href="{{route('home')}}" class="text-decoration-none">Beranda</a>
      </li>
      <li class="breadcrumb-item align-items-center">
        <a href="#" class="text-decoration-none">Edit Profil</a>
      </li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="main-content mt-3">
  <form id="form-tag" action="{{route('user.editProfile', $user->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-2">
      <label for="formFile" class="form-label">Gambar Profil</label>
      <input data-cy="input-profile-picture" class="form-control" type="file" id="formFile" name="profile_picture" />
    </div>
    <div class="mb-2">
      <label class="form-label">Password Lama</label>
      <input type="password" class="form-control" data-cy="input-old-password" placeholder="Enter the password"
        name="old_password" />
    </div>
    <div class="mb-2">
      <label class="form-label">Password Baru</label>
      <input type="password" class="form-control" data-cy="input-new-password" placeholder="Enter the password"
        name="new_password" />
    </div>
    <div class="mb-2">
      <label class="form-label">Ulangi Password Baru</label>
      <input type="password" class="form-control" data-cy="input-confirm-new-password"
        placeholder="Enter your new password again" name="confirm_password" />
    </div>
    <div class="wrapper d-flex justify-content-end">
      <button type="submit" class="btn btn-submit fw-bold text-black px-5 btn-warning"
        data-cy="btn-edit-profile-submit">Submit</button>
    </div>
  </form>
</div>
@endsection