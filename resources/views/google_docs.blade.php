@extends('layouts.app')

@push('stylesheet')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.css">
@endpush

@section('content')
    <div class="container">
        <h2>Google Docs</h2>
        <table class="table table-bordered" id="users-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Google Doc ID</th>
                <th>Hubspot Form</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th><button type="submit" class="center-block btn btn-default">Grab All</button></th>
                <th>&nbsp;</th>
            </thead>
        </table>
        <form action="{{ url('google_doc') }}" method="get">
            <button type="submit" class="btn btn-default">Add</button>
        </form>
    </div>
@endsection




@push('scripts')
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>
<script>
    $(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('datatables') !!}',
            columns: [
                { data: 'doc_name' },
                { data: 'doc_id' },
                { data: 'doc_range' }
            ]
        });
    });
</script>
@endpush
