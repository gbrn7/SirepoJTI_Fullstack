@extends('layouts.base')

@section('title', 'My Document')

@section('custom_css_link', asset('Css/User-Document_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">My Document</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item align-items-center">
        <a href="#" class="text-decoration-none">Home</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        My Document
      </li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="user-document-content">
  <div class="identity-wrapper d-flex mt-3 gap-4 align-items-center">
    <div class="col-md-2 col-3">
      <img src="{{asset('img/profil-img.jpg')}}" class="img-avatar img-fluid" />
    </div>
    <div class="identity-box">
      <p class="author fw-semibold ls-b mb-1">Ade Susilo</p>
      <div class="departement-identity">
        <p class="prody mb-0 ls-s">Sistem Informasi Bisnis</p>
        <p class="departement ls-s">Teknologi Informasi</p>
      </div>
    </div>
  </div>
  <div class="list-thesis-wrapper mt-4">
    <div class="action-wrapper d-lg-flex justify-content-between align-items-baseline">
      <div class="wrapper">
        <a href="user-create-document.html" class="btn btn-success">
          <div class="wrapper d-flex gap-2 align-items-center">
            <i class="ri-add-line"></i>
            <span class="fw-medium">Add Document</span>
          </div>
        </a>
      </div>
      <div class="wrappper mt-2 mt-lg-0">
        <div class="input-group">
          <input type="text" class="form-control py-2 px-3 search-input border-0" placeholder="Search"
            aria-label="Recipient's username" aria-describedby="basic-addon2" />
          <button type="submit" class="input-group-text btn btn-danger d-flex align-items-center fs-5 px-3"
            id="basic-addon2">
            <i class="ri-search-line"></i>
          </button>
        </div>
      </div>
    </div>
    <div class="thesis-list-box">
      <div class="pagination-nav mt-3 mb-1">
        <span class="fw-light">Showing page 2 of about 3 pages</span>
      </div>
      <div class="thesis-box d-flex flex-column gap-2">
        <div class="thesis-item">
          <a href="user-detail-document.html" class="thesis-title text-decoration-none mb-1 fw-semibold">
            Big data for government policy: Potential implementations of
            bigdata for official statistics in Indonesia
          </a>
          <a href="user-document.html" class="thesis-author mb-1 text-decoration-none d-block">
            Ade Susilo - Sistem Informasi Bisnis
          </a>
          <p class="thesis-abstract mb-1">
            Big Data is an umbrella term for explosion in the quantity
            and diversity of high frequency digital data and it is not
            usually coming from traditional sources. The speed and
            frequency by which data is produced and collected - by an
            increasing number of sources - is responsible for today's
            data deluge: ...
          </p>
        </div>
        <div class="thesis-item">
          <a href="#" class="thesis-title text-decoration-none mb-1 fw-semibold">
            Big data for government policy: Potential implementations of
            bigdata for official statistics in Indonesia
          </a>
          <a href="detail-document.html" class="thesis-author mb-1 text-decoration-none d-block">
            Gadhis Pramestya A - Sistem Informasi Bisnis
          </a>
          <p class="thesis-abstract mb-1">
            Big Data is an umbrella term for explosion in the quantity
            and diversity of high frequency digital data and it is not
            usually coming from traditional sources. The speed and
            frequency by which data is produced and collected - by an
            increasing number of sources - is responsible for today's
            data deluge: ...
          </p>
        </div>
        <div class="thesis-item">
          <a href="#" class="thesis-title text-decoration-none mb-1 fw-semibold">
            Big data for government policy: Potential implementations of
            bigdata for official statistics in Indonesia
          </a>
          <a href="detail-document.html" class="thesis-author mb-1 text-decoration-none d-block">
            Gadhis Pramestya A - Sistem Informasi Bisnis
          </a>
          <p class="thesis-abstract mb-1">
            Big Data is an umbrella term for explosion in the quantity
            and diversity of high frequency digital data and it is not
            usually coming from traditional sources. The speed and
            frequency by which data is produced and collected - by an
            increasing number of sources - is responsible for today's
            data deluge: ...
          </p>
        </div>
        <div class="thesis-item">
          <a href="#" class="thesis-title text-decoration-none mb-1 fw-semibold">
            Big data for government policy: Potential implementations of
            bigdata for official statistics in Indonesia
          </a>
          <a href="detail-document.html" class="thesis-author mb-1 text-decoration-none d-block">
            Gadhis Pramestya A - Sistem Informasi Bisnis
          </a>
          <p class="thesis-abstract mb-1">
            Big Data is an umbrella term for explosion in the quantity
            and diversity of high frequency digital data and it is not
            usually coming from traditional sources. The speed and
            frequency by which data is produced and collected - by an
            increasing number of sources - is responsible for today's
            data deluge: ...
          </p>
        </div>
        <div class="thesis-item">
          <a href="#" class="thesis-title text-decoration-none mb-1 fw-semibold">
            Big data for government policy: Potential implementations of
            bigdata for official statistics in Indonesia
          </a>
          <a href="detail-document.html" class="thesis-author mb-1 text-decoration-none d-block">
            Gadhis Pramestya A - Sistem Informasi Bisnis
          </a>
          <p class="thesis-abstract mb-1">
            Big Data is an umbrella term for explosion in the quantity
            and diversity of high frequency digital data and it is not
            usually coming from traditional sources. The speed and
            frequency by which data is produced and collected - by an
            increasing number of sources - is responsible for today's
            data deluge: ...
          </p>
        </div>
      </div>
      <div class="pagination-box">
        <nav aria-label="..." class="mt-3">
          <ul class="pagination justify-content-end">
            <li class="page-item disabled">
              <a class="page-link">Previous</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="#">1</a>
            </li>
            <li class="page-item active" aria-current="page">
              <a class="page-link" href="#">2</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="#">3</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="#">Next</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>
@endsection