@extends('layouts.base')

@section('title', 'Mahasiswa')

@section('custom_css_link', asset('css/Data-Management_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">Mahasiswa</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item">
        <a href="{{route('home')}}" class="text-decoration-none">Beranda</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">Mahasiswa</li>
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
  'username' => 'Username',
  'class_year' => 'Tahun Angkatan',
  'program_study_id' => 'Program Studi',
  'submission_status' => 'Status Penyerahan',
  ]);
  @endphp
  <div class="action-wrapper mt-3 justify-content-between align-items-end">
    <div class="wrapper d-flex gap-1">
      <a href="{{route('student-management.create')}}" class="btn btn-success">
        <div class="wrapper d-flex gap-2 align-items-center">
          <i class="ri-add-line"></i>
          <span class="fw-medium">Tambah Data</span>
        </div>
      </a>

      <div class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#importModal">
        <i class="ri-file-excel-2-line"></i><span>Impor Excel</span>
      </div>
    </div>
    <form method="GET" action="{{route('student-management.index')}}" class="mt-2">
      <div class="wrapper filter-wrapper d-flex flex-column flex-lg-row gap-1">
        <div class="input-wrapper col">
          <input type="text" class="form-control" name="name" value="{{request()->get('name')}}" placeholder="Nama">
        </div>
        <div class="input-wrapper col">
          <input type="text" class="form-control" name="username" placeholder="Username"
            value="{{request()->get('username')}}">
        </div>
        <div class="input-wrapper col">
          <input type="number" class="form-control" name="class_year" value="{{request()->get('class_year')}}"
            placeholder="Tahun Angkatan">
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
            <option value={{App\Support\Enums\SubmissionStatusEnum::PENDING->value}}
              @selected(request()->get('submission_status') ==
              App\Support\Enums\SubmissionStatusEnum::PENDING->value)>Pending</option>
            <option value={{App\Support\Enums\SubmissionStatusEnum::ACCEPTED->value}}
              @selected(request()->get('submission_status') ==
              App\Support\Enums\SubmissionStatusEnum::ACCEPTED->value)>Diterima</option>
            <option value={{App\Support\Enums\SubmissionStatusEnum::DECLINED->value}}
              @selected(request()->get('submission_status') ==
              App\Support\Enums\SubmissionStatusEnum::DECLINED->value)>Ditolak</option>
            <option value="{{App\Support\Enums\SubmissionStatusEnum::UNSUBMITED->value}}" @selected(request()->
              get('submission_status') ==
              App\Support\Enums\SubmissionStatusEnum::UNSUBMITED->value)>Belum Dikumpulkan</option>
          </select>
        </div>
      </div>
      <div class="btn-action-wrapper d-flex flex-column flex-lg-row justify-content-end gap-2 mt-2">
        <button class="btn btn-warning fw-semibold col-12 col-lg-2 text-black" @disabled($params->count() == 0)
          ><a href="{{route('student-management.index')}}"
            class="text-decoration-none text-black">Bersihkan</a></button>
        <button type="submit" class="col-12 fw-semibold col-lg-2 btn btn-danger">
          Terapkan
        </button>
      </div>
    </form>
  </div>
  <div class="table-wrapper mb-2 overflow-auto">
    @if ($params->count() > 0 )
    <div class="badge-wrapper mb-1 text-center text-md-start">
      @foreach ($params->toArray() as $key => $value)
      <span class="badge rounded-pill mt-1 text-bg-secondary py-2">
        <span class="d-flex align-items-center gap-2">
          @switch($key)
          @case($key == 'program_study_id')
          {{$labels->get($key)." : ".$prodys->where('id',
          $value)->first()->name}}
          @break
          @case($key == 'submission_status')
          {{$labels->get($key)." : ".($value == App\Support\Enums\SubmissionStatusEnum::ACCEPTED->value ? 'Diterima' :
          ($value == App\Support\Enums\SubmissionStatusEnum::DECLINED->value ? 'Ditolak' :
          ($value == App\Support\Enums\SubmissionStatusEnum::UNSUBMITED->value ? 'Belum Dikumpulkan' :
          'Pending')))}}
          @break
          @default
          {{$labels->get($key)." : ".$value}}
          @endswitch
          <a href="{{route('student-management.index', $params->filter(function(string $item, string $key) use($value) {
            return $item != $value;
          }))}}" class="text-decoration-none text-white"><i class="ri-close-line"></i>
          </a>
        </span>
      </span>
      @endforeach
    </div>
    @endif
    <table id="category-table" class="table mt-3 table-hover" style="width: 100%">
      <thead>
        <tr>
          <th class="text-white fw-medium">No.</th>
          <th class="text-white fw-medium">Nama</th>
          <th class="text-white fw-medium">Username</th>
          <th class="text-white fw-medium">Email</th>
          <th class="text-white fw-medium">Status Tugas Akhir</th>
          <th class="text-white fw-medium">Aksi</th>
        </tr>
      </thead>
      <tbody id="tableBody">
        @forelse ($students as $student)
        <tr>
          <td>{{$student->id}}</td>
          <td>{{$student->first_name." ".$student->last_name}}</td>
          <td>{{$student->username}}</td>
          <td>{{$student->email}}</td>
          <td>
            @if (!$student->thesis)
            {{'Belum Dikumpulkan'}}
            @elseif (!isset($student->thesis->submission_status))
            {{'Pending'}}
            @else
            {{$student->thesis->submission_status ? "Diterima": "Ditolak"}}
            @endif
          </td>
          <td>
            <div class="d-flex gap-1">
              <div class="btn btn-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal"
                data-username="{{$student->username}}"
                data-delete-link="{{route('student-management.destroy', $student->id)}}">
                Delete</div>
              <a href="{{route('student-management.edit', $student->id)}}"
                class="btn btn-warning edit-btn text-black">Edit</a>
              <a href="{{route('student-management.show', $student->id)}}"
                class="btn edit-btn btn-detail text-white">Detail</a>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center">Data Mahasiswa Tidak Ditemukan</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="pagination-box d-flex justify-content-end">
    {{$students->links('pagination::simple-bootstrap-5')}}
  </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Delete User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 class="text-center">Apakah anda yakin untuk menghapus mahasiswa dengan username <span
            class="username"></span>?
        </h4>
      </div>
      <form class="form" action="" method="post" id="deleteForm">
        @method('delete')
        @csrf
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" id="deletecriteria" class="btn btn-danger btn-submit">Delete</button>
      </form>
    </div>
  </div>
</div>
</div>

<!-- Import Student Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <form class="form" action="{{route('importStudentExcelData')}}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel">Impor Excel</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="template-wrapper mb-2">
            <label class="form-label">Unduh Template</label>
            <a href="{{route('getStudentImportTemplate')}}" class="d-block">Template_Mahasiswa.XLSX</a>
          </div>
          <div class="mb-2">
            <label class="form-label">Program Studi</label>
            <select class="form-select" aria-label="Default select example" name="program_study_id" required>
              <option value="">Pilih Program Studi</option>
              @foreach ($prodys as $prody)
              <option value="{{$prody->id}}">
                {{$prody->name}}
              </option>
              @endforeach
            </select>
          </div>
          <div class="mb-2">
            <label class="form-label">Unggah Data</label>
            <input class="form-control" type="file" id="formFile" name="import_file" required />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success btn-submit">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection

@push('js')
<script>
  $(document).on('click', '.delete-btn', function(event){
        let name = $(this).data('username');
        let deleteLink = $(this).data('delete-link');

        $('#deleteModal').modal('show');
        $('.username').html(name);

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