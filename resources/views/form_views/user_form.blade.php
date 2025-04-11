<div class="mb-2">
  <label class="form-label">Username</label>
  <input type="text" class="form-control" placeholder="Masukkan Username" name="username"
    {{Route::is('student-management.create') ? 'required' : '' }}
    value="{{old('username', isset($student) ? $student->username : '')}}" />
</div>
<div class="mb-2">
  <label class="form-label">Nama Depan</label>
  <input type="text" class="form-control" placeholder="Masukkan Nama Depan" name="first_name"
    {{Route::is('student-management.create') ? 'required' : '' }}
    value="{{old('name', isset($student) ? $student->first_name : '')}}" />
</div>
<div class="mb-2">
  <label class="form-label">Nama Belakang</label>
  <input type="text" class="form-control" placeholder="Masukkan Nama Belakang" name="last_name"
    {{Route::is('student-management.create') ? 'required' : '' }}
    value="{{old('name', isset($student) ? $student->last_name : '')}}" />
</div>
<div class="mb-2">
  <label class="form-label">Jenis Kelamin</label>
  <select name="gender" class="form-select">
    <option value="">Pilih Jenis Kelamin</option>
    <option value="Male" @selected(old('gender', isset($student) ? $student->gender : '') == 'Male')>Laki - Laki
    </option>
    <option value="Female" @selected(old('gender', isset($student) ? $student->gender : '') == 'Female')>Perempuan
    </option>
  </select>
</div>
<div class="mb-2">
  <label class="form-label">Tahun Angkatan</label>
  <input type="number" class="form-control" placeholder="Masukkan Tahun Angkatan" name="class_year"
    value="{{old('class_year', isset($student) ? $student->class_year : '')}}" />
</div>
<div class="mb-2">
  <label class="form-label">Email</label>
  <input type="email" class="form-control" placeholder="Masukkan Email" name="email"
    value="{{old('email', isset($student) ? $student->email : '')}}" />
</div>
<div class="mb-2">
  <label class="form-label">Password</label>
  <input type="password" class="form-control" {{Route::is('student-management.create') ? 'required' : '' }}
    placeholder="Masukkan Password" name="password" />
</div>
<div class="mb-2">
  <label class="form-label">Program Studi</label>
  <select class="form-select" name="program_study_id" {{Route::is('student-management.create') ? 'required' : '' }}>
    <option value="">Pilih Program Studi</option>
    @foreach ($prodys as $prody)
    <option value="{{$prody->id}}" @selected(old('program_study', isset($student) ? $student->program_study_id :
      '') ==$prody->id)>
      {{$prody->name}}
    </option>
    @endforeach
  </select>
</div>
<div class="mb-2">
  <label for="formFile" class="form-label">Gambar Profil</label>
  <input class="form-control" type="file" id="formFile" name="profile_picture" />
</div>
<div class="wrapper d-flex justify-content-end">
  <button class="btn btn-submit text-black px-5 btn-warning fw-semibold" type="submit">Submit</button>
</div>