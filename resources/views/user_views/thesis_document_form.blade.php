@extends('layouts.base')

@section('title', Request::segment(3) === 'create' ? 'Add Document' : 'Edit Document')

@section('custom_css_link', asset('css/Form_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">{{Request::segment(3) === 'create' ? 'Add Document' : 'Edit
    Document'}}</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item align-items-center">
        <a href="{{route('home')}}" class="text-decoration-none">Home</a>
      </li>
      <li class="breadcrumb-item align-items-center">
        <a href="{{route('thesis-submission.index')}}" class="text-decoration-none">Tugas Akhir</a>
      </li>
      <li class="breadcrumb-item align-items-center">
        <a href="#" class="text-decoration-none">{{Request::segment(3) === 'create' ? 'Add Document' : 'Edit
          Document'}}</a>
      </li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="main-content mt-3">
  <form
    action="{{Route::is('thesis-submission.create') ? route('thesis-submission.store') : route('thesis-submission.update', Request::segment(3))}}"
    method="POST" enctype="multipart/form-data">
    @if (Route::is('thesis-submission.edit', Request::segment(3)))
    @method('PUT')
    @endif
    @csrf
    @include('form_views.document_form')
  </form>
</div>
@endsection

@push('js')
<script>
  const dropArea = document.querySelector("#drop-area");
  const inputFile = document.querySelector("#input-file");
  const imageView = document.querySelector(".img-view");

  $('.input-file').change(function (e) { 
    e.preventDefault();
    const [file] = e.target.files;
    $(this).closest('.drop-area').find('.file-desc')[0].innerHTML = `${file.name}`;
    $(this).closest(".drop-area").addClass('active');
  });

  $('.drop-area').on('dragover', function (event) {
    event.preventDefault();
    $(this).addClass('active')
    $(this).find('.file-desc').textContent = "Release to upload file";
  });

  $('.drop-area').on('dragleave', function (event) {
    event.preventDefault()

    if($(this).find('.input-file')[0].files.length === 0){
      $(this).find('.file-desc').innerHTML = "Drag and drop or click here <br>to upload image";

      $(this).removeClass('active');
    }else{
      $(this).find('.file-desc').innerHTML = `${inputFile.files[0].name}`;
    }
  });

  $('.drop-area').on('drop', function(event) {
    event.preventDefault()
    
    $(this).find('.input-file')[0].files = event.originalEvent.dataTransfer.files;

    $(this).find('.file-desc')[0].innerHTML = $(this).find('.input-file')[0].files[0].name;
  });

$('.img-view').click(function (e) { 
  e.preventDefault();

  $(this).siblings('.input-file').click()
});
</script>
@endpush