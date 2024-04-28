@extends('layouts.base')

@section('title', Request::segment(5) === 'create' ? 'Add Document' : 'Edit Document')

@section('custom_css_link', asset('Css/Form_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">{{Request::segment(5) === 'create' ? 'Add Document' : 'Edit
    Document'}}</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item align-items-center">
        <a href="{{route('home')}}" class="text-decoration-none">Home</a>
      </li>
      <li class="breadcrumb-item align-items-center">
        <a href="{{route('user-management.index')}}" class="text-decoration-none">User Management</a>
      </li>
      <li class="breadcrumb-item align-items-center">
        <a href="{{route('user-management.document-management.index', $user->id)}}"
          class="text-decoration-none">{{$user->name}} Document</a>
      </li>
      <li class="breadcrumb-item align-items-center active">
        {{Request::segment(5) === 'create' ? 'Add Document' : 'Edit
        Document'}}
      </li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="main-content mt-3">
  <form
    action="{{Request::segment(5) === 'create' ? route('user-management.document-management.store', $user->id) : route('user-management.document-management.update', [$user->id, Request::segment(5)])}}"
    method="POST" enctype="multipart/form-data">
    @if (Request::segment(6) === 'edit')
    @method('PUT')
    @endif
    @csrf
    @include('form_views.document_form')
  </form>
</div>
@endsection