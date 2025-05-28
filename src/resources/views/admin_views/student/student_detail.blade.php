@extends('layouts.base')

@section('title', 'Detail Data Mahasiswa')

@section('custom_css_link', asset('css/User-Document_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">Detail Data Mahasiswa</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item align-items-center">
        <a href="{{route('home')}}" class="text-decoration-none">Beranda</a>
      </li>
      <li class="breadcrumb-item align-items-center">
        <a href="{{route('student-management.index')}}" class="text-decoration-none">Beranda</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        Detail Data Mahasiswa
      </li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="detail-wrapper mt-3">
  <div class="detail-thesis-wrapper mt-3">
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">NIM</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center">
          {{$student->username}}</div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Nama Depan</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center">
          {{$student->first_name}}</div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Nama Belakang</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center">
          {{$student->last_name}}</div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Jenis Kelamin</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center">
          {{$student->gender == "Male" ? "Laki - Laki" : "Perempuan" }}
        </div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Tahun Angkatan</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center">
          {{$student->class_year}}</div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Email</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center">
          {{$student->email}}</div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Jurusan</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center">
          {{$student->programStudy->majority->name}}</div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Program Studi</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center">
          {{$student->programStudy->name}}</div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Status Tugas Akhir</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center">
          @if (!$student->thesis)
          {{'Belum Dikumpulkan'}}
          @elseif (!isset($student->thesis->submission_status))
          {{'Pending'}}
          @else
          {{$student->thesis->submission_status ? "Diterima": "Ditolak"}}
          @endif
        </div>
      </div>
    </div>
    <hr>
  </div>
</div>
@endsection