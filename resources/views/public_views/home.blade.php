@extends('layouts.base')

@section('title', 'Home')

@section('custom_css_link', asset('css/Home_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item">
        <a href="{{route('home')}}" class="text-decoration-none">Beranda</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        Hasil Penelusuran
      </li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<form id="form-tag" action="{{route('home')}}" class="form-search">
  <div class="col-lg-11 col-12 position-relative">
    <div class="search-wrapper position-relative rounded rounded-3 w-100">
      <div class="input-group input-group-search position-relative">
        <input type="text" value="{{request()->get('title')}}" class="form-control py-2 px-3 search-input border-0"
          placeholder="Telusuri" name="title" />
        <button type="submit" class="input-group-text btn btn-danger btn-submit d-flex align-items-center fs-5 px-3"
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
            <div class="topic-filter mt-2">
              <p class="mb-1 filter-title">Topik</p>
              <div class="topic-box checkbox-list-box d-flex flex-column gap-1" data-cy="topic-checkbox-wrapper">
                @php($topicId = collect(request()->get('topic_id')))
                @foreach ($topics as $topic)
                <div class="checkbox-group d-flex gap-1">
                  <input type="checkbox" class="checkbox topic-input" name="topic_id[]" value="{{$topic->id}}"
                    @checked($topicId->search($topic->id) !== false ? true :false)>
                  <label class="fw-light filter-label text-truncate">{{$topic->topic}}</label>
                </div>
                @endforeach
              </div>
            </div>
            <div class="program-study-filter mt-2">
              <p class="mb-1 filter-title">Program Studi</p>
              <div class="prody-box checkbox-list-box d-flex flex-column gap-1" data-cy="prody-checkbox-wrapper">
                @php($idProdys = collect(request()->get('program_study_id')))
                @foreach ($prodys as $prody)
                <div class="checkbox-group d-flex gap-1">
                  <input type="checkbox" class="checkbox" name="program_study_id[]" value="{{$prody->id}}"
                    @checked($idProdys->search($prody->id) !== false ? true :false)/>
                  <label class="fw-light filter-label text-truncate">{{$prody->name}}</label>
                </div>
                @endforeach
              </div>
            </div>
            <div class="type-filter mt-2">
              <p class="mb-1 filter-title">Jenis Tugas Akhir</p>
              <div class="topic-box checkbox-list-box d-flex flex-column gap-1" data-cy="thesis-type-checkbox-wrapper">
                @php($typeId = collect(request()->get('type_id')))
                @foreach ($types as $type)
                <div class="checkbox-group d-flex gap-1">
                  <input type="checkbox" class="checkbox topic-input" name="type_id[]" value="{{$type->id}}"
                    @checked($typeId->search($type->id) !== false ? true :false)>
                  <label class="fw-light filter-label text-truncate">{{$type->type}}</label>
                </div>
                @endforeach
              </div>
            </div>
            <div class="publication-filter mt-2">
              <p class="mb-1 filter-title">Tahun Publikasi</p>
              <div class="input-group p-1 shadow-none">
                <input type="number" min="0" placeholder="Dari" data-cy="input-publication-from"
                  class="form-control year-input" name="publication_from"
                  value="{{request()->get('publication_from')}}" />
                <input type="number" min="0" placeholder="Sampai" data-cy="input-publication-until"
                  class="form-control ms-2 year-input" name="publication_until"
                  value="{{request()->get('publication_until')}}" />
              </div>
            </div>
            <div class="author-filter mt-2">
              <p class="mb-1 filter-title">Penulis</p>
              <div class="input-group p-1 shadow-none">
                <input type="text" placeholder="Telusuri Penulis" list="authorListOption"
                  class="form-control author-input year-input" data-cy="input-author" name="author"
                  value="{{ request()->get('author')}}" />
              </div>
            </div>
          </div>
          <div class="footer-filter d-flex justify-content-center mt-3 pt-1">
            <button type="submit" class="btn btn-submit btn-apply px-4 py-2 fw-medium" data-cy="btn-filter-submit">
              Terapkan
            </button>
          </div>
        </div>
      </div>
      <div class="col-lg-10 ps-lg-4 mt-3 mt-md-0 ps-md-3 thesis-list-box d-flex flex-column justify-content-between">
        <div class="thesis-list-content-up">
          <div class="pagination-nav mt-4 mt-lg-0">
            <span class="fw-light">Menampilkan halaman {{$documents->currentPage() }} dari {{$documents->lastPage()}}
              halaman</span>
          </div>

          <div class="thesis-box mt-2 d-flex flex-column gap-4">
            @forelse ($documents as $document)
            <div class="thesis-item">
              <div class="thesis-title-wrapper text-decoration-none mb-1">
                <span class="author document-label">{{$document->last_name.",
                  ".$document->first_name}} {{"(".date('Y',
                  strtotime($document->publication)).")"}}</span>
                <a href="{{route('detail.document', $document->thesis_id)}}" class="thesis-title">
                  {{$document->thesis_title}}.</a>
                <span class="document-label"> {{$document->thesis_type.", ".$document->program_study_name.", Politeknik
                  Negeri Malang"}}</span>
              </div>
              <p class="thesis-abstract mb-1 fw-light">
                {{$document->thesis_abstract}}
              </p>
            </div>
            @empty
            <div class="thesis-item w-100">
              <div class="empty-message text-decoration-none mb-1 fw-semibold" data-cy="empty-message">
                Dokumen Tidak Ditemukan
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