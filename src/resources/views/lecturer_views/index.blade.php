@extends('layouts.base')

@section('title', 'Documents Management')

@section('custom_css_link', asset('css/Data-Management_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">Tugas Akhir Bimbingan</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item">
        <a href="{{route('home')}}" class="text-decoration-none">Beranda</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">Tugas Akhir Bimbingan</li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="main-content">
  @php
  $params = collect(request()->all())->except(['page', 'lecturer_id'])->filter();
  $labels = collect([
  'title' => 'Judul',
  'student_username' => 'Username',
  'student_class_year' => 'Tahun Angkatan',
  'program_study_id' => 'Program Studi',
  'submission_status' => 'Status Penyerahan',
  ]);
  @endphp
  <div class="wrapper mt-3">
  </div>
  <form class="mt-2">
    <div class="wrapper filter-wrapper d-flex flex-column flex-lg-row gap-1">
      <div class="input-wrapper col">
        <input type="text" class="form-control" data-cy="input-title" name="title" value="{{request()->get('title')}}"
          placeholder="Judul">
      </div>
      <div class="input-wrapper col">
        <input type="text" class="form-control" data-cy="input-username" name="student_username" placeholder="Username"
          value="{{request()->get('student_username')}}">
      </div>
      <div class="input-wrapper col">
        <input type="number" class="form-control" data-cy="input-student-class-year" name="student_class_year"
          value="{{request()->get('student_class_year')}}" placeholder="Tahun Angkatan">
      </div>
      <div class="input-wrapper col">
        <select data-cy="select-program-study" class="form-select" name="program_study_id">
          <option value="">Program Studi</option>
          @foreach ($prodys as $prody)
          <option value="{{$prody->id}}" @selected(request()->get('program_study_id') == $prody->id)>
            {{$prody->name}}
          </option>
          @endforeach
        </select>
      </div>
      <div class="input-wrapper col">
        <select class="form-select" data-cy="select-submission-status" name="submission_status">
          <option value="">Status Penyerahan</option>
          <option value="pending" @selected(request()->get('submission_status') == 'pending')>Pending</option>
          <option value="accepted" @selected(request()->get('submission_status') == 'accepted')>Diterima</option>
          <option value="declined" @selected(request()->get('submission_status') == 'declined')>Ditolak</option>
        </select>
      </div>
    </div>
    <div class="btn-action-wrapper d-flex flex-column flex-lg-row justify-content-between gap-2 mt-2">

      <div data-cy="btn-modal-export" data-bs-toggle="modal" data-bs-target="#exportModal"
        class="btn btn-success fw-semibold col-12 col-lg-2">
        Ekspor Data
      </div>
      <div class="group col-12 col-lg-8 text-end">
        <button class="btn btn-warning col-12 col-lg-3 fw-semibold text-black" @disabled($params->count() == 0)>
          <a href="{{route('thesis-submission-lecturer.index')}}" class="text-decoration-none text-black">Bersihkan</a>
        </button>
        <button data-cy="btn-submit" type="submit" class="mt-1 mt-lg-0 col-12 col-lg-3 fw-semibold btn btn-danger">
          Terapkan
        </button>
      </div>

    </div>
  </form>
  <div class="table-wrapper pb-5 mt-3">
    @csrf
    @method('PUT')
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
          <a href="{{route('thesis-submission-lecturer.index', $params->filter(function(string $item, string $key) use($value) {
              return $item != $value;
            }))}}" class="text-decoration-none text-white"><i class="ri-close-line"></i>
          </a>
        </span>
      </span>
      @endforeach
    </div>
    @endif
    <table id="dataTable" class="table table-jquery table-hover" style="width: 100%">
      <thead>
        <tr>
          <th class="text-white fw-medium">No.</th>
          <th class="text-white fw-medium">Judul</th>
          <th class="text-white fw-medium">Topik</th>
          <th class="text-white fw-medium">Penulis</th>
          <th class="text-white fw-medium">Prodi</th>
          <th class="text-white fw-medium">Username</th>
          <th class="text-white fw-medium">Status</th>
        </tr>
      </thead>
      <tbody id="tableBody">
        @forelse ($documents as $document)
        <tr>
          <td>{{$document->thesis_id}}</td>
          <td>{{$document->thesis_title}}</td>
          <td>{{$document->thesis_topic}}</td>
          <td class="text-capitalize">{{$document->last_name.', '.$document->first_name}}</td>
          <td>{{$document->program_study_name}}</td>
          <td>{{$document->username}}</td>
          <td>{{isset($document) ? isset($document?->submission_status) ? $document?->submission_status ? "Diterima":
            "Ditolak" :
            "Pending" : "-"}}</td>
        </tr>
        @empty
        <tr>
          <td colspan="9" class="text-center">Dokumen Tidak Ditemukan</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class=" pagination-box d-flex justify-content-end mt-2">
    {{$documents->links('pagination::simple-bootstrap-5')}}
  </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Ekspor Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action={{route('export-students-guidance-thesis-status-data')}} class="form" id="addForm">
          <div class="form-group mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Tahun Angkatan</label>
            <input type="number" class="form-control" data-cy="input-student-class-year-export"
              name="student_class_year" value="{{request()->get('student_class_year')}}" placeholder="Tahun Angkatan">
          </div>
          <div class="form-group mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Program Studi</label>
            <select data-cy="select-program-study-export" class="form-select" name="program_study_id">
              <option value="">Program Studi</option>
              @foreach ($prodys as $prody)
              <option value="{{$prody->id}}" @selected(request()->get('program_study_id') == $prody->id)>
                {{$prody->name}}
              </option>
              @endforeach
            </select>
          </div>
          <div class="form-group mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Status Penyerahan</label>
            <select class="form-select" data-cy="select-submission-status-export" name="submission_status">
              <option value="">Status Penyerahan</option>
              <option value={{App\Support\Enums\SubmissionStatusEnum::PENDING->value}}
                @selected(request()->get('submission_status') ==
                App\Support\Enums\SubmissionStatusEnum::PENDING->value)>
                Pending
              </option>
              <option value={{App\Support\Enums\SubmissionStatusEnum::ACCEPTED->value}}
                @selected(request()->get('submission_status') ==
                App\Support\Enums\SubmissionStatusEnum::ACCEPTED->value)>
                Diterima
              </option>
              <option value={{App\Support\Enums\SubmissionStatusEnum::DECLINED->value}}
                @selected(request()->get('submission_status') ==
                App\Support\Enums\SubmissionStatusEnum::DECLINED->value)>
                Ditolak
              </option>
            </select>
          </div>
          <div class="form-group mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Format Ekspor</label>
            <select class="form-select" data-cy="select-submission-status-export" name="export_format">
              <option value="excel">Excel</option>
              <option value="pdf">PDF</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button data-cy="btn-export-submit" type="submit" class="btn btn-submit btn-success fw-bold">Ekspor</button>
      </div>
      </form>
    </div>
  </div>
</div>

@endsection