@extends('layouts.base')

@section('title', 'Edit Profile')

@section('custom_css_link', asset('Css/Form_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">{{$user->name}} Profile</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item align-items-center">
        <a href="{{route('home')}}" class="text-decoration-none">Home</a>
      </li>
      <li class="breadcrumb-item align-items-center">
        <a href="#" class="text-decoration-none">Edit Profile</a>
      </li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="main-content mt-3">
  <form action="{{route('user.editProfile', $user->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-2">
      <label class="form-label">Username</label>
      <input type="text" class="form-control" placeholder="Enter the username"
        value="{{old('username', $user->username)}}" name="username" />
    </div>
    <div class="mb-2">
      <label for="formFile" class="form-label">Profile Picture</label>
      <input class="form-control" type="file" id="formFile" name="profile_picture" />
    </div>
    <div class="mb-2">
      <label class="form-label">Old Password</label>
      <input type="password" class="form-control" placeholder="Enter the password" name="old_password" />
    </div>
    <div class="mb-2">
      <label class="form-label">New Password</label>
      <input type="password" class="form-control" placeholder="Enter the password" name="new_password" />
    </div>
    <div class="mb-2">
      <label class="form-label">Repeat New Password</label>
      <input type="password" class="form-control" placeholder="Enter your new password again" name="confirm_password" />
    </div>
    <div class="wrapper d-flex justify-content-end">
      <button type="submit" class="btn btn-submit text-white px-5 btn-warning">Submit</button>
    </div>
  </form>
</div>
@endsection