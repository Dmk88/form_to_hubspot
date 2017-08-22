@extends('layouts.app')

@push('stylesheet')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.css">
@endpush

@section('content')
    <div class="container">
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
                    <label class="col-sm-3 control-label">Google Doc ID</label>
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
        <div class="form-inline">
            <div class="input-group" id="datepicker">
                <span class="input-group-addon">Date Range:</span>
                {!! Form::input('date', 'start_date', Carbon::now()->format('Y-m-d'), ['class' => 'form-control']) !!}
                <span class="input-group-addon">to</span>
                {!! Form::input('date', 'end_date', Carbon::now()->format('Y-m-d'), ['class' => 'form-control']) !!}
            </div>
            <button type="button" id="dateSearch" class="btn btn-sm btn-primary">Search</button>
        </div>
        <p>Total count: {{ count($google_doc->form_data )}}</p>
        <div class="box-body table-responsive">
            <table class="table table-striped" id="form_data-table">
                <thead>
                <tr>
                    <th>Email</th>
                    <th>First Nname</th>
                    <th>Last Name</th>
                    <th>Organization</th>
                    <th>Product File</th>
                    <th>File Type</th>
                    <th>Release</th>
                    <th>Grab Date</th>
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
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! route( 'google_doc.form_data', [ 'id' => $google_doc->id ]) !!}',
                data: function (d) {
                    d.start_date = $('input[name="start_date"]').val();
                    d.end_date = $('input[name="end_date"]').val();
                }
            },
            columns: [
                {data: 'email'},
                {data: 'first_name'},
                {data: 'last_name'},
                {data: 'organization'},
                {data: 'product_file'},
                {data: 'file_type'},
                {data: 'release'},
                {data: 'created_at'}
            ]
        });
        $('#dateSearch').on('click', function () {
            formTable.draw();
        });
    });
</script>
@endpush
