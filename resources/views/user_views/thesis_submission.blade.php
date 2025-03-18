@extends('layouts.base')

@section('title', 'Tugas Akhir')

@section('custom_css_link', asset('css/User-Document_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">Tugas Akhir</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item align-items-center">
        <a href="{{route('home')}}" class="text-decoration-none">Home</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        Tugas Akhir
      </li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="detail-wrapper mt-3">
  <div class="btn-wrapper">
    <div @class(["btn", "btn-warning"=> isset($document), "btn-success"=> !isset($document)]) ><a
        href="{{isset($document) ? route('thesis-submission.edit', $document->id) : route('thesis-submission.create')}}"
        @class(['text-decoration-none', 'text-black'=>
        isset($document)])><i class="ri-pencil-line me-1"></i>
        <span>{{isset($document)? "Edit Data" : "Isi
          Data"}}</span></a></div>
  </div>
  <div class="detail-thesis-wrapper mt-3">
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Judul</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center">
          {{$document?->title
          ? $document->title : "-"}}</div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Abstrak</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center">
          {{$document?->abstract
          ? $document->abstract : "-"}}</div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Topik</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center">
          {{$document?->topic?->topic
          ? $document->topic->topic : "-"}}</div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Jenis Tugas Akhir</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center">
          {{$document?->type?->type
          ? $document->type->type : "-"}}</div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Dosen Pembimbing</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center">
          {{$document?->lecturer?->name
          ? $document->lecturer->name : "-"}}</div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Status Penyerahan</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center"><span
            @class([ 'badge' , 'text-black'=> !isset($document) ,'text-bg-secondary'=>
            isset($document) && !isset($document?->submission_status),'text-white text-bg-danger'=>
            isset($document?->submission_status) &&
            !$document?->submission_status, 'text-white text-bg-success'=>
            $document?->submission_status,
            ])>{{isset($document) ? isset($document?->submission_status) ? $document?->submission_status ? "Diterima":
            "Ditolak" :
            "Pending" : "-"}}</span></div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Catatan</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center">
          {{$document?->note
          ? $document?->note : "-"}}</div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Dokumen</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <table class="table bg-white table-bordered">
          <thead>
            <tr>
              <th>No.</th>
              <th>Dokumen</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            @if (isset($document?->files))
            @foreach ($document?->files as $file)
            <td>{{$loop->iteration}}</td>
            <td> <a target="blank" target="blank" href="{{route('detail.document.download', $file?->file_name)}}"
                class="text-decoration-none">{{$file?->file_name}}</a>
            </td>
            <td>
              <p class="mb-0">{{$file?->label}}</p>
            </td>
            </tr>
            @endforeach
            @else
            <td>-</td>
            <td>-</td>
            <td>-</td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
    <hr>
  </div>
</div>
@endsection