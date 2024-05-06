@extends('layouts.base')

@section('title', 'Edit Profile')

@section('custom_css_link', asset('css/Form_style/main.css'))

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
      <label class="form-label">Profile Picture</label>
      <label class="w-100 drop-area" id="drop-area">
        <input type="file" name="profile_picture" hidden accept="image/*" id="input-file">
        <div class="img-view w-100 h-100 rounded rounded-2 d-flex justify-content-center align-items-center">
          <div class="default-view">
            <i class="ri-upload-cloud-2-fill upload-icon"></i>
            <p class="file-desc mb-0">Drag and drop or click here <br>to upload image</p>
          </div>
        </div>
      </label>
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

@push('js')
<script>
  const dropArea = document.querySelector("#drop-area");
  const inputFile = document.querySelector("#input-file");
  const imageView = document.querySelector(".img-view");

      inputFile.addEventListener('change', (e) => {
        const [file] = e.target.files;
        document.querySelector(".file-desc").innerHTML = `${file.name}`;
        dropArea.classList.add('active');

      });

      dropArea.addEventListener('dragover', function (e) {
        e.preventDefault();
        dropArea.classList.add('active');
        document.querySelector(".file-desc").textContent = "Release to upload file";
      })

      dropArea.addEventListener("dragleave", ()=>{
        if(inputFile.files.length === 0){
          document.querySelector(".file-desc").innerHTML = "Drag and drop or click here <br>to upload image";
          dropArea.classList.remove('active');
      }else{
        document.querySelector(".file-desc").innerHTML = `${inputFile.files[0].name}`;
      }
    });

      dropArea.addEventListener('drop', function (e) {
        e.preventDefault();
        inputFile.files = e.dataTransfer.files;
        document.querySelector(".file-desc").innerHTML = `${inputFile.files[0].name}`;
      })

</script>
@endpush