<div class="mb-2">
  <label class="form-label">Judul</label>
  <input type="text" class="form-control" placeholder="Masukan judul"
    value="{{old('title', isset($document) ? $document->title : '')}}" name="title" required />
</div>
<div class="mb-2">
  <label class="form-label">Abstrak</label>
  <textarea class="form-control" rows="3" placeholder="Enter abstrak" required
    name="abstract">{{old('abstract', isset($document) ? $document->abstract : '')}}</textarea>
</div>
<div class="mb-2">
  <label class="form-label">Topik</label>
  <select class="form-select" aria-label="Default select example" name="topic_id" required>
    <option value="">Pilih Topik Dokumen</option>
    @foreach ($topics as $topic)
    <option value="{{$topic->id}}" @selected(old('topic_id', isset($document) ? $document->topic_id :
      '') ==$topic->id)>
      {{$topic->topic}}
    </option>
    @endforeach
  </select>
</div>
<div class="mb-2">
  <label class="form-label">Jenis Tugas Akhir</label>
  <select class="form-select" aria-label="Default select example" name="type_id" required>
    <option value="">Pilih Jenis Tugas Akhir</option>
    @foreach ($types as $type)
    <option value="{{$type->id}}" @selected(old('type_id', isset($document) ? $document->type_id :
      '') ==$type->id)>
      {{$type->type}}
    </option>
    @endforeach
  </select>
</div>
<div class="mb-2">
  <label class="form-label">Dosen Pembimbing</label>
  <select class="form-select" aria-label="Default select example" name="lecturer_id" required>
    <option value="">Pilih Dosen Pembimbing</option>
    @foreach ($lecturers as $lecturer)
    <option value="{{$lecturer->id}}" @selected(old('lecturer_id', isset($document) ? $document->lecturer_id :
      '') ==$lecturer->id)>
      {{$lecturer->name}}
    </option>
    @endforeach
  </select>
</div>
<div class="mb-2">
  <label class="form-label">Dokumen Lengkap (Wajib)</label>
  <label class="w-100 drop-area" id="drop-area">
    <input type="file" name="required_file" hidden id="input-file" class="input-file">
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
  <div class="mb-2">
    <label class="w-100 drop-area" id="drop-area">
      <div class="wrapper text-start mb-3">
        <label class="form-label">Nama Dokumen</label>
        <input type="text" class="form-control" placeholder="Masukan judul" value="Abstrak" name="abstract_label"
          required disabled />
      </div>
      <div class="file-wrapper">
        <label class="form-label d-block text-start">Dokumen</label>
        <input type="file" name="abstract_file" hidden id="input-file" class="input-file">
        <div class="img-view py-3 w-100 rounded rounded-2 d-flex justify-content-center align-items-center">
          <div class="default-view">
            <i class="ri-upload-cloud-2-fill upload-icon"></i>
            <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
          </div>
        </div>
      </div>
    </label>
  </div>
  <div class="mb-2">
    <label class="w-100 drop-area" id="drop-area">
      <div class="wrapper text-start mb-3">
        <label class="form-label">Nama Dokumen</label>
        <input type="text" class="form-control" value="Daftar Isi" name="list_of_content_label" required disabled />
      </div>
      <div class="file-wrapper">
        <label class="form-label d-block text-start">Dokumen</label>
        <input type="file" name="list_of_content_file" hidden id="input-file" class="input-file">
        <div class="img-view py-3 w-100 rounded rounded-2 d-flex justify-content-center align-items-center">
          <div class="default-view">
            <i class="ri-upload-cloud-2-fill upload-icon"></i>
            <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
          </div>
        </div>
      </div>
    </label>
  </div>
  <div class="mb-2">
    <label class="w-100 drop-area" id="drop-area">
      <div class="wrapper text-start mb-3">
        <label class="form-label">Nama Dokumen</label>
        <input type="text" class="form-control" placeholder="Masukan judul" value="Bab I" name="chapter_1_label"
          required disabled />
      </div>
      <div class="file-wrapper">
        <label class="form-label d-block text-start">Dokumen</label>
        <input type="file" name="chapter_1_file" hidden id="input-file" class="input-file">
        <div class="img-view py-3 w-100 rounded rounded-2 d-flex justify-content-center align-items-center">
          <div class="default-view">
            <i class="ri-upload-cloud-2-fill upload-icon"></i>
            <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
          </div>
        </div>
      </div>
    </label>
  </div>
  <div class="mb-2">
    <label class="w-100 drop-area" id="drop-area">
      <div class="wrapper text-start mb-3">
        <label class="form-label">Nama Dokumen</label>
        <input type="text" class="form-control" placeholder="Masukan judul" value="BAB II" name="chapter_2_label"
          required disabled />
      </div>
      <div class="file-wrapper">
        <label class="form-label d-block text-start">Dokumen</label>
        <input type="file" name="chapter_2_label" hidden id="input-file" class="input-file">
        <div class="img-view py-3 w-100 rounded rounded-2 d-flex justify-content-center align-items-center">
          <div class="default-view">
            <i class="ri-upload-cloud-2-fill upload-icon"></i>
            <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
          </div>
        </div>
      </div>
    </label>
  </div>
  <div class="mb-2">
    <label class="w-100 drop-area" id="drop-area">
      <div class="wrapper text-start mb-3">
        <label class="form-label">Nama Dokumen</label>
        <input type="text" class="form-control" placeholder="Masukan judul" value="BAB III" name="chapter_3_label"
          required disabled />
      </div>
      <div class="file-wrapper">
        <label class="form-label d-block text-start">Dokumen</label>
        <input type="file" name="chapter_3_label" hidden id="input-file" class="input-file">
        <div class="img-view py-3 w-100 rounded rounded-2 d-flex justify-content-center align-items-center">
          <div class="default-view">
            <i class="ri-upload-cloud-2-fill upload-icon"></i>
            <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
          </div>
        </div>
      </div>
    </label>
  </div>
  <div class="mb-2">
    <label class="w-100 drop-area" id="drop-area">
      <div class="wrapper text-start mb-3">
        <label class="form-label">Nama Dokumen</label>
        <input type="text" class="form-control" placeholder="Masukan judul" value="BAB IV" name="chapter_4_label"
          required disabled />
      </div>
      <div class="file-wrapper">
        <label class="form-label d-block text-start">Dokumen</label>
        <input type="file" name="chapter_4_file" hidden id="input-file" class="input-file">
        <div class="img-view py-3 w-100 rounded rounded-2 d-flex justify-content-center align-items-center">
          <div class="default-view">
            <i class="ri-upload-cloud-2-fill upload-icon"></i>
            <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
          </div>
        </div>
      </div>
    </label>
  </div>
  <div class="mb-2">
    <label class="w-100 drop-area" id="drop-area">
      <div class="wrapper text-start mb-3">
        <label class="form-label">Nama Dokumen</label>
        <input type="text" class="form-control" placeholder="Masukan judul" value="BAB V" name="chapter_5_label"
          required disabled />
      </div>
      <div class="file-wrapper">
        <label class="form-label d-block text-start">Dokumen</label>
        <input type="file" name="chapter_5_file" hidden id="input-file" class="input-file">
        <div class="img-view py-3 w-100 rounded rounded-2 d-flex justify-content-center align-items-center">
          <div class="default-view">
            <i class="ri-upload-cloud-2-fill upload-icon"></i>
            <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
          </div>
        </div>
      </div>
    </label>
  </div>
  <div class="mb-2">
    <label class="w-100 drop-area" id="drop-area">
      <div class="wrapper text-start mb-3">
        <label class="form-label">Nama Dokumen</label>
        <input type="text" class="form-control" placeholder="Masukan judul" value="BAB VI" name="chapter_6_label"
          required disabled />
      </div>
      <div class="file-wrapper">
        <label class="form-label d-block text-start">Dokumen</label>
        <input type="file" name="chapter_6_file" hidden id="input-file" class="input-file">
        <div class="img-view py-3 w-100 rounded rounded-2 d-flex justify-content-center align-items-center">
          <div class="default-view">
            <i class="ri-upload-cloud-2-fill upload-icon"></i>
            <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
          </div>
        </div>
      </div>
    </label>
  </div>
  <div class="mb-2">
    <label class="w-100 drop-area" id="drop-area">
      <div class="wrapper text-start mb-3">
        <label class="form-label">Nama Dokumen</label>
        <input type="text" class="form-control" placeholder="Masukan judul" value="BAB VII" name="chapter_7_label"
          required disabled />
      </div>
      <div class="file-wrapper">
        <label class="form-label d-block text-start">Dokumen</label>
        <input type="file" name="chapter_2_file" hidden id="input-file" class="input-file">
        <div class="img-view py-3 w-100 rounded rounded-2 d-flex justify-content-center align-items-center">
          <div class="default-view">
            <i class="ri-upload-cloud-2-fill upload-icon"></i>
            <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
          </div>
        </div>
      </div>
    </label>
  </div>
  <div class="mb-2">
    <label class="w-100 drop-area" id="drop-area">
      <div class="wrapper text-start mb-3">
        <label class="form-label">Nama Dokumen</label>
        <input type="text" class="form-control" placeholder="Masukan judul" value="Daftar Pustaka"
          name="bibliography_label" required disabled />
      </div>
      <div class="file-wrapper">
        <label class="form-label d-block text-start">Dokumen</label>
        <input type="file" name="bibliography_file" hidden id="input-file" class="input-file">
        <div class="img-view py-3 w-100 rounded rounded-2 d-flex justify-content-center align-items-center">
          <div class="default-view">
            <i class="ri-upload-cloud-2-fill upload-icon"></i>
            <p class="file-desc mb-0">Drag and drop or click here <br>to upload document</p>
          </div>
        </div>
      </div>
    </label>
  </div>
  <div class="mb-2">
    <label class="w-100 drop-area" id="drop-area">
      <div class="wrapper text-start mb-3">
        <label class="form-label">Nama Dokumen</label>
        <input type="text" class="form-control" placeholder="Masukan judul" value="Lampiran" name="attachment_label"
          required disabled />
      </div>
      <div class="file-wrapper">
        <label class="form-label d-block text-start">Dokumen</label>
        <input type="file" name="attachment_file" hidden id="input-file" class="input-file">
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
<div class="wrapper d-flex justify-content-end">
  <button class="btn btn-submit text-black px-5 btn-warning" type="submit">Submit</button>
</div>