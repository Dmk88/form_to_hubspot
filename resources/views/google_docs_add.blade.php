@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Add new Google Doc</h2>
        <div class="panel-body">
            @include('common.errors')
            <form action="{{ url('google_doc') }}" method="POST" class="form-horizontal">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="doc_name" class="col-sm-3 control-label">Name</label>
                    <div class="col-sm-6">
                        <input type="text" name="doc_name" id="doc-name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="doc_id" class="col-sm-3 control-label">Google Drive Folder`s ID</label>

                    <div class="col-sm-6">
                        <input type="text" name="doc_id" id="doc-id" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="hubspot_form_id" class="col-sm-3 control-label">Hubspot Form</label>
                    <div class="col-sm-6">
                        <select id="hubspot_form_id" name="hubspot_form_id" class="form-control">
                            <option value="">None</option>
                            @foreach($hubspot_forms as $hubspot_form)
                                <option value="{{$hubspot_form->id}}">{{$hubspot_form->form_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <button type="submit" class="btn btn-default">
                            <i class="fa fa-plus"></i> Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
