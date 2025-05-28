@extends('layouts.base')

@section('title', 'Jenis Tugas Akhir')

@section('custom_css_link', asset('css/Data-Management_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">Jenis Tugas Akhir</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item">
        <a href="{{route('home')}}" class="text-decoration-none">Beranda</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">Jenis Tugas Akhir</li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="main-content">
  <div class="action-wrapper d-lg-flex mt-3 justify-content-between align-items-baseline">
    <div class="wrapper">
      <a href="#" class="btn btn-success">
        <div data-cy="btn-link-add-type" class="wrapper d-flex gap-2 align-items-center" id="add" data-bs-toggle="modal"
          data-bs-target="#addNewModal">
          <i class="ri-add-line"></i>
          <span class="fw-medium">Tambah Data</span>
        </div>
      </a>
    </div>
    <div class="wrapper mt-2 mt-lg-0">
      <div class="input-group">
        <input data-cy="input-type-name" type="text" class="form-control py-2 px-3 search-input border-0"
          placeholder="Telusuri" name="type" />
        <button type="submit" class="input-group-text btn btn-danger d-flex align-items-center fs-5 px-3"
          id="basic-addon2">
          <i class="ri-search-line"></i>
        </button>
      </div>
    </div>
  </div>
  <div class="table-wrapper mb-2 pb-5">
    <table id="type-table" class="table mt-3 table-hover" style="width: 100%">
      <thead>
        <tr>
          <th class="text-white fw-medium">No.</th>
          <th class="text-white fw-medium">Jenis Tugas Akhir</th>
          <th class="text-white fw-medium">Aksi</th>
        </tr>
      </thead>
      <tbody id="tableBody">
        @forelse ($types as $type)
        <tr>
          <td>{{$type->id}}</td>
          <td>{{$type->type}}</td>
          <td>
            <div class="d-flex gap-1">
              <div class="btn btn-danger btn-delete" data-bs-toggle="modal" data-bs-target="#deleteModal"
                data-type="{{$type->type}}" data-delete-link="{{route('thesis-type-management.destroy', $type->id)}}">
                Hapus</div>
              <div data-bs-toggle="modal" data-bs-target="#editModal"
                data-edit-link="{{route('thesis-type-management.update', $type->id)}}" data-type="{{$type->type}}"
                class="btn btn-warning btn-edit text-black">Edit</div>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="3" class="text-center">Data Jenis Tugas Akhir Tidak Ditemukan</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="addNewModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Tambah Jenis</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action={{route('thesis-type-management.store')}} class="form" id="addForm" method="POST">
          @csrf
          <div class="form-group mb-3">
            <label for="name" class="mb-1">Nama</label>
            <input value="" data-cy="input-type" required class="form-control" type="text" name="type" id="jenis"
              placeholder="Masukkan nama jenis" />
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button data-cy="btn-submit-store" type="submit"
          class="btn btn-submit btn-success text-white fw-bold">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Edit Jenis</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="form" id="editForm" method="POST">
          @csrf
          @method('PUT')
          <div class="form-group mb-3">
            <label for="name" class="mb-1">Nama</label>
            <input data-cy="input-type-edit" required class="form-control" type="text" name="type" id="type-edit"
              placeholder="Masukkan nama jenis" />
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button data-cy="btn-submit-update" type="submit"
          class="btn btn-warning btn-submit text-black fw-bold">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Hapus Jenis</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 class="text-center">Apakah anda yakin menghapus jenis <span class="type-name"></span> ?</h4>
      </div>
      <form action="" class="form" method="post" id="deleteForm">
        @method('delete')
        @csrf
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button data-cy="btn-delete-confirm" type="submit" id="deleteType"
            class="btn btn-submit btn-danger">Hapus</button>
      </form>
    </div>
  </div>
</div>
</div>

@endsection

@push('js')
<script>
  $(document).on('click', '.btn-edit', function (event){
          let type = $(this).data('type');
          let editLink = $(this).data('edit-link');
          $('#editmodal').modal('show');
          $('#type-edit').val(type);

          // get form action with vanilla js
          // document.getElementById('#addForm').action

          // get form action with jquery
          // $('#addForm').attr('action');

          // Set form action with vanilla js
          // document.getElementById('editForm').action = editLink;

          // Set form action with Jquery
          $('#editForm').attr('action', editLink);
      });
       
      $(document).on('click', '.btn-delete', function(event){
        let type = $(this).data('type');
        let deleteLink = $(this).data('delete-link');

        $('#deleteModal').modal('show');
        $('.type-name').html(type);

        $('#deleteForm').attr('action', deleteLink);
      });

      @if(count($types)>0)
      $('.search-input').keyup(function() {
          let table = $('#type-table').DataTable();
          table.search($(this).val()).draw();
      });

      $('#type-table').DataTable( {
      order: [[0, 'desc']]
      });        
      @endif
</script>

@endpush