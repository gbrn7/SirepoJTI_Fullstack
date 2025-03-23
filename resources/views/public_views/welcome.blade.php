@extends('layouts.base')

@section('title', 'Welcome')

@section('custom_css_link', asset('css/Home_style/main.css'))

@section('main-content')
<form action="{{route('home')}}" class="form-search">
  <div class="row justify-content-center h-100">
    <div class="d-flex flex-column align-items-center main-content col-10 col-lg-8">
      <div class="logo-wrapper d-flex align-items-center justify-content-center gap-3">
        <img src="{{asset('img/jti_logo.png')}}" class="jti-logo" />
        <div class="text-wrapper gap-1">
          <p class="m-0 head-title">Sistem Informasi</p>
          <h1 class="fw-bold m-0 main-title">REPOSITORI TUGAS AKHIR JTI</h1>
        </div>
      </div>
      <div class="search-wrapper pb-2 mt-4 rounded rounded-3 w-100">
        <div class="input-group">
          <input type="text" class="form-control py-2 px-3 search-input border-0" placeholder="Telusuri" name="title"
            data-cy="input-search" />
          <button type="submit" class="input-group-text btn btn-danger d-flex align-items-center fs-5 px-3"
            id="basic-addon2" data-cy="btn-search-submit">
            <i class="ri-search-line"></i>
          </button>
        </div>
        <div class="suggestion-box mt-3 w-100">
        </div>
      </div>
      <div class="filter-wrapper mt-4 w-100 d-flex justify-content-lg-between flex-wrap">
        <a href="{{route('filter.year.view')}}"
          class="filter-box text-decoration-none col-6 col-md-4 col-lg-2 rounded-4 p-1 text-center"
          data-cy="filter-box-publication-year">
          <img src="{{asset('img/proicons_folder.png')}}" class="folder-logo" />
          <div class="folder-box-label">
            <p class="filter-text mb-1 mt-1">Tahun Publikasi</p>
          </div>
        </a>
        <a href="{{route('filter.program-study.view')}}"
          class="filter-box text-decoration-none col-6 col-md-4 col-lg-2 rounded-4 p-1 text-center"
          data-cy="filter-box-program-study">
          <img src="{{asset('img/proicons_folder.png')}}" class="folder-logo" />
          <div class="folder-box-label">
            <p class="filter-text mb-1 mt-1">Program Studi</p>
          </div>
        </a>
        <a href="{{route('filter.topic.view')}}" data-cy="filter-box-topic"
          class="filter-box text-decoration-none col-6 col-md-4 col-lg-2 rounded-4 p-1 text-center">
          <img src="{{asset('img/proicons_folder.png')}}" class="folder-logo" />
          <div class="folder-box-label">
            <p class="filter-text mb-1 mt-1">Topik</p>
          </div>
        </a>
        <a href="{{route('filter.author.view')}}" data-cy="filter-box-author"
          class="filter-box text-decoration-none col-6 col-md-4 col-lg-2 rounded-4 p-1 text-center">
          <img src="{{asset('img/proicons_folder.png')}}" class="folder-logo" />
          <div class="folder-box-label">
            <p class="filter-text mb-1 mt-1">Penulis</p>
          </div>
        </a>
        <a href="{{route('filter.thesis-type.view')}}" data-cy="filter-box-thesis-type"
          class="filter-box text-decoration-none col-6 col-md-4 col-lg-2 rounded-4 p-1 text-center">
          <img src="{{asset('img/proicons_folder.png')}}" class="folder-logo" />
          <div class="folder-box-label">
            <p class="filter-text mb-1 mt-1">Jenis Tugas Akhir</p>
          </div>
        </a>
      </div>
    </div>
  </div>
</form>
@endsection

@push('js')
<script>
  $("body").on("click", () => {
      $(".search-wrapper").removeClass("active");
    });

    $('.search-input').on('input', debounce(function (e) {
    let searchInput = e.target.value;

    if(searchInput == ''){
      $('.suggestion-box').empty();
      $('.search-wrapper').removeClass('active');
    }else{
      $.get("{{route('getSuggestionTitle')}}", {
      title : searchInput
    },
      function (data, textStatus, jqXHR) {
        if (data.length !== 0) {
          $('.suggestion-box').empty();
          $('.search-wrapper').addClass('active')
        }
        data.data.forEach(e => {
          $('.suggestion-box').append(`<div class="suggestion-item py-2 ps-3">${e.title}</div>`)
          });

          $(".suggestion-item").on("click", (e) => {
          $(".search-input").val(e.target.innerHTML);

          $(".form-search").submit();
        }); 
      },
    );
    }

  }, 300));
</script>
@endpush