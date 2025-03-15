@extends('layouts.base')

@section('title', 'Detail Document')

@section('custom_css_link', asset('css/Detail-Document_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">Detail Document</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item">
        <a href="{{route('home')}}" class="text-decoration-none">Home Search</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{$document->title}}
      </li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="main-content mt-3">
  <div class="header-content">
    <div class="thesis-title fw-semibold text-capitalize">
      {{$document->title}}
    </div>
    <div class="link-wrapper">
      <div class="wrapper orange mt-2">
        <span class="text-decoration-none">{{$document->student->last_name}},
          {{$document->student->first_name}}</span>
        - <span class="text-decoration-none">{{$document->student->programStudy->name}}</span>
      </div>
      <div class="wrapper orange mt-2">
        <span class="text-decoration-none">{{$document->topic->topic}}</span> |
        <span class="text-decoration-none" class=" year-link">
          {{date('Y',
          strtotime($document->updated_at))}}</span>
      </div>
    </div>
  </div>
  <div class="body-content mt-3">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#overview-tab-pane"
          type="button" role="tab" aria-controls="overview-tab-pane" aria-selected="true">
          Overview
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#pdf-tab-pane" type="button"
          role="tab" aria-controls="pdf-tab-pane" aria-selected="false">
          File PDF
        </button>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane overview-wrapper fade show active" id="overview-tab-pane" role="tabpanel"
        aria-labelledby="home-tab" tabindex="0">
        <div class="info-wrapper abstract-wrapper mt-2">
          <div class="title fw-medium">Abstract :</div>
          <div class="body fw-light">
            {{$document->abstract}}
          </div>
        </div>
        <div class="info-wrapper date-publication-wrapper">
          <div class="title fw-medium">Date Of publication :</div>
          <div class="body fw-light">{{$document->created_at->format('d F Y')}}</div>
        </div>
        <div class="info-wrapper author-wrapper">
          <div class="title fw-medium">Author :</div>
          <div class="body fw-light">{{$document->student->name}}</div>
        </div>
        <div class="info-wrapper prody-wrapper">
          <div class="title fw-medium">Program Study :</div>
          <div class="body fw-light">{{$document->student->programStudy->name}}</div>
        </div>
        <div class="info-wrapper majority-wrapper">
          <div class="title fw-medium">Majority :</div>
          <div class="body fw-light">{{$document->student->programStudy->majority->name}}</div>
        </div>
      </div>
      <div class="tab-pane fade" id="pdf-tab-pane" role="tabpanel" aria-labelledby="pdf-tab-pane" tabindex="0">
        @if(Auth::user() || Auth::guard('admin')->user())
        <table class="table table-light table-bordered">
          <thead>
            <tr class="table-light">
              <th class="table-light">No.</th>
              <th class="table-light">Dokumen</th>
              <th class="table-light">Keterangan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($document->files as $file)
            <tr class="table-light">
              <td class="table-light">{{$loop->iteration}}</td>
              <td class="table-light"> <a target="blank" href="{{route('detail.document.download', $file->file_name)}}"
                  class="text-decoration-none">{{$file->file_name}}</a>
              </td>
              <td class="table-light">
                <p class="mb-0">{{$file->label}}</p>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @else
        <div class="sign-in-download-wrapper d-flex align-items-center gap-2 mt-2">
          <a href="{{route('signIn.student')}}" class="mb-0 text-decoration-none d-flex align-items-center gap-1"><i
              class="ri-login-circle-line"></i>Sign
            In To Download</a>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection