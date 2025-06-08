<div class="detail-wrapper mt-3">
  @if (Auth::guard('student')->check())
  <div class="btn-wrapper">
    @if(isset($document))
    @if(isset($document->submission_status) && $document?->submission_status == false)
    <div class="btn btn-success"><a data-cy="btn-link-add-thesis" href="{{route('thesis-submission.create')}}"
        class="text-decoration-none text-white"><i class="ri-pencil-line me-1"></i>
        <span>Unggah Ulang</span></a>
    </div>
    @endif
    @else
    <div class="btn btn-success"><a data-cy="btn-link-add-thesis" href="{{route('thesis-submission.create')}}"
        class="text-decoration-none text-white"><i class="ri-pencil-line me-1"></i>
        <span>Isi Data</span></a>
    </div>
    @endif
  </div>
  @endif
  <div class="detail-thesis-wrapper mt-3">
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Judul</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center">
          {{$document?->title
          ? $document->title : "-"}}</div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Abstrak</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center">
          {{$document?->abstract
          ? $document->abstract : "-"}}</div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Topik</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center">
          {{$document?->topic?->topic
          ? $document->topic->topic : "-"}}</div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Jenis Tugas Akhir</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center">
          {{$document?->type?->type
          ? $document->type->type : "-"}}</div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Dosen Pembimbing</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center">
          {{$document?->lecturer?->name
          ? $document->lecturer->name : "-"}}</div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Status Penyerahan</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center"><span
            @class([ 'badge' , 'text-black'=> !isset($document) ,'text-bg-secondary'=>
            isset($document) && !isset($document?->submission_status),'text-white text-bg-danger'=>
            isset($document?->submission_status) &&
            !$document?->submission_status, 'text-white text-bg-success'=>
            $document?->submission_status,
            ])>{{isset($document) ? isset($document?->submission_status) ? $document?->submission_status ? "Diterima":
            "Ditolak" :
            "Pending" : "-"}}</span></div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Catatan</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <div class="value-field bg-white px-2 rounded-2 h-100 d-flex py-2 py-lg-0 align-items-center">
          {{$document?->note
          ? $document?->note : "-"}}</div>
      </div>
    </div>
    <hr>
    <div class="detail-field title-field d-lg-flex">
      <div class="label-wrapper col-12 col-lg-2 py-2 d-flex justify-content-lg-between gap-3 gap-lg-0">
        <span class="label-field d-block">Dokumen</span>
        <span class="d-block">:</span>
      </div>
      <div class="value-field-wrapper col-12 col-lg-10 ps-lg-3">
        <table class="table bg-white table-bordered">
          <thead>
            <tr>
              <th>No.</th>
              <th>Dokumen</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            @if (isset($document?->files))
            @foreach ($document?->files as $file)
            <td>{{$loop->iteration}}</td>
            <td>
              <a target="blank" href="{{route('detail.document.download', 
              ['thesis_id'=> $document->id, 'file_name'=>
                $file->file_name])}}" class="text-decoration-none" data-cy="link-document">{{$file->file_name}}
              </a>
            </td>
            <td>
              <p class="mb-0">{{$file?->label}}</p>
            </td>
            </tr>
            @endforeach
            @else
            <td>-</td>
            <td>-</td>
            <td>-</td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
    <hr>
  </div>
  @if (Auth::guard('admin')->check())
  <div class="action-button-wrapper gap-2 d-flex flex-column mt-2 flex-md-row justify-content-md-end">
    <button data-bs-toggle="modal" data-bs-target="#declineModal"
      class="btn fw-semibold btn-danger col-12 col-md-3 col-lg-2" data-cy="btn-thesis-dcd">
      Tolak Tugas
    </button>
    <form id="form-tag" action="{{route('document-management.update', $document->id)}}" method="post"
      class="col-12 fw-semibold col-md-3 col-lg-2 btn-bulk-action">
      @csrf
      @method('PUT')
      <input type="hidden" name="submission_status" value="accepted">
      <button type="submit" class="btn btn-success fw-semibold col-12" data-cy="btn-thesis-acc">
        Terima Tugas
      </button>
    </form>
  </div>


  <!-- Decline Modal -->
  <div class="modal fade" id="declineModal" data-bs-backdrop="static" tabindex="-2"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <form id="form-tag" action="{{route('document-management.update', $document->id)}}" method="post">
      @csrf
      @method('PUT')
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tolak Tugas Akhir</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="exampleFormControlTextarea1" class="form-label">Catatan</label>
              <textarea data-cy="textarea-note" class="form-control" id="declineThesisNote" name="note"
                rows="3"></textarea>
              <input type="hidden" name="submission_status" value="declined">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-submit fw-bold btn-warning"
              data-cy="btn-thesis-dcd-submit">Submit</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  @endif

</div>