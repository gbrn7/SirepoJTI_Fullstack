@extends('layouts.base')

@section('title', Request::segment(5) === 'create' ? 'Add Document' : 'Edit Document')

@section('custom_css_link', asset('css/Form_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">{{Request::segment(3) === 'create' ? 'Add Document' : 'Edit
    Document'}}</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item">
        <a href="{{route('home')}}" class="text-decoration-none">Home</a>
      </li>
      <li class="breadcrumb-item" aria-current="page"><a href="{{route('documents-management.index')}}"
          class="text-decoration-none">Documents
          Management</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit Document</li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="main-content mt-3">
  <form
    action="{{Request::segment(3) === 'create' ? route('documents-management.store') : route('documents-management.update', [Request::segment(3)])}}"
    method="POST" enctype="multipart/form-data">
    @if (Request::segment(4) === 'edit')
    @method('PUT')
    @endif
    @csrf
    <div class="mb-2">
      <label class="form-label">Author Username</label>
      <div class="input-group p-1 shadow-none">
        <input type="text" list="authorListOption" class="form-control author-input" placeholder="Enter your username"
          name="username" value="{{old('username', isset($document) ? $document->user->username : '')}}" />
        <datalist id="authorListOption" class="authorListOption">
      </div>
    </div>
    @include('form_views.document_form')
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

    $('.author-input').on('input', debounce(function (e) {
    let authorinput = e.target.value;

    $.get("{{route('getSuggestionAuthorByUsername')}}", {
      username : authorinput
    },
      function (data, textStatus, jqXHR) {
        if (data.length !== 0) {
          $('#authorListOption').empty();
        }
        data.forEach(e => {
          $('#authorListOption').append($('<option>', {
            value: e.username
          }));
        }); 
      },
    );
  }, 300));

</script>
@endpush