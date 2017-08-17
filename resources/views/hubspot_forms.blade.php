@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Hubspot Forms</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Portal ID</th>
                <th>Form GUID</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </thead>
            <tbody>
            @foreach ($hubspot_forms as $hubspot_form)
                <tr>
                    <td>
                        {{ $hubspot_form->form_name }}
                    </td>
                    <td>
                        {{ $hubspot_form->portal_id }}
                    </td>
                    <td>
                        {{ $hubspot_form->form_guid }}
                    </td>
                    <td>
                        <form action="{{ url('hubspot_form/'. $hubspot_form->id . '/edit/') }}">
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ url('hubspot_form/'. $hubspot_form->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <form action="{{ url('hubspot_form') }}" method="get">
            <button type="submit" class="btn btn-default">Add</button>
        </form>
    </div>
@endsection
