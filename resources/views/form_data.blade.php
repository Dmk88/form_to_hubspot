@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Form Data</h2>
        @foreach ($google_docs as $google_doc)
            <p>Form data from google sheet {{ $google_doc->doc_id }}:</p>
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
        @endforeach
    </div>
@endsection
