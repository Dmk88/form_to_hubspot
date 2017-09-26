@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Google Docs</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Google Drive Folder`s ID</th>
                <th>Hubspot Form</th>
                <th>Grab from Line</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>
                    <form action="{{ url('google_doc/grab_all') }}">
                        <button type="submit" class="center-block btn btn-default">Grab All</button>
                    </form>
                </th>
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
                    <td>@if($google_doc->hubspot_form)
                            {{ $google_doc->hubspot_form->form_name }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        {{ $google_doc->doc_range }}
                    </td>
                    <td>
                        <form action="{{ url('google_doc/'. $google_doc->id) }}">
                            <button type="submit" class="btn btn-success">View</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ url('google_doc/'. $google_doc->id . '/edit/') }}">
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ url('google_doc/'. $google_doc->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ url('google_doc/'. $google_doc->id . '/grab/') }}">
                            <button type="submit" class="center-block btn btn-default">Grab</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <form action="{{ url('google_doc') }}" method="get">
            <button type="submit" class="btn btn-default">Add</button>
        </form>
    </div>
@endsection