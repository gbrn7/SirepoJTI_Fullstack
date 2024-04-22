@extends('layouts.base')

@section('title', 'Home')

@section('custom_css_link', asset('Css/Home_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item">
        <a href="{{route('home')}}" class="text-decoration-none">Home Search</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        Search Result
      </li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<form action="{{route('home')}}">
  <div class="col-lg-11 col-12">
    <div class="input-group">
      <input type="text" class="form-control py-2 px-3 search-input border-0" placeholder="Search"
        aria-label="Recipient's username" aria-describedby="basic-addon2" value="{{ request()->get('title')}}"
        name="title" list="titleListOption" />
      <datalist id="titleListOption" class="titleListOption">

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
                @php($idCategories = collect(request()->get('id_category')))
                @foreach ($categories as $category)
                <div class="checkbox-group d-flex gap-1">
                  <input type="checkbox" class="checkbox" name="id_category[]" value="{{$category->id}}"
                    @checked($idCategories->search($category->id) !== false ? true :false)>
                  <label class="fw-light filter-label text-truncate">{{$category->category}}</label>
                </div>
                @endforeach
              </div>
            </div>
            <div class="program-study-filter mt-2">
              <p class="mb-1 filter-title">Program Study</p>
              <div class="category-box d-flex flex-column gap-1">
                @php($idProdys = collect(request()->get('id_program_study')))
                @foreach ($prodys as $prody)
                <div class="checkbox-group d-flex gap-1">
                  <input type="checkbox" class="checkbox" name="id_program_study[]" value="{{$prody->id}}"
                    @checked($idProdys->search($prody->id) !== false ? true :false)/>
                  <label class="fw-light filter-label text-truncate">{{$prody->name}}</label>
                </div>
                @endforeach
              </div>
            </div>
            <div class="publication-filter mt-2">
              <p class="mb-1 filter-title">Publication Year</p>
              <div class="input-group p-1 shadow-none">
                <input type="number" min="0" placeholder="From" class="form-control year-input" name="publication_from"
                  value="{{request()->get('publication_from')}}" />
                <input type="number" min="0" placeholder="Until" class="form-control ms-2 year-input"
                  name="publication_until" value="{{request()->get('publication_until')}}" />
              </div>
            </div>
            <div class="author-filter mt-2">
              <p class="mb-1 filter-title">Author</p>
              <div class="input-group p-1 shadow-none">
                <input type="text" placeholder="Author" list="authorListOption"
                  class="form-control author-input year-input" name="author" value="{{ request()->get('author')}}" />
                <datalist id="authorListOption" class="authorListOption">
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
          <span class="fw-light">Showing page {{$thesis->currentPage() }} of about {{$thesis->lastPage()}} pages</span>
        </div>
        <div class="thesis-box mt-2 d-flex flex-column gap-2">
          @forelse ($thesis as $item)
          <div class="thesis-item">
            <a href="{{route('detail.document', $item->thesis_id)}}"
              class="thesis-title text-decoration-none mb-1 fw-semibold">
              {{$item->thesis_title}}
            </a>
            <a href="user-document.html" class="d-block text-decoration-none thesis-author mb-1">
              {{$item->user_name}} - {{$item->program_study_name}}
            </a>
            <p class="thesis-abstract mb-1">
              {{$item->thesis_abstract}}
            </p>
          </div>
          @empty
          <p class="text-center">Document Not Found</p>
          @endforelse

        </div>
        <div class="pagination-box d-flex justify-content-end">
          {{$thesis->links('pagination::bootstrap-4')}}
        </div>
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

  $('.author-input').on('input', debounce(function (e) {
    let authorinput = e.target.value;

    $.get("{{route('getSuggestionAuthor')}}", {
      title : authorinput
    },
      function (data, textStatus, jqXHR) {
        if (data.length !== 0) {
          $('#authorListOption').empty();
        }
        data.forEach(e => {
          $('#authorListOption').append($('<option>', {
            value: e.title
          }));
        }); 
      },
    );
  }, 300));
</script>
@endpush