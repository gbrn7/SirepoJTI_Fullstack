<div class="mb-2">
  <label class="form-label">Judul</label>
  <input data-cy="input-title" type="text" class="form-control" placeholder="Masukan judul"
    value="{{old('title', isset($thesis) ? $thesis->title : '')}}" name="title" required />
</div>
<div class="mb-2">
  <label class="form-label">Abstrak</label>
  <textarea data-cy="input-abstract" class="form-control" rows="3" placeholder="Masukkan abstrak" required
    name="abstract">{{old('abstract', isset($thesis) ? $thesis->abstract : '')}}</textarea>
</div>
<div class="mb-2">
  <label class="form-label">Topik</label>
  <select data-cy="input-topic" class="form-select" aria-label="Default select example" name="topic_id" required>
    <option value="">Pilih Topik Dokumen</option>
    @foreach ($topics as $topic)
    <option value="{{$topic->id}}" @selected(old('topic_id', isset($thesis) ? $thesis->topic_id :
      '') ==$topic->id)>
      {{$topic->topic}}
    </option>
    @endforeach
  </select>
</div>
<div class="mb-2">
  <label class="form-label">Jenis Tugas Akhir</label>
  <select data-cy="input-thesis-type" class="form-select" aria-label="Default select example" name="type_id" required>
    <option value="">Pilih Jenis Tugas Akhir</option>
    @foreach ($types as $type)
    <option value="{{$type->id}}" @selected(old('type_id', isset($thesis) ? $thesis->type_id :
      '') ==$type->id)>
      {{$type->type}}
    </option>
    @endforeach
  </select>
</div>
<div class="mb-2">
  <label class="form-label">Dosen Pembimbing</label>
  <select data-cy="input-lecturer" class="form-select" aria-label="Default select example" name="lecturer_id" required>
    <option value="">Pilih Dosen Pembimbing</option>
    @foreach ($lecturers as $lecturer)
    <option value="{{$lecturer->id}}" @selected(old('lecturer_id', isset($thesis) ? $thesis->lecturer_id :
      '') ==$lecturer->id)>
      {{$lecturer->name}}
    </option>
    @endforeach
  </select>
</div>
<div class="mb-2">
  <label class="form-label">Dokumen Lengkap (Wajib)</label>
  <label class="w-100 drop-area" id="drop-area">
    <input type="file" name="required_file" data-cy="input-complete-document" hidden id="input-file" class="input-file">
    <div class="img-view py-3 w-100 h-100 rounded rounded-2 d-flex justify-content-center align-items-center">
      <div class="default-view">
        <i class="ri-upload-cloud-2-fill upload-icon"></i>
        <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
      </div>
    </div>
  </label>
</div>
<div class="optional-document-wrapper">
  <label class="form-label">Dokumen Tambahan (Opsional)</label>
  <div class="optional-document-file-wrap d-flex flex-wrap gap-x-1 gap-y-2">
    <div class="mb-2 col-12 col-lg-6 p-2 overflow-hidden text-wrap">
      <label class="w-100 drop-area" id="drop-area">
        <div class="wrapper text-start mb-3">
          <label class="form-label">Nama Dokumen</label>
          <input type="text" class="form-control" placeholder="Masukan judul" value="Abstrak" name="abstract_label"
            required disabled />
        </div>
        <div class="file-wrapper">
          <label class="form-label d-block text-start">Dokumen</label>
          <input type="file" data-cy="input-abstract-document" name="abstract_file" hidden id="input-file"
            class="input-file">
          <div class="img-view py-3 w-100 rounded rounded-2 d-flex justify-content-center align-items-center">
            <div class="default-view">
              <i class="ri-upload-cloud-2-fill upload-icon"></i>
              <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
            </div>
          </div>
        </div>
      </label>
    </div>
    <div class="mb-2 col-12 col-lg-6 p-2 overflow-hidden text-wrap">
      <label class="w-100 drop-area" id="drop-area">
        <div class="wrapper text-start mb-3">
          <label class="form-label">Nama Dokumen</label>
          <input type="text" class="form-control" value="Daftar Isi" name="list_of_content_label" required disabled />
        </div>
        <div class="file-wrapper">
          <label class="form-label d-block text-start">Dokumen</label>
          <input type="file" name="list_of_content_file" data-cy="input-list-of-content-document" hidden id="input-file"
            class="input-file">
          <div class="img-view py-3 w-100 rounded rounded-2 d-flex justify-content-center align-items-center">
            <div class="default-view">
              <i class="ri-upload-cloud-2-fill upload-icon"></i>
              <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
            </div>
          </div>
        </div>
      </label>
    </div>
    <div class="mb-2 col-12 col-lg-6 p-2 overflow-hidden text-wrap">
      <label class="w-100 drop-area" id="drop-area">
        <div class="wrapper text-start mb-3">
          <label class="form-label">Nama Dokumen</label>
          <input type="text" class="form-control" value="BAB I" placeholder="Masukan judul" name=" chapter_1_label"
            required disabled />
        </div>
        <div class="file-wrapper">
          <label class="form-label d-block text-start">Dokumen</label>
          <input type="file" value="BAB I" name="chapter_1_file" data-cy="input-chapter-1-document" hidden
            id="input-file" class="input-file">
          <div class="img-view py-3 w-100 rounded rounded-2 d-flex justify-content-center align-items-center">
            <div class="default-view">
              <i class="ri-upload-cloud-2-fill upload-icon"></i>
              <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
            </div>
          </div>
        </div>
      </label>
    </div>
    <div class="mb-2 col-12 col-lg-6 p-2 overflow-hidden text-wrap">
      <label class="w-100 drop-area" id="drop-area">
        <div class="wrapper text-start mb-3">
          <label class="form-label">Nama Dokumen</label>
          <input type="text" class="form-control" placeholder="Masukan judul" value="BAB II" name="chapter_2_label"
            required disabled />
        </div>
        <div class="file-wrapper">
          <label class="form-label d-block text-start">Dokumen</label>
          <input type="file" name="chapter_2_file" data-cy="input-chapter-2-document" hidden id="input-file"
            class="input-file">
          <div class="img-view py-3 w-100 rounded rounded-2 d-flex justify-content-center align-items-center">
            <div class="default-view">
              <i class="ri-upload-cloud-2-fill upload-icon"></i>
              <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
            </div>
          </div>
        </div>
      </label>
    </div>
    <div class="mb-2 col-12 col-lg-6 p-2 overflow-hidden text-wrap">
      <label class="w-100 drop-area" id="drop-area">
        <div class="wrapper text-start mb-3">
          <label class="form-label">Nama Dokumen</label>
          <input type="text" class="form-control" placeholder="Masukan judul" value="BAB III" name="chapter_3_label"
            required disabled />
        </div>
        <div class="file-wrapper">
          <label class="form-label d-block text-start">Dokumen</label>
          <input type="file" name="chapter_3_file" data-cy="input-chapter-3-document" hidden id="input-file"
            class="input-file">
          <div class="img-view py-3 w-100 rounded rounded-2 d-flex justify-content-center align-items-center">
            <div class="default-view">
              <i class="ri-upload-cloud-2-fill upload-icon"></i>
              <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
            </div>
          </div>
        </div>
      </label>
    </div>
    <div class="mb-2 col-12 col-lg-6 p-2 overflow-hidden text-wrap">
      <label class="w-100 drop-area" id="drop-area">
        <div class="wrapper text-start mb-3">
          <label class="form-label">Nama Dokumen</label>
          <input type="text" class="form-control" placeholder="Masukan judul" value="BAB IV" name="chapter_4_label"
            required disabled />
        </div>
        <div class="file-wrapper">
          <label class="form-label d-block text-start">Dokumen</label>
          <input type="file" name="chapter_4_file" data-cy="input-chapter-4-document" hidden id="input-file"
            class="input-file">
          <div class="img-view py-3 w-100 rounded rounded-2 d-flex justify-content-center align-items-center">
            <div class="default-view">
              <i class="ri-upload-cloud-2-fill upload-icon"></i>
              <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
            </div>
          </div>
        </div>
      </label>
    </div>
    <div class="mb-2 col-12 col-lg-6 p-2 overflow-hidden text-wrap">
      <label class="w-100 drop-area" id="drop-area">
        <div class="wrapper text-start mb-3">
          <label class="form-label">Nama Dokumen</label>
          <input type="text" class="form-control" placeholder="Masukan judul" value="BAB V" name="chapter_5_label"
            required disabled />
        </div>
        <div class="file-wrapper">
          <label class="form-label d-block text-start">Dokumen</label>
          <input type="file" name="chapter_5_file" data-cy="input-chapter-5-document" hidden id="input-file"
            class="input-file">
          <div class="img-view py-3 w-100 rounded rounded-2 d-flex justify-content-center align-items-center">
            <div class="default-view">
              <i class="ri-upload-cloud-2-fill upload-icon"></i>
              <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
            </div>
          </div>
        </div>
      </label>
    </div>
    <div class="mb-2 col-12 col-lg-6 p-2 overflow-hidden text-wrap">
      <label class="w-100 drop-area" id="drop-area">
        <div class="wrapper text-start mb-3">
          <label class="form-label">Nama Dokumen</label>
          <input type="text" class="form-control" placeholder="Masukan judul" value="BAB VI" name="chapter_6_label"
            required disabled />
        </div>
        <div class="file-wrapper">
          <label class="form-label d-block text-start">Dokumen</label>
          <input type="file" name="chapter_6_file" data-cy="input-chapter-6-document" hidden id="input-file"
            class="input-file">
          <div class="img-view py-3 w-100 rounded rounded-2 d-flex justify-content-center align-items-center">
            <div class="default-view">
              <i class="ri-upload-cloud-2-fill upload-icon"></i>
              <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
            </div>
          </div>
        </div>
      </label>
    </div>
    <div class="mb-2 col-12 col-lg-6 p-2 overflow-hidden text-wrap">
      <label class="w-100 drop-area" id="drop-area">
        <div class="wrapper text-start mb-3">
          <label class="form-label">Nama Dokumen</label>
          <input type="text" class="form-control" placeholder="Masukan judul" value="BAB VII" name="chapter_7_label"
            required disabled />
        </div>
        <div class="file-wrapper">
          <label class="form-label d-block text-start">Dokumen</label>
          <input type="file" name="chapter_7_file" data-cy="input-chapter-7-document" hidden id="input-file"
            class="input-file">
          <div class="img-view py-3 w-100 rounded rounded-2 d-flex justify-content-center align-items-center">
            <div class="default-view">
              <i class="ri-upload-cloud-2-fill upload-icon"></i>
              <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
            </div>
          </div>
        </div>
      </label>
    </div>
    <div class="mb-2 col-12 col-lg-6 p-2 overflow-hidden text-wrap">
      <label class="w-100 drop-area" id="drop-area">
        <div class="wrapper text-start mb-3">
          <label class="form-label">Nama Dokumen</label>
          <input type="text" class="form-control" placeholder="Masukan judul" value="Daftar Pustaka"
            name="bibliography_label" required disabled />
        </div>
        <div class="file-wrapper">
          <label class="form-label d-block text-start">Dokumen</label>
          <input type="file" name="bibliography_file" data-cy="input-bibliography-document" hidden id="input-file"
            class="input-file">
          <div class="img-view py-3 w-100 rounded rounded-2 d-flex justify-content-center align-items-center">
            <div class="default-view">
              <i class="ri-upload-cloud-2-fill upload-icon"></i>
              <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
            </div>
          </div>
        </div>
      </label>
    </div>
    <div class="mb-2 col-12 p-2 overflow-hidden text-wrap">
      <label class="w-100 drop-area" id="drop-area">
        <div class="wrapper text-start mb-3">
          <label class="form-label">Nama Dokumen</label>
          <input type="text" class="form-control" placeholder="Masukan judul" value="Lampiran" name="attachment_label"
            required disabled />
        </div>
        <div class="file-wrapper">
          <label class="form-label d-block text-start">Dokumen</label>
          <input type="file" name="attachment_file" data-cy="input-attachment-document" hidden id="input-file"
            class="input-file">
          <div class="img-view py-3 w-100 rounded rounded-2 d-flex justify-content-center align-items-center">
            <div class="default-view">
              <i class="ri-upload-cloud-2-fill upload-icon"></i>
              <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
            </div>
          </div>
        </div>
      </label>
    </div>

  </div>
</div>