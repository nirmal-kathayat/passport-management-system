@extends('layouts.default')
@section('title','Demands')
@section('content')
<div class="inner-section-wrapper">
    <div class="filter-wrapper">
        <div class="flex-row justify-space-between align-center">
            <div class="search-wrapper">
                <input type="text" name="search">
                <i class="fa fa-search"></i>
            </div>
            
        </div>
        <div class="grey-bg filter-fields-wrapper">
            <form method="get" class="filter-submit-form">
                <div class="grid-row col-gap-10 row-gap-20 template-repeat-3">
                    <div class="form-group group-row ">
                        <label>From Date</label>
                        <input type="date" name="from_date">
                    </div>
                    <div class="form-group group-row">
                        <label>Country</label>
                        <select name="country">
                            <option value="">Select</option>
                            @foreach($countries as $country)
                            <option value="{{$country->id}}">{{$country->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group group-row">
                        <label>Experience</label>
                        <select name="experience">
                            <option value="">Select</option>
                            @foreach($experiences as $experience)
                            <option value="{{$experience->id}}">{{$experience->experience}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group group-row ">
                        <label>To Date</label>
                        <input type="date" name="to_date">
                    </div>
                </div>
                <div class="form-group group-column filter-submit-wrapper">
                    <button class="primary-btn">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="data-table-wrapper">
        <table id="demand-table" class="table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Country</th>
                    <th>Salary</th>
                    <th>Experience</th>
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
    const dataTable = $('#demand-table').DataTable({
        processing: true,
        serveSide: true,
        responsive: true,
        searching: false,
        ordering: false,
        ajax: {
            url: "{{route('admin.demand')}}",

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
                data: 'date',
                name: 'date',
                orderable: false,
                searchable: false,
            },
            {
                data: 'title',
                name: 'title',
                orderable: false,
                searchable: false,
            },
            {
                data: 'country_name',
                name: 'country_name',
                orderable: false,
                searchable: false
            },
            {
                data: 'salary',
                name: 'salary',
                orderable: false,
                searchable: false
            },
            {
                data: 'experience',
                name: 'experience',
                orderable: false,
                searchable: false
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function(data, type, full, meta) {
                    var editUrl =
                        "{{ route('admin.demand.edit', ['id' => ':id']) }}"
                        .replace(':id', full.id);
                    var deleteUrl =
                        "{{ route('admin.demand.delete', ['id' => ':id']) }}".replace(':id', full.id);

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
    $('.search-wrapper input').on('change', function() {
        const val = $(this).val()
        $('.excel-export-form input[name=search]').val(val)

        dataTable.ajax.url("{{ route('admin.demand') }}?search=" + val).load();
    })
    $('.filter-btn').on('click', function() {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active')
            $('.filter-fields-wrapper').fadeOut()
        } else {
            $(this).addClass('active')
            $('.filter-fields-wrapper').fadeIn()

        }
    })

    $('.filter-submit-form').on('submit', function(event) {
        event.preventDefault()
        const formData = $(this).serialize()
        const arrayData = $(this).serializeArray()
        arrayData?.forEach(item => {
            $(`.excel-export-form input[name=${item?.name}]`).val(item?.value)
        })
        dataTable.ajax.url("{{ route('admin.demand') }}?" + formData).load();
    })
</script>
@endpush