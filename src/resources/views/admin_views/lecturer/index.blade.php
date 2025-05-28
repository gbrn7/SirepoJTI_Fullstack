@extends('layouts.base')

@section('title', 'Dosen')

@section('custom_css_link', asset('css/Data-Management_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">Dosen</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item">
        <a href="{{route('home')}}" class="text-decoration-none">Beranda</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">Dosen</li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="main-content">
  @php
  $params = collect(request()->all())->forget('page')->filter();
  $labels = collect([
  'name' => 'Nama',
  ]);
  @endphp
  <div class="action-wrapper d-lg-flex mt-3 justify-content-between align-items-end">
    <div class="wrapper d-flex gap-1">
      <a href="{{route('lecturer-management.create')}}" data-cy="btn-link-add-lecturer" class="btn btn-success">
        <div class="wrapper d-flex gap-2 align-items-center">
          <i class="ri-add-line"></i>
          <span class="fw-medium">Tambah Data</span>
        </div>
      </a>

      <div class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal" data-cy="btn-import-excel"
        data-bs-target="#importModal">
        <i class="ri-file-excel-2-line"></i><span>Impor Excel</span>
      </div>
    </div>
    <div class="wrapper mt-2 mt-lg-0">
      <form id="form-tag" action="{{route('lecturer-management.index')}}" method="get">
        <div class="input-group">
          <input type="text" data-cy="input-name" class="form-control py-2 px-3 search-input border-0"
            placeholder="Telusuri" name="name" />
          <button data-cy="btn-submit" type="submit"
            class="input-group-text btn btn-danger d-flex align-items-center fs-5 px-3" id="basic-addon2">
            <i class="ri-search-line"></i>
          </button>
        </div>
      </form>
    </div>
  </div>
  <div class="table-wrapper mb-2 mt-3 overflow-auto">
    @if ($params->count() > 0 )
    <div class="badge-wrapper mb-1 text-center text-md-start">
      @foreach ($params->toArray() as $key => $value)
      <span class="badge rounded-pill mt-1 text-bg-secondary py-2"><span class=" d-flex align-items-center gap-2">
          {{$labels->get($key)." : ".$value}}
          <a href="{{route('lecturer-management.index', $params->filter(function(string $item, string $key) use($value) {
          return $item != $value;
        }))}}" class="text-decoration-none text-white"><i class="ri-close-line"></i></a></span></span>
      @endforeach
    </div>
    @endif
    <table id="category-table" class="table table-hover" style="width: 100%">
      <thead>
        <tr>
          <th class="text-white fw-medium">No.</th>
          <th class="text-white fw-medium">Nama</th>
          <th class="text-white fw-medium">NIP</th>
          <th class="text-white fw-medium">Email</th>
          <th class="text-white fw-medium">Topik</th>
          <th class="text-white fw-medium">Aksi</th>
        </tr>
      </thead>
      <tbody id="tableBody">
        @forelse ($lecturers as $lecturer)
        <tr>
          <td>{{$lecturer->id}}</td>
          <td>{{$lecturer->name}}</td>
          <td>{{$lecturer->username}}</td>
          <td>{{$lecturer->email}}</td>
          <td>{{$lecturer->topic->topic}}</td>
          <td>
            <div class="d-flex gap-1">
              <div class="btn btn-danger btn-delete" data-cy="btn-delete" data-bs-toggle="modal"
                data-bs-target="#deleteModal" data-name="{{$lecturer->name}}"
                data-delete-link="{{route('lecturer-management.destroy', $lecturer->id)}}">
                Hapus</div>
              <a data-cy="btn-edit" href="{{route('lecturer-management.edit', $lecturer->id)}}"
                class="btn btn-edit btn-warning text-black">Edit</a>
              <a data-cy="btn-detail" href="{{route('lecturer-management.show', $lecturer->id)}}"
                class="btn btn-detail text-white">Detail</a>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center">Data Dosen Tidak Ditemukan</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="pagination-box d-flex justify-content-end">
    {{$lecturers->links('pagination::simple-bootstrap-5')}}
  </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Hapus Data Dosen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 class="text-center">Apakah anda yakin untuk menghapus data dosen dengan nama <span
            class="lecturer-name"></span>?
        </h4>
      </div>
      <form class="form" action="" method="post" id="deleteForm">
        @method('delete')
        @csrf
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" id="deletecriteria" data-cy="btn-delete-confirm"
            class="btn btn-danger btn-submit">Hapus</button>
      </form>
    </div>
  </div>
</div>
</div>

<!-- Import Lecturer Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <form id="form-tag" action="{{route('importLecturerExcelData')}}" class="form" method="POST"
      enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel">Impor Excel</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="template-wrapper mb-2">
            <label class="form-label">Unduh Template</label>
            <a data-cy="btn-download-template" href="{{route('getLecturerImportTemplate')}}"
              class="d-block">Template_Dosen.XLSX</a>
          </div>
          <div class="mb-2">
            <label class="form-label">Topik Spesialis</label>
            <select class="form-select" data-cy="select-import-topic" aria-label="Default select example"
              name="topic_id" required>
              <option value="">Pilih Topik Spesialis</option>
              @foreach ($topics as $topic)
              <option value="{{$topic->id}}">
                {{$topic->topic}}
              </option>
              @endforeach
            </select>
          </div>
          <div class="mb-2">
            <label class="form-label">Unggah Data</label>
            <input class="form-control" data-cy="input-upload-template" type="file" id="formFile" name="import_file"
              required />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" data-cy="btn-submit-template" class="btn btn-success fw-bold btn-submit">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection

@push('js')
<script>
  $(document).on('click', '.btn-delete', function(event){
        let name = $(this).data('name');
        let deleteLink = $(this).data('delete-link');

        $('#deleteModal').modal('show');
        $('.lecturer-name').html(name);

        $('#deleteForm').attr('action', deleteLink);
      });

  $('.author-input').on('input', debounce(function (e) {
    let authorinput = e.target.value;

    $.get("{{route('getSuggestionAuthor')}}", {
      name : authorinput
    },
      function (data, textStatus, jqXHR) {
        if (data.length !== 0) {
          $('#userListOption').empty();
        }
        data.forEach(e => {
          $('#userListOption').append($('<option>', {
            value: e.name
          }));
        }); 
      },
    );
  }, 300));
</script>
@endpush