@extends('layouts.base')

@section('title', 'Topik Tugas Akhir')

@section('custom_css_link', asset('css/Data-Management_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">Topik Tugas Akhir</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item">
        <a href="{{route('home')}}" class="text-decoration-none">Beranda</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">Topik Tugas Akhir</li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="main-content">
  <div class="action-wrapper d-lg-flex mt-3 justify-content-between align-items-baseline">
    <div class="wrapper">
      <a href="#" class="btn btn-success">
        <div class="wrapper d-flex gap-2 align-items-center" id="add" data-bs-toggle="modal"
          data-bs-target="#addNewModal">
          <i class="ri-add-line"></i>
          <span class="fw-medium">Tambah Data</span>
        </div>
      </a>
    </div>
    <div class="wrapper mt-2 mt-lg-0">
      <div class="input-group">
        <input type="text" class="form-control py-2 px-3 search-input border-0" placeholder="Telusuri" name="topic" />
        <button type="submit" class="input-group-text btn btn-danger d-flex align-items-center fs-5 px-3"
          id="basic-addon2">
          <i class="ri-search-line"></i>
        </button>
      </div>
    </div>
  </div>
  <div class="table-wrapper mb-2 pb-5">
    <table id="topic-table" class="table mt-3 table-hover" style="width: 100%">
      <thead>
        <tr>
          <th class="text-white fw-medium">No.</th>
          <th class="text-white fw-medium">Nama Topik</th>
          <th class="text-white fw-medium">Aksi</th>
        </tr>
      </thead>
      <tbody id="tableBody">
        @forelse ($topics as $topic)
        <tr>
          <td>{{$topic->id}}</td>
          <td>{{$topic->topic}}</td>
          <td>
            <div class="d-flex gap-1">
              <div class="btn btn-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal"
                data-topic="{{$topic->topic}}" data-delete-link="{{route('thesis-topic.destroy', $topic->id)}}">
                Delete</div>
              <div data-bs-toggle="modal" data-bs-target="#editModal"
                data-edit-link="{{route('thesis-topic.update', $topic->id)}}" data-topic="{{$topic->topic}}"
                class="btn btn-warning edit-btn text-black">Edit</div>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="3" class="text-center">Document Not Found</td>
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
        <h5 class="modal-title" id="myModalLabel">Tambah Topik</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action={{route('thesis-topic.store')}} class="form" id="addForm" method="POST">
          @csrf
          <div class="form-group mb-3">
            <label for="name" class="mb-1">Nama</label>
            <input value="" required class="form-control" type="text" name="topic" id="topik"
              placeholder="Masukkan nama topik" />
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-submit btn-success">Submit</button>
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
        <h5 class="modal-title" id="myModalLabel">Edit Topik</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="form" id="editForm" method="POST">
          @csrf
          @method('PUT')
          <div class="form-group mb-3">
            <label for="name" class="mb-1">Nama</label>
            <input required class="form-control" type="text" name="topic" id="topic-edit"
              placeholder="Masukkan nama topik" />
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-warning btn-submit text-black">Submit</button>
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
        <h5 class="modal-title" id="myModalLabel">Hapus Topik</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 class="text-center">Apakah anda yakin menghapus topik<span class="topic-name"></span> ?</h4>
      </div>
      <form action="" class="form" method="post" id="deleteForm">
        @method('delete')
        @csrf
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" id="deleteTopic" class="btn btn-submit btn-danger">Hapus</button>
      </form>
    </div>
  </div>
</div>
</div>

@endsection

@push('js')
<script>
  $(document).on('click', '.edit-btn', function (event){
          let topic = $(this).data('topic');
          let editLink = $(this).data('edit-link');
          $('#editmodal').modal('show');
          $('#topic-edit').val(topic);

          // get form action with vanilla js
          // document.getElementById('#addForm').action

          // get form action with jquery
          // $('#addForm').attr('action');

          // Set form action with vanilla js
          // document.getElementById('editForm').action = editLink;

          // Set form action with Jquery
          $('#editForm').attr('action', editLink);
      });
       
      $(document).on('click', '.delete-btn', function(event){
        let topic = $(this).data('topic');
        let deleteLink = $(this).data('delete-link');

        $('#deleteModal').modal('show');
        $('.topic-name').html(topic);

        $('#deleteForm').attr('action', deleteLink);
      });

      @if(count($topics)>0)
      $('.search-input').keyup(function() {
          let table = $('#topic-table').DataTable();
          table.search($(this).val()).draw();
      });

      $('#topic-table').DataTable( {
      order: [[0, 'desc']]
      });        
      @endif
</script>

@endpush