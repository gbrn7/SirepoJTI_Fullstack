@extends('layouts.base')

@section('title', 'User Management')

@section('custom_css_link', asset('Css/Data-Management_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">User Management</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item">
        <a href="{{route('home')}}" class="text-decoration-none">Home</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">User Management</li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="main-content">
  <div class="action-wrapper d-lg-flex mt-3 justify-content-between align-items-baseline">
    <div class="wrapper">
      <a href="{{route('user-management.create')}}" class="btn btn-success">
        <div class="wrapper d-flex gap-2 align-items-center">
          <i class="ri-add-line"></i>
          <span class="fw-medium">Add User</span>
        </div>
      </a>
    </div>
    <div class="wrapper mt-2 mt-lg-0">
      <form action="{{route('user-management.index')}}">
        <div class="input-group">
          <input type="text" class="form-control py-2 px-3 author-input search-input border-0" placeholder="Search"
            name="author" value="{{ request()->get('author')}}" />
          <button type="submit" class="input-group-text  btn btn-danger d-flex align-items-center fs-5 px-3"
            id="basic-addon2">
            <i class="ri-search-line"></i>
          </button>
        </div>
      </form>
    </div>
  </div>
  <div class="table-wrapper mb-2 overflow-auto">
    <table id="category-table" class="table mt-3 table-hover" style="width: 100%">
      <thead>
        <tr>
          <th class="text-white fw-medium">No.</th>
          <th class="text-white fw-medium">Name</th>
          <th class="text-white fw-medium">Username</th>
          <th class="text-white fw-medium">Email</th>
          <th class="text-white fw-medium">Document Count</th>
          <th class="text-white fw-medium">Action</th>
        </tr>
      </thead>
      <tbody id="tableBody">
        @forelse ($users as $user)
        <tr>
          <td>{{$user->id}}</td>
          <td>{{$user->name}}</td>
          <td>{{$user->username}}</td>
          <td>{{$user->email}}</td>
          <td>{{$user->document_count}}</td>
          <td class="d-flex gap-1">
            <div class="btn btn-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal"
              data-name="{{$user->name}}" data-delete-link="{{route('user-management.destroy', $user->id)}}">
              Delete</div>
            <a href="{{route('user-management.edit', $user->id)}}" class="btn btn-warning edit-btn text-white">Edit</a>
            <a href="{{route('user-management.document-management.index', $user->id)}}"
              class="btn edit-btn btn-detail text-white">Detail</a>
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
  <div class="pagination-box d-flex justify-content-end">
    {{$users->links('pagination::simple-bootstrap-5')}}
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
        <h4 class="text-center">Are you sure to delete <span class="user-name"></span> user ?</h4>
      </div>
      <form action="" method="post" id="deleteForm">
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

@endsection

@push('js')
<script>
  $(document).on('click', '.delete-btn', function(event){
        let name = $(this).data('name');
        let deleteLink = $(this).data('delete-link');

        $('#deleteModal').modal('show');
        $('.user-name').html(name);

        $('#deleteForm').attr('action', deleteLink);
      });

  $('.author-input').on('input', debounce(function (e) {
    let authorinput = e.target.value;

    $.get("{{route('getSuggestionAuthor')}}", {
      title : authorinput
    },
      function (data, textStatus, jqXHR) {
        if (data.length !== 0) {
          $('#authorListOption').empty();
        }
        data.forEach(e => {
          $('#authorListOption').append($('<option>', {
            value: e.title
          }));
        }); 
      },
    );
  }, 300));
</script>
@endpush