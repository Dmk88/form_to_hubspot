@extends('layouts.app')

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
                    <div class="col-sm-6">{{ $google_doc->hubspot_form->form_name }}</div>
                </div>
            </div>
        </div>

        <p>Form data from google sheet:</p>
        <p>Count: {{ count($google_doc->form_data )}}</p>
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
            </tr>
            </thead>
            <tbody>
            @foreach ($google_doc->form_data as $form_d)
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
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
