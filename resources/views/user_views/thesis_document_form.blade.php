@extends('layouts.base')

@section('title', "Tambah Dokumen")

@section('custom_css_link', asset('css/Form_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">{{Route::is('thesis-submission.create') ? 'Tambah Data Tugas Akhir' : 'Edit Data Tugas
    Akhir'}}</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item align-items-center">
        <a href="{{route('home')}}" class="text-decoration-none">Home</a>
      </li>
      <li class="breadcrumb-item align-items-center">
        <a href="{{route('thesis-submission.index')}}" class="text-decoration-none">Tugas Akhir</a>
      </li>
      <li class="breadcrumb-item align-items-center active">
        {{Route::is('thesis-submission.create') ? 'Tambah Data Tugas Akhir
        '.auth()->user()->username : 'Edit Data Tugas Akhir '.auth()->user()->username}}
      </li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="main-content mt-3">
  <form id="form-tag"
    action="{{Route::is('thesis-submission.create') ? route('thesis-submission.store') : route('thesis-submission.update', Request::segment(3))}}"
    method="POST" enctype="multipart/form-data" class="no-interval-load form-store-data">
    @if (Route::is('thesis-submission.edit', Request::segment(3)))
    @method('PUT')
    @endif
    @csrf
    @include('form_views.document_form')
    <div class="wrapper d-flex justify-content-end">
      <div @class(['btn btn-submit text-black px-5 fw-bold', 'btn-success text-white'=>
        Route::is('thesis-submission.create'), 'btn-warning text-black'=>
        Route::is('thesis-submission.edit')])
        data-cy="btn-submit" data-bs-toggle="modal" data-bs-target="#confirmModal">Submit
      </div>
    </div>
  </form>
</div>


<!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Simpan Data Tugas Akhir</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        Apakah anda yakin untuk menyimpan data tugas akhir?<br>
        Data yang sudah disimpan tidak dapat anda ubah sampai admin menolak data tugas akhir
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" data-cy="btn-confirm-submit" class="btn btn-success btn-submit-store">Simpan</button>
      </div>
    </div>
  </div>
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

  $('.btn-submit-store').click(function (e) { 
    $('.form-store-data').submit();

    document.querySelector(".loading-wrapper").classList.remove('d-none');
  });

</script>
@endpush