@extends('layouts.base')

@section('title', 'Detail Document')

@section('custom_css_link', asset('css/Detail-Document_style/main.css'))

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
      <li class="breadcrumb-item active" aria-current="page">Detail Document</li>
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
      <div class="wrapper orange">
        <a href="{{route('home', ['id_category' => [$document->category->id]])}}"
          class="thesis-identity category-link text-decoration-none">{{$document->category->category}}</a> -
        <a class="text-decoration-none thesis-identity" href="{{route('home', ['publication_from' => date('Y',
        strtotime($document->created_at)), 'publication_until' => date('Y',
        strtotime($document->updated_at))] )}}" class="thesis-identity year-link">
          {{date('Y',
          strtotime($document->updated_at))}}</a>
      </div>
      <div class="wrapper orange">
        <a href="{{route('user.document', $document->id_user)}}"
          class="text-decoration-none thesis-identity">{{$document->user->name}}</a>
        - <a href="{{route('home', ['id_program_study' => [$document->user->programStudy->id]])}}"
          class="thesis-identity text-decoration-none">{{$document->user->programStudy->name}}</a>
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
          <div class="body fw-light">{{$document->user->name}}</div>
        </div>
        <div class="info-wrapper prody-wrapper">
          <div class="title fw-medium">Program Study :</div>
          <div class="body fw-light">{{$document->user->programStudy->name}}</div>
        </div>
        <div class="info-wrapper majority-wrapper">
          <div class="title fw-medium">Majority :</div>
          <div class="body fw-light">{{$document->user->programStudy->majority->name}}</div>
        </div>
      </div>
      <div class="tab-pane fade" id="pdf-tab-pane" role="tabpanel" aria-labelledby="pdf-tab-pane" tabindex="0">
        <div class="pdf-wrapper d-flex align-items-center gap-2 mt-2">
          @if(Auth::user() || Auth::guard('admin')->user())
          <p class="mb-0">{{$document->title}}</p>
          <a target="blank" href="{{route('detail.document.download', $document->file_name)}}"
            class="text-decoration-none">
            <i class="ri-file-download-line fs-5 text-danger"></i>
          </a>
          @else
          <a href="{{route('signIn.user')}}" class="mb-0 text-decoration-none d-flex align-items-center gap-1"><i
              class="ri-login-circle-line"></i>Sign
            In To Download</a>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection