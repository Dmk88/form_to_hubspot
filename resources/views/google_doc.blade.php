@extends('layouts.app')

@push('stylesheet')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.css">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="panel-body">
            @include('common.errors')
            <div class="form-horizontal">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-sm-3 control-label">Name</label>
                    <div class="col-sm-6">
                        {{ $google_doc->doc_name }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Google Drive Folder`s ID</label>
                    <div class="col-sm-6">{{ $google_doc->doc_id }}</div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Hubspot Form</label>
                    <div class="col-sm-6">
                        @if($google_doc->hubspot_form)
                            {{ $google_doc->hubspot_form->form_name }}
                        @else
                            -
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Range for Grab</label>
                    <div class="col-sm-6">{{ $google_doc->doc_range }}</div>
                </div>
            </div>
        </div>
        <p>Form data from google sheet:</p>
        @if(!empty($grabCount))
            <p class="alert-danger">Grab count: {{ $grabCount }}</p>
        @endif
        <div class="form-inline">
            <div class="input-group" id="datepicker">
                <span class="input-group-addon">Date Range:</span>
                {!! Form::input('date', 'start_date', Carbon::now()->format('Y-m-d'), ['class' => 'form-control']) !!}
                <span class="input-group-addon">to</span>
                {!! Form::input('date', 'end_date', Carbon::now()->addDays(1)->format('Y-m-d'), ['class' => 'form-control']) !!}
            </div>
            <button type="button" id="dateSearch" class="btn btn-sm btn-primary">Search</button>
        </div>
        <p>Total count: {{ count($google_doc->form_data )}}</p>
        <div class="box-body table-responsive">
            <table class="table table-striped" id="form_data-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>First Nname</th>
                    <th>Last Name</th>
                    <th>Organization</th>
                    <th>Product File</th>
                    <th>File Type</th>
                    <th>Release</th>
                    <th>Download Date</th>
                    <th>Grab Date</th>
                    <th></th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>
<script>
    $(function () {
        var formTable = $('#form_data-table').DataTable({
            autoWidth: false,
            responsive: true,
            processing: true,
            serverSide: true,
            lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "All"]],
            ajax: {
                url: '{!! route( 'google_doc.form_data', [ 'id' => $google_doc->id, 'grab' => $flags['grab'] ]) !!}',
                data: function (d) {
                    d.start_date = $('input[name="start_date"]').val();
                    d.end_date = $('input[name="end_date"]').val();
                }
            },
            columns: [
                {data: 'id', class: 'id-elem'},
                {data: 'email'},
                {data: 'first_name'},
                {data: 'last_name'},
                {data: 'organization'},
                {data: 'product_file'},
                {data: 'file_type'},
                {data: 'release'},
                {data: 'download_date'},
                {data: 'created_at'},
                {
                    "orderable": false,
                    "searchable": false,
                    "data": null,
                    "id": 'id',
                    "defaultContent": '<button class="delete_form_data_row btn btn-danger">Del</button>'
                }
            ]
        });
        $('#dateSearch').on('click', function () {
            formTable.draw();
        });
        formTable.on('click', '.delete_form_data_row', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/form_data/' + $(this).closest('tr').find('.id-elem').text(),
                type: 'DELETE',
                dataType: 'json',
                data: {method: '_DELETE', submit: true}
            }).always(function (data) {
                formTable
                        .row($(this).parents('tr'))
                        .remove()
                        .draw();
            });
        });
    });
</script>
@endpush
