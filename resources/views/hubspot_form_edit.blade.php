@extends('layouts.app')

@section('content')
    <div class="panel-body">
        @include('common.errors')
        <form action="{{ url('hubspot_form/'. $hubspot_form->id) }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="form_name" class="col-sm-3 control-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" name="form_name" id="form_name" class="form-control" value="{{
                    $hubspot_form->form_name }}">
                </div>
            </div>
            <div class="form-group">
                <label for="portal_id" class="col-sm-3 control-label">Portal ID</label>
                <div class="col-sm-6">
                    <input type="text" name="portal_id" id="portal_id" class="form-control"
                           value="{{ $hubspot_form->portal_id }}">
                </div>
            </div>
            <div class="form-group">
                <label for="form_guid" class="col-sm-3 control-label">Form GUID</label>
                <div class="col-sm-6">
                    <input type="text" name="form_guid" id="form_guid" class="form-control"
                           value="{{ $hubspot_form->form_guid }}">
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
@endsection
