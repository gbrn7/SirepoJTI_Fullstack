@extends('layouts.base')

@section('title', 'Dashboard')

@section('custom_css_link', asset('css/Data-Management_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">Dashboard</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item">
        <a href="{{route('home')}}" class="text-decoration-none">Beranda</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="main-content pt-lg-3 d-lg-flex">
  @php
  $params = collect(request()->all())->filter();
  $labels = collect([
  'publication_year' => 'Tahun Publikasi',
  'student_class_year' => 'Tahun Angkatan',
  'topic_id' => 'Topik Tugas Akhir',
  'program_study_id' => 'Program Studi',
  'lecturer_id' => 'Dosen',
  'submission_status' => 'Status Penyerahan',
  'type_id' => 'Jenis Tugas Akhir',
  ]);
  @endphp
  <form id="form-tag" class="filter-wrapper d-flex col-12 col-lg-2 flex-column" action="{{route('dashboard.index')}}"
    method="get">
    <div class="input-wrapper mb-2">
      <label class="form-label">Tahun Publikasi</label>
      <input type="text" class="form-control" data-cy="input-publication-year" name="publication_year"
        placeholder="Tahun Publikasi" value="{{request()->get('publication_year')}}">
    </div>
    <div class="input-wrapper mb-2">
      <label class="form-label">Tahun Angkatan</label>
      <input type="text" class="form-control" data-cy="input-class-year" name="student_class_year"
        placeholder="Tahun Publikasi" value="{{request()->get('student_class_year')}}">
    </div>
    <div class="input-wrapper mb-2">
      <label class="form-label">Program Studi</label>
      <select data-cy="select-program-study" class="form-select" name="program_study_id">
        <option value="">Program Studi</option>
        @foreach ($prodys as $prody)
        <option value="{{$prody->id}}" @selected(request()->get('program_study_id') == $prody->id)>
          {{$prody->name}}
        </option>
        @endforeach
      </select>
    </div>
    <div class="input-wrapper mb-2">
      <label class="form-label">Topik Tugas Akhir</label>
      <select data-cy="select-topic" class="form-select" name="topic_id">
        <option value="">Pilih Topik Tugas Akhir</option>
        @foreach ($topics as $topic)
        <option value="{{$topic->id}}" @selected(request()->get('topic_id') == $topic->id)>
          {{$topic->topic}}
        </option>
        @endforeach
      </select>
    </div>
    <div class="input-wrapper mb-2">
      <label class="form-label">Dosen Pembimbing</label>
      <select data-cy="select-lecturer" class="form-select" aria-label="Default select example" name="lecturer_id">
        <option value="">Pilih Dosen Pembimbing</option>
        @foreach ($lecturers as $lecturer)
        <option value="{{$lecturer->id}}" @selected(request()->get('lecturer_id') == $lecturer->id)>
          {{$lecturer->name}}
        </option>
        @endforeach
      </select>
    </div>
    <div class="input-wrapper mb-2">
      <label class="form-label">Jenis Tugas Akhir</label>
      <select data-cy="select-thesis-type" class="form-select" aria-label="Default select example" name="type_id">
        <option value="">Pilih Jenis Tugas Akhir</option>
        @foreach ($types as $type)
        <option value="{{$type->id}}" @selected(request()->get('type_id') == $type->id)>
          {{$type->type}}
        </option>
        @endforeach
      </select>
    </div>
    <div class="action-wrapper mb-2">
      <Button type="submit" data-cy="btn-submit" class="btn btn-danger fw-semibold col-12 mb-2">Terapkan</Button>
      <button class="btn btn-warning fw-semibold col-12" @disabled($params->count() == 0)><a
          href="{{route('dashboard.index')}}" class="text-decoration-none text-black">Bersihkan</a></button>
    </div>
    @if ($params->count() > 0 )
    <div class="badge-wrapper col-12 mb-1 text-center text-md-start">
      @foreach ($params->toArray() as $key => $value)
      <span class="badge rounded-pill col-12 text-wrap mt-1 text-bg-secondary py-2">
        <span class="text-start d-flex align-items-center justify-content-between gap-2">
          @switch($key)
          @case($key == 'program_study_id')
          {{$labels->get($key)." :
          ".$prodys->where('id',
          $value)->first()->name}}
          @break
          @case($key == 'topic_id')
          {{$labels->get($key)." :
          ".$topics->where('id',
          $value)->first()->topic}}
          @break
          @case($key == 'lecturer_id')
          {{$labels->get($key)." :
          ".$lecturers->where('id',
          $value)->first()->name}}
          @break
          @case($key == 'type_id')
          {{$labels->get($key)." :
          ".$types->where('id',
          $value)->first()->type}}
          @break
          @default
          {{$labels->get($key)." : ".$value}}
          @endswitch
          <a href="{{route('dashboard.index', $params->filter(function(string $item, string $key) use($value) {
            return $item != $value;
          }))}}" class="text-decoration-none text-white"><i class="ri-close-line"></i>
          </a>
        </span>
      </span>
      @endforeach
    </div>
    @endif
  </form>
  <div class="dashboard-wrapper col-12 col-lg-10 px-2">
    <div class=" d-flex flex-column flex-lg-row gap-2 gap-lg-0">
      <div class="col-lg-4 col-12 chart-column px-1 d-flex flex-column justify-content-between gap-1">
        <div class="content-wrapper chart-card p-2 bg-white rounded rounded-lg col-12">
          <div class="subtitle-wrapper">
            <p class="fw-semibold fs-6 mb-0 text-black text-uppercase">Jumlah Tugas Akhir</p>
            <p class="text-secondary subtitle-chart">Total Tugas Akhir</p>
          </div>
          <div class="chart-wrapper fw-bold col-12 fs-1 purecounter" data-purecounter-start="0"
            data-purecounter-end="{{$thesisTotalCount}}" data-purecounter-duration="1">
            0
          </div>
        </div>
        <div class="content-wrapper chart-card p-2 bg-white rounded rounded-lg col-12">
          <div class="subtitle-wrapper">
            <p class="fw-semibold fs-6 mb-0 text-black text-uppercase">Tugas Akhir Per Topik</p>
            <p class="text-secondary subtitle-chart">Total Tugas Akhir Per Topik</p>
          </div>
          <div class="chart-wrapper col-12">
            {!! $thesisTotalPerTopic->container() !!}
          </div>
        </div>
        <div class="content-wrapper chart-card p-2 bg-white rounded rounded-lg col-12">
          <div class="subtitle-wrapper">
            <p class="fw-semibold fs-6 mb-0 text-black text-uppercase">Tugas Akhir Per Jenis</p>
            <p class="text-secondary subtitle-chart">Perbandingan jumlah tugas akhir berdasarkan jenis</p>
          </div>
          <div class="chart-wrapper fw-bold col-12">
            {!! $thesisTotalPerType->container() !!}
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-12 chart-column px-1 d-flex flex-column justify-content-between gap-1">
        <div class="content-wrapper chart-card p-2 bg-white rounded rounded-lg col-12">
          <div class="subtitle-wrapper">
            <p class="fw-semibold fs-6 mb-0 text-black text-uppercase">Tugas Akhir Per Tahun</p>
            <p class="text-secondary subtitle-chart">Total tugas akhir 5 tahun terakhir</p>
          </div>
          <div class="chart-wrapper col-12">
            {!! $thesisPerYearChart->container() !!}
          </div>
        </div>
        <div class="content-wrapper chart-card p-2 bg-white rounded rounded-lg col-12">
          <div class="subtitle-wrapper">
            <p class="fw-semibold fs-6 mb-0 text-black text-uppercase">Tugas Akhir Per Angkatan</p>
            <p class="text-secondary subtitle-chart">Tabel Total Tugas Akhir Berdasarkan Tahun Angkatan</p>
          </div>
          <div class="chart-wrapper chart-table-wrapper col-12 overflow-auto">
            <table class="table mb-0 table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Angkatan</th>
                  <th>Jumlah</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($thesisTotalPerClassYear as $item)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$item->get('label')}}</td>
                  <td>{{$item->get('value')}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="content-wrapper chart-card p-2 bg-white rounded rounded-lg col-12">
          <div class="subtitle-wrapper">
            <p class="fw-semibold fs-6 mb-0 text-black text-uppercase">Tugas Akhir Per Gender</p>
            <p class="text-secondary subtitle-chart">Perbandingan jumlah tugas akhir setiap gender</p>
          </div>
          <div class="chart-wrapper fw-bold col-12">
            {!! $thesisTotalMaleFemale->container() !!}
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-12 chart-column px-1 d-flex flex-column justify-content-between gap-1">
        <div class="content-wrapper chart-card p-2 bg-white rounded rounded-lg col-12">
          <div class="subtitle-wrapper">
            <p class="fw-semibold fs-6 mb-0 text-black text-uppercase">Jumlah Tugas Akhir Per Dosen</p>
            <p class="text-secondary subtitle-chart">Total Jumlah Tugas Akhir Berdasarkan Dosen</p>
          </div>
          <div class="chart-wrapper col-12">
            {!! $thesisTotalPerLecturer->container() !!}
          </div>
        </div>
        <div class="content-wrapper chart-card p-2 bg-white rounded rounded-lg col-12">
          <div class="subtitle-wrapper">
            <p class="fw-semibold fs-6 mb-0 text-black text-uppercase">Jumlah Tugas Akhir Per Program Studi</p>
            <p class="text-secondary subtitle-chart">Total Jumlah Tugas Akhir Berdasarkan Program Studi</p>
          </div>
          <div class="chart-wrapper col-12">
            {!! $thesisTotalPerPrody->container() !!}
          </div>
        </div>
        <div class="content-wrapper chart-card p-2 bg-white rounded rounded-lg col-12">
          <div class="subtitle-wrapper">
            <p class="fw-semibold fs-6 mb-0 text-black text-uppercase">Pengunduhan Tugas Akhir</p>
            <p class="text-secondary subtitle-chart">Tabel Peringkat Tugas Akhir Berdasarkan Jumlah Pengunduhan</p>
          </div>
          <div class="chart-wrapper chart-table-wrapper col-12">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Judul</th>
                  <th>Jumlah</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($thesisDownloadLeaderboard as $item)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$item->title}}</td>
                  <td>{{$item->download_count}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('js')

<script src="{{ $thesisPerYearChart->cdn() }}"></script>
<script src="{{ $thesisTotalMaleFemale->cdn() }}"></script>
<script src="{{ $thesisTotalPerTopic->cdn() }}"></script>
<script src="{{ $thesisTotalPerLecturer->cdn() }}"></script>
<script src="{{ $thesisTotalPerPrody->cdn() }}"></script>
<script src="{{ $thesisTotalPerType->cdn() }}"></script>

{{ $thesisPerYearChart->script() }}
{{ $thesisTotalMaleFemale->script() }}
{{ $thesisTotalPerTopic->script() }}
{{ $thesisTotalPerLecturer->script() }}
{{ $thesisTotalPerPrody->script() }}
{{ $thesisTotalPerType->script() }}

<!-- Pure Counter JS -->
<script src="{{ asset('vendor/purecounterjs-main/dist/purecounter_vanilla.js') }}"></script>

<script>
  new PureCounter();
</script>
@endpush