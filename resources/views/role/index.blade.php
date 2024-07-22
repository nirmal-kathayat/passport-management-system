@extends('layouts.default')
@section('title','Roles')
@section('content')
<div class="inner-section-wrappe">
  <div class="create-link">
    <a href="{{route('admin.role.create')}}">Add Role</a>
  </div>

  <div class="data-table-wrapper">
    <table id="permission-table" class="table">
      <thead>
        <tr>
          <th>S.No</th>
          <th>Name</th>
          <th>Permissions</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@endsection
@push('style')
<link rel="stylesheet" type="text/css" href="{{asset('vendor/datatable/jquery.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendor/datatable/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@endpush
@push('js')
<script type="text/javascript" src="{{asset('vendor/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatable/dataTables.bootstrap.min.js')}}"></script>
<script type="text/javascript">
  const dataTable = $('#permission-table').DataTable({
    processing: true,
    serveSide: true,
    responsive: true,
    ajax: {
      url: "{{route('admin.role')}}",

    },
    columns: [{
        data: 'id',
        name: 'id',
        searchable: false,
        render: function(data, type, full, meta) {
          return full?.DT_RowIndex
        }
      },
      {
        data: 'name',
        name: 'name',
        orderable: false,
      },
      {
        data: 'permissions',
        name: 'permissions',
        orderable: false,
      },
      {
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false,
        render: function(data, type, full, meta) {
          var editUrl =
            "{{ route('admin.role.edit', ['id' => ':id']) }}"
            .replace(':id', full.id);
          var deleteUrl =
            "{{ route('admin.role.delete', ['id' => ':id']) }}".replace(':id', full.id);
          var editButton =
            '<a class="primary-btn" href="' + editUrl + '"><i class="fa fa-pencil"></i></a>';
          var deleteButton =
            `<button type="button" class="danger-btn confirm-modal-open" href=${deleteUrl}><i class="fa fa-trash"></i></button>`;
          var actionButtons =
            `<div style='display:flex;column-gap:10px'> ${editButton} ${deleteButton}</div>`;
          return actionButtons
        }
      }
    ]
  })
</script>
@endpush