@extends('layouts.base')

@section('title', $user->name.' Document')

@section('custom_css_link', asset('Css/Data-Management_style/main.css'))

@section('breadcrumbs')
<div class="breadcrumbs-box mt-1 py-2">
  <div class="page-title mb-1">{{$user->name.' Document'}}</div>
  <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item">
        <a href="{{route('home')}}" class="text-decoration-none">Home</a>
      </li>
      <li class="breadcrumb-item" aria-current="page">
        <a href="{{route('user-management.index')}}" class="text-decoration-none">User Management</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">{{$user->name.' Document'}}</li>
    </ol>
  </nav>
</div>
@endsection

@section('main-content')
<div class="main-content">
  <div class="action-wrapper d-lg-flex mt-3 justify-content-between align-items-baseline">
    <div class="wrapper">
      <a href="{{route('user-management.document-management.create', $user->id)}}" class="btn btn-success">
        <div class="wrapper d-flex gap-2 align-items-center">
          <i class="ri-add-line"></i>
          <span class="fw-medium">Add Document</span>
        </div>
      </a>
    </div>
    <div class="wrapper mt-2 mt-lg-0">
      <div class="input-group">
        <input type="text" class="form-control py-2 px-3 search-input border-0" placeholder="Search" />
        <div class="input-group-text btn btn-danger d-flex align-items-center fs-5 px-3" id="basic-addon2">
          <i class="ri-search-line"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="table-wrapper mb-2 pb-5">
    <table id="dataTable" class="table mt-3 table-hover" style="width: 100%">
      <thead>
        <tr>
          <th class="text-white fw-medium">No.</th>
          <th class="text-white fw-medium">Title</th>
          <th class="text-white fw-medium">Action</th>
        </tr>
      </thead>
      <tbody id="tableBody">
        @forelse ($user->document as $item)
        <tr>
          <td>{{$item->id}}</td>
          <td>{{$item->title}}</td>
          <td class="d-flex gap-1">
            <div class="btn btn-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal"
              data-category="{{$item->title}}"
              data-delete-link="{{route('user-management.document-management.destroy', [$user->id, $item->id])}}">
              Delete</div>
            <a href="{{route('user-management.document-management.edit', [$user->id, $item->id])}}"
              class="btn text-decoration-none btn-warning edit-btn text-white">Edit</a>
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
</div>


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Delete Document</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 class="text-center">Are you sure to delete <span class="document-title"></span> document ?</h4>
      </div>
      <form action="" method="post" id="deleteForm">
        @method('delete')
        @csrf
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" id="deletecriteria" class="btn btn-submit btn-danger">Delete</button>
      </form>
    </div>
  </div>
</div>
</div>

@endsection

@push('js')
<script>
  $(document).on('click', '.delete-btn', function(event){
        let title = $(this).data('title');
        let deleteLink = $(this).data('delete-link');

        $('#deleteModal').modal('show');
        $('.document-title').html(title);

        $('#deleteForm').attr('action', deleteLink);
      });

      @if(count($user->document)>0)
      $('.search-input').keyup(function() {
          let table = $('#dataTable').DataTable();
          table.search($(this).val()).draw();
      });

      $('#dataTable').DataTable( {
      order: [[0, 'desc']]
      });        
      @endif
</script>
@endpush