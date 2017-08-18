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
        <p>Total count: {{ count($google_doc->form_data )}}</p>
        <table class="table table-striped">
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
            <tbody>
            @foreach ($google_doc->form_data()->orderBy('created_at', 'desc')->limit(10)->get() as $form_d)
                <tr class="">
                    <td>
                        {{ $form_d->email }}
                    </td>
                    <td>
                        {{ $form_d->first_name }}
                    </td>
                    <td>
                        {{ $form_d->last_name }}
                    </td>
                    <td>
                        {{ $form_d->organization }}
                    </td>
                    <td>
                        {{ $form_d->product_file }}
                    </td>
                    <td>
                        {{ $form_d->file_type }}
                    </td>
                    <td>
                        {{ $form_d->release }}
                    </td>
                    <td>
                        {{ $form_d->created_at }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>
@endpush
