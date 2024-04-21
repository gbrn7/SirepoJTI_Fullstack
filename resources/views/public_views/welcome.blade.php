@extends('layouts.base')

@section('title', 'Welcome')

@section('custom_css_link', asset('Css/Home_style/main.css'))

@section('main-content')
<form action="{{route('home')}}">
  <div class="row justify-content-center h-100">
    <div class="d-flex flex-column align-items-center main-content col-10 col-lg-8">
      <div class="logo-wrapper d-flex align-items-center justify-content-center gap-3">
        <img src="{{asset('img/jti_logo.png')}}" class="jti-logo" />
        <div class="text-wrapper gap-1">
          <p class="m-0 head-title">Sistem Informasi</p>
          <h1 class="fw-bold m-0 main-title">REPOSITORI SKRIPSI JTI</h1>
        </div>
      </div>
      <div class="input-group mt-4">
        <input type="text" class="form-control py-2 px-3 search-input border-0" placeholder="Search"
          aria-label="Recipient's username" list="titleListOption" aria-describedby="basic-addon2" name="title" />
        <datalist id="titleListOption" class="titleListOption">

        </datalist>
        <button type="submit" class="input-group-text btn btn-danger d-flex align-items-center fs-5 px-3"
          id="basic-addon2">
          <i class="ri-search-line"></i>
        </button>
      </div>
    </div>
  </div>
</form>
@endsection

@push('js')
<script>
  let debounce = function (func, wait, immediate) {
     let timeout;
     return function() {
         let context = this, args = arguments;
         let later = function() {
                 timeout = null;
                 if (!immediate) func.apply(context, args);
         };
         let callNow = immediate && !timeout;
         clearTimeout(timeout);
         timeout = setTimeout(later, wait);
         if (callNow) func.apply(context, args);
     };
};

  $('.search-input').on('input', debounce(function (e) {
    let searchInput = e.target.value;

    $.get("{{route('getSuggestionTitle')}}", {
      title : searchInput
    },
      function (data, textStatus, jqXHR) {
        if (data.length !== 0) {
          $('#titleListOption').empty();
        }
        data.forEach(e => {
          $('#titleListOption').append($('<option>', {
            value: e.title
          }));
        }); 
      },
    );
  }, 300));
</script>
@endpush