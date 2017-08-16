@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Form Data</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Google Doc ID</th>
                <th>Hubspot Form</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </thead>
            <tbody>
            @foreach ($google_docs as $google_doc)
                <tr>
                    <td>
                        {{ $google_doc->doc_name }}
                    </td>
                    <td>
                        {{ $google_doc->doc_id }}
                    </td>
                    <td>
                        {{ $google_doc->hubspot_form->id }}
                    </td>
                    <td><button type="button" class="btn btn-success">View</button></td>
                    <td><button type="button" class="btn btn-primary">Edit</button></td>
                    <td><button type="button" class="btn btn-danger">Delete</button></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
