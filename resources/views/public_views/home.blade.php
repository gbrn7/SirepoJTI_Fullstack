@extends('layouts.base')

@section('title', 'Home')

@section('custom_css_link', asset('Css/Home_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item">
        <a href="#" class="text-decoration-none">Home Search</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        Search Result
      </li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<form action="#" method="POST">
  @csrf
  <div class="col-lg-11 col-12">
    <div class="input-group">
      <input type="text" class="form-control py-2 px-3 search-input border-0" placeholder="Search"
        aria-label="Recipient's username" aria-describedby="basic-addon2" />
      <button type="submit" class="input-group-text btn btn-danger d-flex align-items-center fs-5 px-3"
        id="basic-addon2">
        <i class="ri-search-line"></i>
      </button>
    </div>
    <div class="content d-md-flex mt-4">
      <div class="col-lg-2 col-12 col-md-3">
        <div class="filter-wrapper filter-box p-3">
          <div class="header-filter d-flex align-items-center gap-1">
            <i class="ri-filter-line fs-5"></i>
            <span class="fw-medium mt-2">Filter</span>
          </div>
          <div class="body-filter overflow-hidden mt-1 w-100">
            <div class="category-filter">
              <p class="mb-1 filter-title">Category</p>
              <div class="category-box d-flex flex-column gap-1">
                <div class="checkbox-group d-flex gap-2">
                  <input type="checkbox" class="checkbox" name="" id="" />
                  <label class="fw-light filter-label text-truncate ms-4">Big Data</label>
                </div>
                <div class="checkbox-group d-flex gap-2">
                  <input type="checkbox" class="checkbox" name="" id="" />
                  <label class="fw-light filter-label text-truncate ms-4">UI UX</label>
                </div>
                <div class="checkbox-group d-flex gap-2">
                  <input type="checkbox" class="checkbox" name="" id="" />
                  <label class="fw-light filter-label text-truncate ms-4">Machine Learning</label>
                </div>
                <div class="checkbox-group d-flex gap-2">
                  <input type="checkbox" class="checkbox" name="" id="" />
                  <label class="fw-light filter-label text-truncate ms-4">IOT</label>
                </div>
                <div class="checkbox-group d-flex gap-2">
                  <input type="checkbox" class="checkbox" name="" id="" />
                  <label class="fw-light filter-label text-truncate ms-4">Data Visualization</label>
                </div>
              </div>
            </div>
            <div class="program-study-filter mt-2">
              <p class="mb-1 filter-title">Program Study</p>
              <div class="category-box d-flex flex-column gap-1">
                <div class="checkbox-group d-flex gap-2">
                  <input type="checkbox" class="checkbox" name="" id="" />
                  <label class="fw-light filter-label text-truncate ms-4">Teknik Informatika</label>
                </div>
                <div class="checkbox-group d-flex gap-2">
                  <input type="checkbox" class="checkbox" name="" id="" />
                  <label class="fw-light filter-label text-truncate ms-4">Sistem Informasi Bisnis</label>
                </div>
              </div>
            </div>
            <div class="publication-filter mt-2">
              <p class="mb-1 filter-title">Publication Year</p>
              <div class="input-group p-1 shadow-none">
                <input type="text" placeholder="From" class="form-control year-input" />
                <input type="text" placeholder="Until" class="form-control ms-2 year-input" />
              </div>
            </div>
            <div class="author-filter mt-2">
              <p class="mb-1 filter-title">Author</p>
              <div class="input-group p-1 shadow-none">
                <input type="text" placeholder="Author" class="form-control ms-2 year-input" />
              </div>
            </div>
          </div>
          <div class="footer-filter d-flex justify-content-center mt-3 pt-1">
            <button type="submit" class="btn btn-apply px-4 py-2 fw-medium">
              Apply Filter
            </button>
          </div>
        </div>
      </div>
      <div class="col-lg-10 ps-lg-4 mt-3 mt-md-0 ps-md-3 thesis-list-box">
        <div class="pagination-nav">
          <span class="fw-light">Showing page 2 of about 10 pages</span>
        </div>
        <div class="thesis-box mt-2 d-flex flex-column gap-2">
          <div class="thesis-item">
            <a href="detail-document.html" class="thesis-title text-decoration-none mb-1 fw-semibold">
              Big data for government policy: Potential implementations
              of bigdata for official statistics in Indonesia
            </a>
            <a href="user-document.html" class="d-block text-decoration-none thesis-author mb-1">
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
              Big data for government policy: Potential implementations
              of bigdata for official statistics in Indonesia
            </a>
            <a href="user-document.html" class="d-block text-decoration-none thesis-author mb-1">
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
              Big data for government policy: Potential implementations
              of bigdata for official statistics in Indonesia
            </a>
            <a href="user-document.html" class="d-block text-decoration-none thesis-author mb-1">
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
              Big data for government policy: Potential implementations
              of bigdata for official statistics in Indonesia
            </a>
            <a href="user-document.html" class="d-block text-decoration-none thesis-author mb-1">
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
              Big data for government policy: Potential implementations
              of bigdata for official statistics in Indonesia
            </a>
            <a href="user-document.html" class="d-block text-decoration-none thesis-author mb-1">
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
</form>
@endsection