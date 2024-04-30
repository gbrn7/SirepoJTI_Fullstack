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
<form action="{{route('home')}}" class="form-search">
  <div class="col-lg-11 col-12 position-relative">
    <div class="search-wrapper position-relative rounded rounded-3 w-100">
      <div class="input-group input-group-search position-relative">
        <input type="text" value="{{request()->get('title')}}" class="form-control py-2 px-3 search-input border-0"
          placeholder="Search" name="title" />
        <button type="submit" class="input-group-text btn btn-danger d-flex align-items-center fs-5 px-3"
          id="basic-addon2">
          <i class="ri-search-line"></i>
        </button>
      </div>
      <div class="suggestion-box bg-white pb-2 pt-3 rounded-bottom rounded-3 position-absolute w-100">
      </div>
    </div>
    <div class="content position-relative d-md-flex w-100 mt-3">
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
      <div class="col-lg-10 ps-lg-4 mt-3 mt-md-0 ps-md-3 thesis-list-box d-flex flex-column justify-content-between">
        <div class="thesis-list-content-up">
          <div class="pagination-nav mt-4 mt-lg-0">
            <span class="fw-light">Showing page {{$documents->currentPage() }} of about {{$documents->lastPage()}}
              pages</span>
          </div>
          <div class="thesis-box mt-2 d-flex flex-column gap-2">
            @forelse ($documents as $document)
            <div class="thesis-item">
              <a href="{{route('detail.document', $document->document_id)}}"
                class="thesis-title text-decoration-none mb-1 fw-semibold">
                {{$document->document_title}}
              </a>
              <p class="my-0 thesis-identity">{{$document->document_category}} - {{date('Y',
                strtotime($document->publication))}}</p>
              <a href="{{route('user.document', $document->user_id)}}"
                class="d-block text-decoration-none thesis-identity mb-1">
                {{$document->user_name}} - {{$document->program_study_name}}
              </a>
              <p class="thesis-abstract mb-1">
                {{$document->document_abstract}}
              </p>
            </div>
            @empty
            <div class="thesis-item w-100">
              <div class="thesis-title text-decoration-none mb-1 fw-semibold">
                Document Not Found
              </div>
            </div>
            @endforelse
          </div>
        </div>
        <div class="pagination-box d-flex justify-content-end">
          {{$documents->links('pagination::simple-bootstrap-5')}}
        </div>
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
    }else{
      $.get("{{route('getSuggestionTitle')}}", {
      title : searchInput
    },
      function (data, textStatus, jqXHR) {
        if (data.length !== 0) {
          $('.suggestion-box').empty();
          $('.search-wrapper').addClass('active')
        }
        data.forEach(e => {
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