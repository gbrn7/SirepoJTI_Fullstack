<div class="mb-2">
  <label class="form-label">Name</label>
  <input type="text" class="form-control" placeholder="Enter the name" name="name" {{Request::segment(2)==='create'
    ? 'required' : '' }} value="{{old('name', isset($user) ? $user->name : '')}}" />
</div>
<div class="mb-2">
  <label class="form-label">Username</label>
  <input type="text" class="form-control" placeholder="Enter the username" name="username"
    {{Request::segment(2)==='create' ? 'required' : '' }}
    value="{{old('username', isset($user) ? $user->username : '')}}" />
</div>
<div class="mb-2">
  <label class="form-label">Email</label>
  <input type="email" class="form-control" placeholder="Enter the email" name="email"
    value="{{old('email', isset($user) ? $user->email : '')}}" />
</div>
<div class="mb-2">
  <label class="form-label">Password</label>
  <input type="password" class="form-control" {{Request::segment(2)==='create' ? 'required' : '' }}
    placeholder="Enter the password" name="password" />
</div>
<div class="mb-2">
  <label class="form-label">Departement</label>
  <input type="text" readonly class="form-control" value="{{$majority->name}}" name="departement" />
</div>
<div class="mb-2">
  <label class="form-label">Program Study</label>
  <select class="form-select" aria-label="Default select example" name="program_study" {{Request::segment(2)==='create'
    ? 'required' : '' }}>
    <option value="">Select program study</option>
    @foreach ($prodys as $prody)
    <option value="{{$prody->id}}" @selected(old('program_study', isset($user) ? $user->id_program_study :
      '') ==$prody->id)>
      {{$prody->name}}
    </option>
    @endforeach
  </select>
</div>
<div class="mb-2">
  <label for="formFile" class="form-label">Profile Picture</label>
  <input class="form-control" type="file" id="formFile" name="profile_picture" {{Request::segment(2)==='create'
    ? 'required' : '' }} />
</div>
<div class="wrapper d-flex justify-content-end">
  <button class="btn btn-submit text-white px-5 btn-warning" type="submit">Submit</button>
</div>