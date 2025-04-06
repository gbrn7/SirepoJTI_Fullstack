@extends('layouts.base')

@section('title', 'Documents Management')

@section('custom_css_link', asset('css/Data-Management_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">Tugas Akhir</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item">
        <a href="{{route('home')}}" class="text-decoration-none">Beranda</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">Tugas Akhir</li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="main-content">
  <div class="wrapper mt-3">
    <a href="{{route('documents-management.create')}}" class="btn btn-success">
      <div class="wrapper d-flex gap-2 align-items-center">
        <i class="ri-add-line"></i>
        <span class="fw-semibold">Tambah Data</span>
      </div>
    </a>
  </div>
  <form class="mt-2">
    <div class="wrapper filter-wrapper d-flex flex-column flex-lg-row gap-1">
      <div class="input-wrapper col">
        <input type="text" class="form-control" name="title" value="{{request()->get('title')}}" placeholder="Judul">
      </div>
      <div class="input-wrapper col">
        <input type="text" class="form-control" name="student_username" placeholder="Username"
          value="{{request()->get('student_username')}}">
      </div>
      <div class="input-wrapper col">
        <input type="number" class="form-control" name="student_class_year"
          value="{{request()->get('student_class_year')}}" placeholder="Tahun Angkatan">
      </div>
      <div class="input-wrapper col">
        <select class="form-select" name="program_study_id">
          <option value="">Program Studi</option>
          @foreach ($prodys as $prody)
          <option value="{{$prody->id}}" @selected(request()->get('program_study_id') == $prody->id)>
            {{$prody->name}}
          </option>
          @endforeach
        </select>
      </div>
      <div class="input-wrapper col">
        <select class="form-select" name="submission_status">
          <option value="">Status Penyerahan</option>
          <option value="pending" @selected(request()->get('submission_status') == 'pending')>Pending</option>
          <option value="accepted" @selected(request()->get('submission_status') == 'accepted')>Diterima</option>
          <option value="declined" @selected(request()->get('submission_status') == 'declined')>Ditolak</option>
        </select>
      </div>
    </div>
    <div class="btn-action-wrapper d-flex flex-column flex-lg-row justify-content-end gap-2 mt-2">
      <button class="btn btn-warning fw-semibold col-12 col-lg-2 text-black"
        @disabled(collect(request()->all())->filter()->count() == 0)
        ><a href="{{route('documents-management.index')}}"
          class="text-decoration-none text-black">Bersihkan</a></button>
      <button type="submit" class="col-12 fw-semibold col-lg-2 btn btn-danger">
        Terapkan
      </button>
    </div>
  </form>
  <div class="table-wrapper pb-5 mt-3">
    <form id="bulk-action-form" method="POST">
      @csrf
      @method('PUT')
      <table id="dataTable" class="table table-jquery table-hover" style="width: 100%">
        <thead>
          <tr>
            <th><input type="checkbox" class="checkbox-parent"></th>
            <th class="text-white fw-medium">No.</th>
            <th class="text-white fw-medium">Judul</th>
            <th class="text-white fw-medium">Topik</th>
            <th class="text-white fw-medium">Penulis</th>
            <th class="text-white fw-medium">Prodi</th>
            <th class="text-white fw-medium">Username</th>
            <th class="text-white fw-medium">Status</th>
            <th class="text-white fw-medium">Aksi</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          @forelse ($documents as $document)
          <tr>
            <td><input id="checkbox-item" name="thesisIDs[]" type="checkbox" value="{{$document->thesis_id}}"></td>
            <td>{{$document->thesis_id}}</td>
            <td>{{$document->thesis_title}}</td>
            <td>{{$document->thesis_topic}}</td>
            <td>{{$document->last_name.', '.$document->first_name}}</td>
            <td>{{$document->program_study_name}}</td>
            <td>{{$document->username}}</td>
            <td>{{isset($document) ? isset($document?->submission_status) ? $document?->submission_status ? "Diterima":
              "Ditolak" :
              "Pending" : "-"}}</td>
            <td>
              <div class="wrapper d-flex gap-1">
                <div class="btn fw-medium btn-danger border-danger delete-btn" data-bs-toggle="modal"
                  data-bs-target="#deleteModal" data-title="{{$document->thesis_title}}"
                  data-delete-link="{{route('documents-management.destroy', $document->thesis_id)}}">
                  Hapus</div>
                <a href="{{route('documents-management.edit', $document->thesis_id)}}"
                  class="btn fw-medium text-black text-decoration-none btn-warning edit-btn">Edit</a>
                <a href="{{route('documents-management.show', $document->thesis_id)}}"
                  class="btn fw-medium edit-btn btn-detail text-decoration-none text-white">Detail</a>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="9" class="text-center">Dokumen Tidak Ditemukan</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </form>
  </div>
  <div class="bulk-action-button-wrapper gap-2 d-flex flex-column mt-2 flex-md-row justify-content-md-end">
    <button id="btn-accepted" disabled class="col-12 fw-semibold col-md-3 col-lg-2 btn btn-bulk-action btn-danger"
      data-update-link="{{route('documents-management.update-submission-status', ['submission_status' => 'declined'])}}">
      Tolak Tugas
    </button>
    <button id="btn-declined" disabled class="col-12 fw-semibold col-md-3 col-lg-2 btn btn-bulk-action btn-success"
      data-update-link="{{route('documents-management.update-submission-status', ['submission_status' => 'accepted'])}}">
      Terima Tugas
    </button>
  </div>
  <div class=" pagination-box d-flex justify-content-end mt-2">
    {{$documents->links('pagination::simple-bootstrap-5')}}
  </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Hapus Tugas akhir</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 class="text-center">Apakah anda yaking menghapus tugas akhir <span class="document-title"></span> ?</h4>
      </div>
      <form action="" method="post" id="deleteForm">
        @method('delete')
        @csrf
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" id="deletecriteria" class="btn btn-submit btn-danger">Hapus</button>
      </form>
    </div>
  </div>
</div>
</div>
@endsection

@push('js')
<script src="{{asset('js/jquery.simple-checkbox-table.min.js')}}"></script>

<script>
  $(document).on('click', '.delete-btn', function(event){
        let title = $(this).data('title');
        let deleteLink = $(this).data('delete-link');

        $('#deleteModal').modal('show');
        $('.document-title').html(title);

        $('#deleteForm').attr('action', deleteLink);
      });

    $(".btn-bulk-action").click(function(){
      document.querySelector("html").style.cursor = "wait";
      document.querySelector(".loading-wrapper").classList.remove('d-none');
      
      let updateLink = $(this).data('update-link');

      $('#bulk-action-form').attr('action', updateLink).submit();
    });

    $(".table-jquery").simpleCheckboxTable({
      
      onCheckedStateChanged: function(checkbox) {
        let checkedCount = $('#checkbox-item:checked').length;
        
        if(checkedCount > 0){
          $('.btn-bulk-action').prop('disabled', false);
        }else{
          $('.btn-bulk-action').prop('disabled', true);
        }
      }
      
    });
</script>
@endpush