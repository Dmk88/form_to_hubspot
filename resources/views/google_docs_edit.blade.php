@extends('layouts.app')

@section('content')
    <div class="panel-body">
        @include('common.errors')
        <form action="{{ url('google_doc/'. $google_doc->id) }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="doc_name" class="col-sm-3 control-label">Name</label>

                <div class="col-sm-6">
                    <input type="text" name="doc_name" id="doc-name" class="form-control" value="{{
                    $google_doc->doc_name }}">
                </div>
            </div>
            <div class="form-group">
                <label for="doc_id" class="col-sm-3 control-label">Google Doc ID</label>

                <div class="col-sm-6">
                    <input type="text" name="doc_id" id="doc-id" class="form-control"
                           value="{{ $google_doc->doc_id }}">
                </div>
            </div>
            <div class="form-group">
                <label for="hubspot_form_id" class="col-sm-3 control-label">Hubspot Form</label>
                <div class="col-sm-6">
                    <select id="hubspot_form_id" name="hubspot_form_id" class="form-control">
                        <option value="">None</option>
                        @foreach($hubspot_forms as $hubspot_form)
                            <option @if($hubspot_form->id == $google_doc->hubspot_form_id)
                                    selected="selected"
                                    @endif
                                    value="{{$hubspot_form->id}}">{{$hubspot_form->form_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="doc_range" class="col-sm-3 control-label">Range</label>

                <div class="col-sm-6">
                    <input type="text" name="doc_range" id="doc_range" class="form-control"
                           value="{{ $google_doc->doc_range }}">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3"><h3>Exclusion</h3></div>
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
@endsection
