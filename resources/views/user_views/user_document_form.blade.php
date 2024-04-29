@extends('layouts.base')

@section('title', Request::segment(3) === 'create' ? 'Add Document' : 'Edit Document')

@section('custom_css_link', asset('Css/Form_style/main.css'))

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
        <a href="{{route('my-document.index')}}" class="text-decoration-none">MY Document</a>
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
    action="{{Request::segment(3) === 'create' ? route('my-document.store') : route('my-document.update', Request::segment(3))}}"
    method="POST" enctype="multipart/form-data">
    @if (Request::segment(4) === 'edit')
    @method('PUT')
    @endif
    @csrf
    @include('form_views.document_form')
  </form>
</div>
@endsection